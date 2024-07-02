<?php

namespace App\Http\Controllers\LaboratoryEmployee\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('lab_employee.dashboard', absolute: false))
                    : view('Dashboard.LaboratoryEmployee.auth.verify-email');
    }
}
