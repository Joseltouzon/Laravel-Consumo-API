<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function ShowProduct($title, $id)
    {
        $product = $this->marketService->getProduct($id);
        
        return view('products.show')->with([
            'product' => $product,
        ]);
    }
}
