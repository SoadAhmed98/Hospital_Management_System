<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    protected function unauthenticated($request,array $guards)
    {
        throw new AuthenticationException(
        'unauthenticated',$guards,$this->redirectToRoute($request, $guards)
        );
    }

    protected function redirectToRoute($request,$guards)
    {
      //   if(Route::is('admin.*'))
      //   {
      //      return redirect()->route('admin.login');
      //   }
      //   elseif (Route::is('doctor.*')) {
      //      return redirect()->route('doctor.login');
      //   }
      //   elseif (Route::is('lab_employee.*')) {
      //      return redirect()->route('lab_employee.login');
      //   }

        foreach ($guards as $guard) {
         if ($guard === 'admin') {
             return route('admin.login');
         } elseif ($guard === 'doctor') {
             return route('doctor.login');
         } elseif ($guard === 'lab_employee') {
             return route('lab_employee.login');
         }
     }
    }

}
