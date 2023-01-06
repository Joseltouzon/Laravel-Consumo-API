<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;
use App\Traits\AuthorizesMarketRequests;
use App\Traits\InteractsWithMarketResponses;

class MarketService
{

    use ConsumesExternalServices, AuthorizesMarketRequests, InteractsWithMarketResponses;

    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.market.base_uri');
    }

    public function getProducts()
    {
        return $this->makeRequest('GET', 'products');
    }

    public function getProduct($id)
    {
        return $this->makeRequest('GET', "products/{$id}");
    }
    
    public function getCategories()
    {
        return $this->makeRequest('GET', 'categories');
    }

    public function getCategoryProducts($id)
    {
        return $this->makeRequest('GET', "categories/{$id}/products");
    }

}