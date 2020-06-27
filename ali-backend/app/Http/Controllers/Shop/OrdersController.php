<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\Admin\ShopRequest\FilterShopRequest;
use App\Services\Shop\ManageShop\ManageShopService;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Shop\ViewOrderRequest;
use App\Repositories\OrderRepository;
use App\Validators\OrderValidator;
use App\Http\Controllers\Controller;
use App\Services\Shop\Order\OrderService;
use Illuminate\View\View;

/**
 * Class OrdersController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrdersController extends Controller
{
    protected $manageShopService;
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
    public function __construct(OrderService $orderService, ManageShopService $manageShopService)
    {
        $this->orderService = $orderService;
        $this->manageShopService = $manageShopService;
    }

    public function newOrder(Request $request)
    {
        $data = $this->orderService->newOrder($request);
        if($data['status']) {
            $temp = $this->manageShopService->getShopInfo();
            return view('shop.processing.new')->with(array('orders' => $data['listOrder'], 'shop' => $temp['shop']));
        }
        return redirect()->back();
    }

    public function authenticatedOrder(Request $request)
    {
        $data = $this->orderService->authenticatedOrder($request);
        if($data['status']) {
            $temp = $this->manageShopService->getShopInfo();
            return view('shop.processing.authed')->with(array('orders' => $data['listOrder'], 'shop' => $temp['shop']));
        }
        return redirect()->back();
    }

    public function dialogDetailOrder(Request $request)
    {
        if($request->ajax()) {
            $data = $this->orderService->viewOrder($request);
            if($data['status']) {
                $temp = $this->manageShopService->getShopInfo();
                return json_encode(array('detail' => view('shop.order.render')->with(array('shop' => $temp['shop'],'comment' => $data['comment'],'products' => $data['listProduct'],'order' => $data['order'],'user' => $data['user']))->render()));
            } else {
                return json_encode(array('detail' => 'Failed!'));
            }
        }
        return json_encode(array('detail' => 'Failed!'));
    }

    public function authenticateOrder(Request $request)
    {
        if($request->ajax()) {
            $data = $this->orderService->authenticateOrder($request);
            if($data['status']) {
                return json_encode(array('status' => true));
            }
            return json_encode(array('status' => false));
        }
        return json_encode(array('status' => false));
    }

    public function rejectOrder(Request $request)
    {
        if($request->ajax()) {
            $data = $this->orderService->rejectOrder($request);
            if($data['status']) {
                return json_encode(array('status' => true));
            }
            return json_encode(array('status' => false));
        }
        return json_encode(array('status' => false));
    }

    public function allOrder(Request $request)
    {
        $data = $this->orderService->allOrder($request);
        if($data['status']) {
            $temp = $this->manageShopService->getShopInfo();
            return view('shop.order.content',[
                'orders' => $data['listOrder'],
                'shop' => $temp['shop'],
                'count' => $data['count'],
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function updateOrder(ViewOrderRequest $request)
    {
        if($request->ajax()) {
            $data = $this->orderService->updateOrder($request);
            if($data['status']) {
                return json_encode(array('status' => true));
            }
            return json_encode(array('status' => false));
        }
        return json_encode(array('status' => false));
    }

    public function filterOrder(FilterShopRequest $request)
    {
        if($request->ajax()) {
            $data = $this->orderService->filterOrder($request);
            if($data['status']) {
                $view = view('shop.order.status_render')->with(array('orders' => $data['orders']))->render();
                return json_encode(array('detail' => $view, 'page_current' => $data['page_current'], 'total_data' => $data['total_data']));
            } else {
                return json_encode(array('detail' => 'Failed!'));
            }
        }
        return json_encode(array('detail' => 'Failed!'));
    }

    public function continueOrder(ViewOrderRequest $request)
    {
        if($request->ajax()) {
            $data = $this->orderService->continueOrder($request);
            if($data['status']) {
                return json_encode(array('status' => true));
            }
            return json_encode(array('status' => false));
        }
        return json_encode(array('status' => false));
    }
}
