<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle registration submission.
     */
    public function store(Request $request)
    {
        // ✅ Validate the incoming request
        $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'middle_name'   => ['nullable', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'username'      => ['required', 'string', 'max:255', 'unique:users'],
            'email'         => ['required', 'email', 'max:255', 'unique:users'],
            'address'       => ['nullable', 'string', 'max:255'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'birthdate'     => ['nullable', 'date'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ✅ Auto-generate employee ID
        $latestUser = User::orderBy('id', 'desc')->first();
        $nextId = $latestUser ? $latestUser->id + 1 : 1;
        $employeeId = 'EMP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // ✅ Concatenate full name
        $fullName = trim(
            $request->first_name . ' ' .
            ($request->middle_name ? $request->middle_name . ' ' : '') .
            $request->last_name
        );

        // ✅ Create the user
        $user = User::create([
            'employee_id'   => $employeeId,
            'first_name'    => $request->first_name,
            'middle_name'   => $request->middle_name,
            'last_name'     => $request->last_name,
            'name'          => $fullName,
            'username'      => $request->username,
            'email'         => $request->email,
            'address'       => $request->address,
            'gender'        => $request->gender,
            'birthdate'     => $request->birthdate,
            'role'          => 'user',
            'status'        => 'active',
            'password'      => Hash::make($request->password),
        ]);

        // ✅ Log the user in
        Auth::login($user);

        // ✅ Redirect to dashboard
        return redirect()->route('dashboard');
    }
}
