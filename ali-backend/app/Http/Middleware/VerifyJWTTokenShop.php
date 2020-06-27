<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Whoops\Exception\ErrorException;

class VerifyJWTTokenShop extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->auth->parser()->setRequest($request)->hasToken()) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Token isn\'t provided!',
            ]);
        }
        /*
        try {
            if (! $this->auth->parseToken()->authenticate()) {
                return response()->json([
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'User not found',
                ]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Have an error!',
            ]);
        }*/
        //shop
        $temp = @auth('shop_users')->user()->id;
        if($temp === null) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Have an error!',
            ]);
        }
        $temp = auth('shop_users')->user();
        if($temp->deleted_at != null) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Account was be block!',
            ]);
        }
        return $next($request);
    }
}
