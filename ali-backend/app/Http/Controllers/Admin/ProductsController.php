<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductRequest\DisableProductRequest;
use App\Services\Admin\ProductService;
use App\Http\Controllers\Controller;

/**
 * Class ProductsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProductsController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function manageProduct()
    {
        $data = $this->productService->manageProduct();
        if($data['status']) {
            return view('admin.products.content',[
                'products' => $data['products'],
            ]);
        }
    }

    public function manageNewProduct()
    {
        $data = $this->productService->manageNewProduct();
        if($data['status']) {
            return view('admin.products.new',[
                'newproducts' => $data['newproducts'],
            ]);
        }
    }

    public function disableProduct(DisableProductRequest $request)
    {
        if($request->ajax()) {
            $data = $this->productService->disableProduct($request);
            if($data['status']) {
                return json_encode(array('success' => true, 'deleted_at' => $data['product']->deleted_at));
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }
}
