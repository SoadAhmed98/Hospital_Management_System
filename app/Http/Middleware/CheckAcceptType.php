<?php

namespace App\Http\Middleware;


use Closure;
use App\Traits\ApiTrait;
use Illuminate\Http\Request;

class CheckAcceptType
{
    use ApiTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $acceptType = $request->header('accept');
        if(!$acceptType || $acceptType != "application/json"){
            return $this->ErrorMessage(["accept"=>"application/json"]," Accept key is missed on headers ! ",422 );
        }
        return $next($request);
    }
}
