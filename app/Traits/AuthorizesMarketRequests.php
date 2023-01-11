<?php

namespace App\Traits;

use App\Services\MarketAuthenticationService;

trait AuthorizesMarketRequests
{
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();

        $headers['Authorization'] = $accessToken;
    }

    
    public function resolveAccessToken()
    {
        return 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiODc5YmUyOTFhODdhMjAyMzQxNDQ3MmUyOTZhYjFhNzVmNGY4ZWMyNTYwZDc0MzNlMmY5NDdhY2QyODU5Yzc0YzhmNDA0NjgwYTJjMDYyZTIiLCJpYXQiOiIxNjcyOTM2NTE2LjM0MTA0NyIsIm5iZiI6IjE2NzI5MzY1MTYuMzQxMDUyIiwiZXhwIjoiMTcwNDQ3MjUxNi4zMzY5NDEiLCJzdWIiOiIxMzAxIiwic2NvcGVzIjpbInB1cmNoYXNlLXByb2R1Y3QiLCJtYW5hZ2UtcHJvZHVjdHMiLCJtYW5hZ2UtYWNjb3VudCIsInJlYWQtZ2VuZXJhbCJdfQ.LJ8Hc8frJVrasKm95g9giZf5Aa7Lu6vAjKbucmDdEigyN2rEwH4jMYglnzfyGJIVirERCup_axxELcxAhX39hXX7FJMNSpMyaOSHBW4vKlcYIkTgkDi6qclg_jfgro5q4aiXCuXpsTjaT6mOrL1UAQppbtO3cjgmH2Y5V92xX3MblBonIjMRCI2rFb-XdzoL69BgjAaDd0Iq1LhvLQwtn0M5snmjPsGGZzzKsr4BoMzuJgZp1-Uc62eqJmA9cIkCHkAPjbz2yDgTSLcMiPIOKNXr-uHXWqA-2jCiXDfsKYRox_EctV6AkE33cEU2278A_PUlhagwTnBLYM3yITq2TU83tIMyzsItDyhoqX8c637Vx3xJxZwJvE7mE6LdhpQ67YGVRgqEorxF6ntbJkAvcy-xMZJUvHwJ5yKHpoNoIxL_tg8TAc4CcupxjwHKFUr4wZLF8xHCWc_pOxMwMwz4I7WZgekJ7zo_dwUa9XoW0-mwIxLh-evr64_Xv_e1rPnl0pQsofzoB3RQ0zdesmZxOjFjE8AekxhQXjZOSPgV8BQjw4PUWuuwMF3EB17sDcN752IZ-7bkhmnHN4a1A6AlJHxMqjIYo9srKmmS-onIZdt-GFDxdGehgWMEGx3V__7VAseN607cYQxrtWW9akuXYr1N_VW_4GL7BgYlzhzDSmw';
    }
    /* va este pero me tira error
    public function resolveAccessToken()
    {

        $authenticationService = resolve(MarketAuthenticationService::class);

        return $authenticationService->getClientCredencialsToken();

    }
    */
}