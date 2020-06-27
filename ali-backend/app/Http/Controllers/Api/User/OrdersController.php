<?php

namespace App\Http\Controllers\Api\User;

use App\Entities\Order;
use App\Http\Requests\Api\User\AddToCartRequest;
use App\Http\Requests\Api\User\ViewOrderRequest;
use App\Services\User\Order\OrderService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\OrderRepository;
use App\Validators\OrderValidator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\OrderRequest;

/**
 * Class OrdersController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrdersController extends Controller
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * OrdersController constructor.
     *
     * @param OrderRepository $repository
     * @param OrderValidator $validator
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function addToCart(AddToCartRequest $request)
    {
        $data = $this->orderService->addToCart($request);
        if($data['status']) {
            return $this->responseAjaxSuccess('', $data['order_product']);
        }

        return $this->responseAjaxFail();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewCart(Request $request)
    {
        $data = $this->orderService->viewCart($request);

        return $this->responseSuccess('', array('listProduct' => $data['listProduct'], 'user' => $data['user']));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function order(OrderRequest $request)
    {
        $data = $this->orderService->order($request);
        if($data['status']) {
            return $this->responseSuccess('', $data['order']);
        }

        return $this->responseFail();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listOrder(Request $request)
    {
        $data = $this->orderService->listOrder($request);

        return $this->responseSuccess('', $data['listOrder']);
    }

    public function viewOrder(ViewOrderRequest $request)
    {
        $data = $this->orderService->viewOrder($request);

        if($data['status']) {
            return $this->responseSuccess('', array('order' => $data['order'], 'listProduct' => $data['listProduct']));
        }

        return $this->responseFail($request);
    }

    public function cancelOrder(ViewOrderRequest $request)
    {
        $data = $this->orderService->cancelOrder($request);

        if($data['status']) {
            return $this->responseSuccess();
        }
        return $this->responseFail($data['message']);
    }

    public function allOrderRejected(Request $request)
    {
        $data = $this->orderService->allOrderRejected();
        if($data['status']) {
            return $this->responseSuccess('', array('orders' => $data['orders']));
        }
        return $this->responseFail();
    }

    public function commentOrder(Request $request)
    {
        $data = $this->orderService->comments($request);
        if($data['status']) {
            return $this->responseSuccess('Success', array('comment' => $data['comment']));
        }
        return $this->responseFail('Error');
    }

    public function getComments(Request $request)
    {
        $data = $this->orderService->getComments($request);
        if($data['status']) {
            return $this->responseSuccess('', array('comments' => $data['comments']));
        }
        return $this->responseFail('Error');
    }
}
