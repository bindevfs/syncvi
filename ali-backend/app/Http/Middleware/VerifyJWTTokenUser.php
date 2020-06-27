<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Response;

class VerifyJWTTokenUser extends BaseMiddleware
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
        if (!$this->auth->parser()->setRequest($request)->hasToken()) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Token isn\'t provided!'
            ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
        try {
            if (!$this->auth->parseToken()->authenticate()) {
                return response()->json([
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'User not found',
                ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Have an error!',
            ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
        $temp = @auth('users')->user()->id;
        if($temp === null) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Have an error!',
            ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
        $temp = auth('users')->user();
        if($temp->deleted_at != null) {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Account was be block!',
            ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }
        $this->authenticate($request);
        return $next($request);
    }
}
