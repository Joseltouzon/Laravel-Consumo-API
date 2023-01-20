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

    /**
     * publish a product on the api
     * @param int $sellerId
     * @param array $productData
     * @return sdtClass
     */
    public function publishProduct($sellerId, $productData)
    {
        return $this->makeRequest(
            'POST',
            "sellers/{$sellerId}/products",
            [], //$queryParams
            $productData, //esto seria el formParams
            [], //$headers
            $hasFile = true
        );
    }

    /**
     * Associate a created product with an existing category
     * @param int $productId
     * @param int $categoryId
     */
    public function setProductCategory($productId, $categoryId)
    {
        return $this->makeRequest(
            'PUT',
            "products/{$productId}/categories/{$categoryId}",
        );
    }

    /**
     * update a product on the api
     * @param int $sellerId
     * @param int $productId
     * @param array $productData
     * @return sdtClass
     */
    public function updateProduct($sellerId, $productId, $productData)
    {
        $productData['_method'] = 'PUT';
        return $this->makeRequest(
            'POST',
            "sellers/{$sellerId}/products/{$productId}",
            [], //$queryParams
            $productData, //esto seria el formParams
            [], //$headers
            $hasFile = isset($productData['picture']),
        );
    }

    /**
     * Allows to purchase a product
     * @param int $productId
     * @param int $buyerId
     * @param int $quantity
     * @return stdClass
     */
    public function purchaseProduct($productId, $buyerId, $quantity)
    {
        return $this->makeRequest(
            'POST',
            "products/{$productId}/buyers/{$buyerId}/transactions",
            [], //$queryParams
            ['quantity' => $quantity], //esto seria el formParams
        );
    }

    public function getCategories()
    {
        return $this->makeRequest('GET', 'categories');
    }

    public function getCategoryProducts($id)
    {
        return $this->makeRequest('GET', "categories/{$id}/products");
    }

    public function getUserInformation()
    {
        return $this->makeRequest('GET', 'users/me');
    }
   
    /**
     * Obtains a list of purchases
     * @param int $buyerId
     * @return stdClass
     */
    public function getPurchases($buyerId)
    {
        return $this->makeRequest('GET', "buyers/{$buyerId}/products");
    }
   
    /**
     * Obtains a list of publications
     * @param int $sellerId
     * @return stdClass
     */
    public function getPublications($sellerId)
    {
        return $this->makeRequest('GET', "sellers/{$sellerId}/products");
    }
}
