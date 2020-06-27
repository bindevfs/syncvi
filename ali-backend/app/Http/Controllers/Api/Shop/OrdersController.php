<?php

namespace App\Http\Controllers\Api\Shop;

use App\Services\Shop\Comment\CommentService;
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
    protected $orderService;

    protected $commentService;

    /**
     * @SWG\SecurityScheme(
     *   securityDefinition="bearerAuth",
     *   type="apiKey",
     *   in="header",
     *   name="Authorization",
     * )
     */

    /**
     * OrdersController constructor.
     *
     * @param OrderRepository $repository
     * @param OrderValidator $validator
     */
    public function __construct(OrderService $orderService, CommentService $commentService)
    {
        $this->orderService = $orderService;
        $this->commentService = $commentService;
    }

    /**
     * @SWG\Get(
     *      path="/api/shop/allorder",
     *      operationId="allOrder",
     *      tags={"Shop's order"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request"),
     *     )
     *
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allOrder(Request $request)
    {
        $data = $this->orderService->allOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('listOrder' => $data['listOrder']) );
        }
        return $this->responseFail();
    }

    /**
     * @SWG\GET(
     *      path="/api/shop/vieworder",
     *      operationId="viewOrder",
     *      tags={"Shop's order"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="order_id",
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

    /**
     * @param ViewOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewOrder(ViewOrderRequest $request)
    {
        $data = $this->orderService->viewOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('order' => $data['order'], 'listProduct' => $data['listProduct'], 'user' => $data['user'], 'comment' => $data['comment']));
        }
        return $this->responseFail();
    }

    /**
     * @SWG\POST(
     *      path="/api/shop/updateorder",
     *      operationId="updateOrder",
     *      tags={"Shop's order"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="order_id",
     *       in="formData",
     *       required=true,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="note",
     *       in="formData",
     *       required=false,
     *       type="string"
     *   ),
     *     @SWG\Parameter(
     *       name="deposit",
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

    public function updateOrder(ViewOrderRequest $request)
    {
        $data = $this->orderService->updateOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('order' => $data['order']));
        }
        return $this->responseFail();
    }

    public function newOrder(Request $request)
    {
        $data = $this->orderService->newOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('listOrder' => $data['listOrder']));
        }
        return $this->responseFail();
    }

    public function authenticatedOrder(Request $request)
    {
        $data = $this->orderService->authenticatedOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('listOrder' => $data['listOrder']));
        }
        return $this->responseFail();
    }

    public function autheticateOrder(Request $request)
    {
        $data = $this->orderService->authenticateOrder($request);
        if($data['status']) {
            return $this->responseSuccess();
        }
        return $this->responseFail();
    }

    /**
     * @SWG\GET(
     *      path="/api/shop/rejectorder",
     *      operationId="rejectOrder",
     *      tags={"Shop's order"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="order_id",
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

    public function rejectOrder(Request $request)
    {
        $data = $this->orderService->rejectOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('order' => $data['order']));
        }
        return $this->responseFail();
    }

    /**
     * @SWG\POST(
     *      path="/api/shop/filterorder",
     *      operationId="filterOrder",
     *      tags={"Shop's order"},
     *     security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="perpage",
     *       in="formData",
     *       required=true,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="page",
     *       in="formData",
     *       required=true,
     *       type="integer"
     *   ),
     *     @SWG\Parameter(
     *       name="role",
     *       in="formData",
     *       required=false,
     *       type="array",
     *       items=@SWG\Items(
     *         type="string",)
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
     *       name="sort",
     *       in="formData",
     *       required=false,
     *       type="string"
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

    public function filterOrder(Request $request)
    {
        $data = $this->orderService->filterOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('page_current' => $data['page_current'], 'orders' => $data['orders'], 'total_data' => $data['total_data']));
        }
        return $this->responseFail();
    }

    /**
     * @SWG\GET(
     *      path="/api/shop/continueorder",
     *      operationId="continueOrder",
     *      tags={"Shop's order"},
     *      security={
     *       {"bearerAuth": {}}
     *     },
     *     @SWG\Parameter(
     *       name="order_id",
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

    public function continueOrder(Request $request)
    {
        $data = $this->orderService->continueOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('order' => $data['order']));
        }
        return $this->responseFail();
    }

    /**
     * @SWG\POST(
     *      path="/api/shop/createorder",
     *      operationId="createOrder",
     *      tags={"Shop's order"},
     *      consumes={"application/json"},
     *      produces={"application/json"},
     *      security={
     *          {"bearerAuth": {}}
     *      },
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          type="json",
     *          @SWG\Schema(
     *               @SWG\Property(property="phone", type="string"),
     *               @SWG\Property(property="description", type="string"),
     *               @SWG\Property(property="note", type="string"),
     *               @SWG\Property(property="deposit", type="string"),
     *               @SWG\Property(property="payment", type="string"),
     *               @SWG\Property(property="delivery_date", type="string"),
     *               @SWG\Property(property="list_product", type="array", items=@SWG\Items(type="object", @SWG\Property(property="product_id", type="integer"),
     *                 @SWG\Property(property="quality", type="integer"))),
     *          ),
     *      ),
     *   @SWG\Response(response=200, description="successful request"),
     *   @SWG\Response(response=401, description="not authencation"),
     *   @SWG\Response(response=400, description="bad request"),
     *   )
     *
     */

    public function createOrder(Request $request)
    {
        $data = $this->orderService->createOrder($request);
        if($data['status']) {
            return $this->responseSuccess('', array('order' => $data['order']));
        }
        return $this->responseFail($data['message']);
    }

    public function addComment(Request $request)
    {
        $data = $this->commentService->addComment($request);
        if($data['status']) {
            return $this->responseSuccess('', array('comment' => $data['comment']));
        }
        return $this->responseFail();
    }

    public function noti()
    {
        $data = $this->orderService->noti();
        if($data['status']) {
            return $this->responseSuccess('', array('notifications' => $data['notifications']));
        }
        return $this->responseFail();
    }

    public function vnpay(Request $request)
    {
        $data = $this->orderService->vnpay($request);
        if($data['status']) {
            return $this->responseSuccess('', array('vnp_url' => $data['vnp_url']));
        }
        return $this->responseFail();
    }

    public function returnPay(Request $request)
    {
        $data = $this->orderService->returnPay($request);
        if($data['status']) {
            return $this->responseSuccess('Successful transaction', array('order' => $data['order']));
        }
        return $this->responseFail('An error occurred during the translation process');
    }

    public function hello() {
        return response()->json([
            'success' => true
        ], 200);
    }
}
