<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($message = '', $data = [])
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseFail($message = '', $data = [], $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $code
     * @return array
     */
    public function responseAjaxFail($message = '', $data = [], $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json(array(
            'code' => $code,
            'message' => $message,
            'data' => $data
         ))->setStatusCode(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param string $message
     * @param array $data
     * @return array
     */
    public function responseAjaxSuccess($message = '', $data = [])
    {
        return response()->json(array(
            'code' => Response::HTTP_OK,
            'message' => $message,
            'data' => $data
        ))->setStatusCode(Response::HTTP_OK);
    }
}
