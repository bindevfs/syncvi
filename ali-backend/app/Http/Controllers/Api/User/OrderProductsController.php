<?php

namespace App\Http\Controllers\Api\User;

use App\Repositories\OrderRepository;
use App\Services\User\OrderProduct\OrderProductService;
use Illuminate\Http\Request;

use App\Http\Requests\Api\User\RemoveOrderProductRequest;
use App\Repositories\OrderProductRepository;
use App\Validators\OrderProductValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

/**
 * Class OrderProductsController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrderProductsController extends Controller
{
    protected $orderProductService;

    /**
     * OrderProductsController constructor.
     *
     * @param OrderProductRepository $repository
     * @param OrderProductValidator $validator
     */
    public function __construct(OrderProductService $orderProductService)
    {
        $this->orderProductService = $orderProductService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeOrderProduct(RemoveOrderProductRequest $request)
    {
        $data = $this->orderProductService->removeOrderProduct($request);
        if($data['status']) {
            return $this->responseSuccess();
        }
        return $this->responseFail($data['message']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrderProduct(RemoveOrderProductRequest $request)
    {
        $data = $this->orderProductService->updateOrderProduct($request);
        if($data['status']) {
            return $this->responseSuccess('', $data['order_product']);
        }
        return $this->responseFail($data['message']);
    }
}
