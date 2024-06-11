<?php

namespace App\Http\Controllers\Doctor\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\DoctorLoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Dashboard.Doctor.auth.signin');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(DoctorLoginRequest $request): RedirectResponse
    {
       
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('doctor.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('doctor')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('doctor.login');
    }
}
