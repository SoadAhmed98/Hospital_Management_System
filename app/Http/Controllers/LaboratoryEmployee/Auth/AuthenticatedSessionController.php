<?php

namespace App\Http\Controllers\LaboratoryEmployee\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LaporatoryEmployeeLoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Dashboard.LaboratoryEmployee.auth.signin');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LaporatoryEmployeeLoginRequest $request): RedirectResponse
    {
       
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('lab_employee.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('lab_employee')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('lab_employee.login');
    }
}
