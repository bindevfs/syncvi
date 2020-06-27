<?php


namespace App\Services\Shop\Comment;


use App\Entities\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class CommentService
{
    protected $commentRepo;

    protected $orderRepo;

    public function __construct(CommentRepository $commentRepo, OrderRepository $orderRepo)
    {
        $this->commentRepo = $commentRepo;
        $this->orderRepo = $orderRepo;
    }

    public function addComment(Request $request)
    {
        $order_id = $request['order_id'];
        $content = $request['content'];
        $order = $this->orderRepo->findByField('id', $order_id)->first();
        if(!$order) {
            return array('status' => false);
        }
        if($content == '' || $content == null) {
            return array('status' => false);
        }
        $user = auth('web_shop_users')->user();
        if(!$user) {
            $user = auth('shop_users')->user();
        }
        if(!$user) {
            return array('status' => false);
        }
        if($order->shop_id != $user->shop_id) {
            return array('status' => false, 'message' => 'errror166');
        }
        $comment = $this->commentRepo->create([
            'order_id' => $order->id,
            'type'     => 1,
            'content'  => $content
        ]);
        return array('status' => true, 'comment' => $comment);
    }
}
