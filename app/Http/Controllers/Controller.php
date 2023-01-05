<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\MarketService;

class Controller extends BaseController
{

    protected $marketService;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(MarketService $marketService)
    {
        $this->marketService = $marketService;
    }

}
