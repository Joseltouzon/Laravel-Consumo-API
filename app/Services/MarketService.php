<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;

class MarketService
{

    use ConsumesExternalServices;

    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.market.base_uri');
    }

    public function resolveAthorization(&$queryParams, &$formParams, &$headers)
    {
        
    }

    public function decodeResponse($response)
    {

    }

    public function checkIfErrorResponser($response)
    {

    }

}