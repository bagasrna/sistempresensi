<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Libraries\ResponseBase;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return ResponseBase::error('Token Expired', 401);
        } catch (TokenInvalidException $e) {
            return ResponseBase::error('Token Invalid', 401);
        } catch (\Exception $e) {
            return ResponseBase::error('Token Tidak Ditemukan', 401);
        }

        return $next($request);
    }
}