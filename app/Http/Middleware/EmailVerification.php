<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('sanctum')->user() && !Auth::guard('sanctum')->user()->email_verified_at){
            return ApiTrait::ErrorMessage(['email'=>'Not Verified Email'],'Patient Not Verified',403);
        };
        return $next($request);
    }
}
