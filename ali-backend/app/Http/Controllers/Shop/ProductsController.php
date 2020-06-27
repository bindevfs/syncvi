<?php

namespace App\Http\Controllers\Shop;

use App\Services\Shop\Product\ProductService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;
use App\Http\Controllers\Controller;

/**
 * Class ProductsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProductsController extends Controller
{
    protected $productService;

    /**
     * ProductsController constructor.
     *
     * @param ProductRepository $repository
     * @param ProductValidator $validator
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function productsRequesting(Request $request)
    {
        $data = $this->productService->requestedProduct($request);
        if($data['status']) {
            //dd($data['products']);
            return view('shop.repo.content')->with(array('products' => $data['products'], 'shop' => $data['shop']));
        }
        return redirect()->back();
    }

    public function dialogDetailRepo(Request $request)
    {
        if($request->ajax()) {
            $data = $this->productService->detailRepo($request);
            if($data['status']) {
                $detail = view('shop.repo.order_products_render')->with(array('orderProducts' => $data['orderProducts'], 'product' => $data['product']))->render();
                return json_encode(array('detail' => $detail) );
            } else {
                return json_encode(array('detail' => 'Have an error!') );
            }
        }
        return json_encode(array('detail' => 'Have an error!') );
    }

    public function updateStatusOrderProduct(Request $request)
    {
        if($request->ajax()) {
            $data = $this->productService->updateStatusOrderProduct($request);
            if($data['status']) {

                return json_encode(array('status' => true));
            } else {
                return json_encode(array('status' => false) );
            }
        }
        return json_encode(array('status' => false) );
    }
}
