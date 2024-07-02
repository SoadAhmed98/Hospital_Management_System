<?php

namespace App\Http\Controllers\LaboratoryEmployee\Auth;



use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\LaboratoryEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('Dashboard.LaboratoryEmployee.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.LaboratoryEmployee::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $lab_employee = LaboratoryEmployee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($lab_employee));

        Auth::guard('lab_employee')->login($lab_employee);

        return redirect(route('lab_employee.dashboard', absolute: false));
    }
}
