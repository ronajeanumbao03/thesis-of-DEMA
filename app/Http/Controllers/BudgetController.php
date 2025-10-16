<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    // Show the budget summary
    public function index()
    {
        // Get the current user
        $user = Auth::user();

        // Fetch the department associated with the user (assuming a `department_head_id` column)
        $department = Department::where('department_head_id', $user->id)->first();

        if ($department) {
            // Fetch the budget for the department
            $budget = Budget::where('department_id', $department->id)->first();
            return view('budget.summary', compact('budget'));
        }

        // If no department is found for the user
        return view('budget.summary', ['budget' => null]);
    }


}

