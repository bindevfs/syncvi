<?php

namespace App\Http\Controllers\Shop;

use App\Services\Shop\Comment\CommentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function addComment(Request $request)
    {
        if($request->ajax()) {
            $data = $this->commentService->addComment($request);
            if($data['status']) {
                return json_encode(array('success' => true));
            }
            return json_encode(array('success' => false));
        }
        return json_encode(array('success' => false));
    }
}
