<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\Doctor;
use App\Models\AdminAccessCode;
use App\Support\DateInput;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'date_of_birth' => DateInput::normalize($request->input('date_of_birth')),
        ]);

        // Build validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'role' => ['required', 'in:patient,nurse,doctor'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
        ];

        // Require access code for non-patient roles
        if ($request->role !== 'patient') {
            $rules['access_code'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        // Validate access code for non-patient roles
        if ($request->role !== 'patient') {
            if (!AdminAccessCode::validateCode($request->access_code, $request->role)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['access_code' => 'Invalid or expired access code for this role.']);
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        // Create role-specific record
        match($request->role) {
            'patient' => Patient::create([
                'user_id' => $user->id,
                'blood_type' => $validated['blood_type'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
            ]),
            'nurse' => Nurse::create(['user_id' => $user->id, 'specialization' => 'General', 'license_number' => 'LN' . $user->id . date('YmdHis')]),
            'doctor' => Doctor::create(['user_id' => $user->id, 'specialization' => 'General', 'license_number' => 'MD' . $user->id . date('YmdHis')]),
        };

        // Record access code usage for non-patient roles
        if ($request->role !== 'patient') {
            $accessCode = AdminAccessCode::where('code', $request->access_code)
                ->where('role', $request->role)
                ->first();
            if ($accessCode) {
                $accessCode->recordUsage();
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
