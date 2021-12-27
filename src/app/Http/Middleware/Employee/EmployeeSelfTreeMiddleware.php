<?php

namespace App\Http\Middleware\Employee;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeSelfTreeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->employee->isSelfTree($request->route('employee'))) {
            return $next($request);
        }
        throw new \DomainException('You can view only your employees');
    }
}
