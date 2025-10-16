<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class UserBudgetController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->department_id) {
            return view('budget.user-summary')->with('message', 'You are not assigned to a department.');
        }

        $department = Department::findOrFail($user->department_id);
        $totalBudget = $department->annual_budget;
        $totalSpent = Expense::where('department_id', $department->id)
            ->where('status', 'approved')
            ->sum('amount');
        $remaining = $totalBudget - $totalSpent;

        return view('budget.user-summary', compact('department', 'totalBudget', 'totalSpent', 'remaining'));
    }
}
