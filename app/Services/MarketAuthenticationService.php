<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;
use App\Traits\AuthorizesMarketRequests;
use App\Traits\InteractsWithMarketResponses;

class MarketAuthenticationService
{

    protected $baseUri;
    protected $clientId;
    protected $clientSecret;
    protected $passwordClientId;
    protected $passwordClientSecret;

    use ConsumesExternalServices, InteractsWithMarketResponses;

    public function __construct()
    {
        $this->baseUri = config('services.market.base_uri');
        $this->clientId = config('services.market.client_id');
        $this->clientSecret = config('services.market.client_secret');
        $this->passwordClientId = config('services.market.password_client_id');
        $this->passwordClientSecret = config('services.market.password_client_secret');
    }

    public function getClientCredencialsToken()
    {
        if ($token = $this->existingValidClientCredencialsToken()) {
            return $token;
        }

        $formParams = [
            'grant_type' => 'client_credencials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'client_credencials');

        return $tokenData->access_token;
    }


    public function resolveAuthorizationUrl()
    {
        $query = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => route('authorization'),
            'response_type' => 'code',
            'scope' => 'purchase-product manage-products manage-account read-general',
        ]);

        return "{$this->baseUri}/oauth/authorize?{$query}";
    }

    public function getCodeToken($code)
    {
        $formParams = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => route('authorization'),
            'code' => $code,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'authorization_code');

        return $tokenData;
    }

    public function getPasswordToken($username, $password)
    {
        $formParams = [
            'grant_type' => 'password',
            'client_id' => $this->passwordClientId,
            'client_secret' => $this->passwordClientSecret,
            'username' => $username,
            'password' => $password,
            'scope' => 'purchase-product manage-products manage-account read-general',
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'password');

        return $tokenData;
    }

    /**
     * Obtains an access token from the authenticated user
     * @return string
     */
    public function getAuthenticatedUserToken()
    {
        $user = auth()->user();

        if (now()->lt($user->token_expires_at)) {
            return $user->access_token;
        }

        return $this->refreshAuthenticatedUserToken($user);
    }

    public function refreshAuthenticatedUserToken($user)
    {
        $clientId = $this->clientId;
        $clientSecret = $this->clientSecret;

        if ($user->grant_type === 'password') {
            $clientId = $this->passwordClientId;
            $clientSecret = $this->passwordClientSecret;
        }

        $formParams = [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $user->refresh_token,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, $user->grant_type);

        $user->fill([
            'access_token' => $tokenData->access_token,
            'refresh_token' => $tokenData->refresh_token,
            'token_expires_at' => $tokenData->token_expires_at,
        ]);

        $user->save();

        return $user->access_token;
    }

    public function storeValidToken($tokenData, $grantType)
    {
        $tokenData->token_expires_at = now()->addSeconds($tokenData->expires_in - 5);

        $tokenData->access_token = "{$tokenData->token_type} {$tokenData->access_token}";

        $tokenData->grant_type = $grantType;

        session()->put(['current_token' => $tokenData]);
    }

    public function existingValidClientCredencialsToken()
    {
        if (session()->has('current_token')) {
            $tokenData = session()->get('current_token');

            if (now()->lt($tokenData->token_expires_at)) {
                return $tokenData->access_token;
            }
        }

        return false;
    }
}
