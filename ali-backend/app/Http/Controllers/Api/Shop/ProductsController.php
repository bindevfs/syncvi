<?php

namespace App\Http\Controllers\Api\Shop;

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

    /**
     * @SWG\POST(
     *      path="/api/shop/addproduct",
     *      operationId="addProduct",
     *      tags={"Shop's product"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="product_name",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="thumbnails",
     *       in="formData",
     *       required=true,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="cost",
     *       in="formData",
     *       required=true,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="sell_price",
     *       in="formData",
     *       required=true,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="description",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="image",
     *       in="formData",
     *       required=false,
     *       type="array",
     *       items=@SWG\Items(
     *         type="string",)
     *     ),
     *     @SWG\Parameter(
     *       name="video",
     *       in="formData",
     *       required=false,
     *       type="array",
     *       items=@SWG\Items(
     *         type="string",)
     *     ),
     *     @SWG\Parameter(
     *       name="product_key",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request"),
     *     )
     *
     */

    public function addProduct(Request $request)
    {
        $data = $this->productService->addProduct($request);
        if($data['status']) {
            return $this->responseSuccess('',array('product' => $data['product'], 'gallery' => $data['gallery']));
        }
        return $this->responseFail();
    }

    /**
     * @SWG\Get(
     *      path="/api/shop/listproduct",
     *      operationId="listProduct",
     *      tags={"Shop's product"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request"),
     *     )
     *
     */

    public function listProduct(Request $request)
    {
        $data = $this->productService->listProduct($request);
        if($data['status']) {
            return $this->responseSuccess('',array('listProduct' => $data['listProduct']));
        }
        return $this->responseFail();
    }

    /**
     * @SWG\GET(
     *      path="/api/shop/viewproduct",
     *      operationId="viewProduct",
     *      tags={"Shop's product"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="product_id",
     *       in="query",
     *       required=true,
     *       type="integer"
     *   ),
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request"),
     *     )
     *
     */

    public function viewProduct(Request $request)
    {
        $data = $this->productService->viewProduct($request);
        if($data['status']) {
            return $this->responseSuccess('',$data['product']);
        }
        return $this->responseFail();
    }

    /**
     * @SWG\POST(
     *      path="/api/shop/updateproduct",
     *      operationId="updateProduct",
     *      tags={"Shop's product"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="product_id",
     *       in="formData",
     *       required=true,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="product_name",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="thumbnails",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="cost",
     *       in="formData",
     *       required=false,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="sell_price",
     *       in="formData",
     *       required=false,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="description",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="image",
     *       in="formData",
     *       required=false,
     *       type="array",
     *       items=@SWG\Items(
     *         type="string",)
     *     ),
     *     @SWG\Parameter(
     *       name="video",
     *       in="formData",
     *       required=false,
     *       type="array",
     *       items=@SWG\Items(
     *         type="string",)
     *     ),
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request"),
     *     )
     *
     */

    public function updateProduct(Request $request)
    {
        $data = $this->productService->updateProduct($request);
        if($data['status']) {
            return $this->responseSuccess('', array('product' => $data['product'], 'gallery' => $data['gallery']));
        }
        return $this->responseFail();
    }

    /**
     * @SWG\POST(
     *      path="/api/shop/filterproduct",
     *      operationId="filterProduct",
     *      tags={"Shop's product"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="perpage",
     *       in="formData",
     *       required=false,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="page",
     *       in="formData",
     *       required=false,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="date1",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="date2",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="price1",
     *       in="formData",
     *       required=false,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="price2",
     *       in="formData",
     *       required=false,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="search",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request"),
     *     )
     *
     */

    public function filterProduct(Request $request)
    {
        $data = $this->productService->filterProduct($request);
        if($data['status']) {
            return $this->responseSuccess('', array('page_current' => $data['page_current'], 'products' => $data['products'], 'total_data' => $data['total_data']));
        }
        return $this->responseFail();
    }
}
