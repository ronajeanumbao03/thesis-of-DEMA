<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('employee_id', 'like', "%$search%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    //fetch all records
    public function fetchAllRecords()
    {
        $allusers = User::all();
        return view('departments.assign-head', compact($allusers ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate fields
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:male,female,other'],
            'birthdate' => ['nullable', 'date'],
            'role' => ['required', 'in:admin,head,user'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        // Generate employee_id
        $latestUser = User::orderBy('id', 'desc')->first();
        $nextId = $latestUser ? $latestUser->id + 1 : 1;
        $employeeId = 'EMP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // Concatenate full name
        $fullName = trim($request->first_name . ' ' . ($request->middle_name ? $request->middle_name . ' ' : '') . $request->last_name);

        // Create user
        User::create([
            'employee_id' => $employeeId,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'name' => $fullName,
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'role' => $request->role,
            'status' => $request->status,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ]);

        // Toast success
        session()->flash('toast', [
            'type' => 'success',
            'message' => 'User created successfully!',
            'timeout' => 3000,
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'birthdate' => 'nullable|date',
            'role' => 'required|in:admin,head,user',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'role' => $request->role,
            'status' => $request->status,
            'name' => $request->first_name . ' ' . ($request->middle_name ?? '') . ' ' . $request->last_name,
        ]);

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'User updated successfully!',
            'timeout' => 3000,
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'User deleted successfully!',
            'timeout' => 3000,
        ]);

        return redirect()->route('users.index');
    }
}
