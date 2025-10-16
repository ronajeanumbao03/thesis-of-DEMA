<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Department;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get department where the user is head
        $department = Department::where('department_head_id', $user->id)->firstOrFail();

        // Get distinct categories and department users for filters
        $categories = Expense::where('department_id', $department->id)
            ->select('category')->distinct()->pluck('category');

        $users = $department->users;

        // Build expense query with filters
        $query = Expense::with('user')
            ->where('department_id', $department->id);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('month')) {
            $query->whereMonth('expense_date', $request->month);
        }

        $expenses = $query->latest()->get();

        // Totals per status
        $totalApproved = (clone $query)->where('status', 'approved')->sum('amount');
        $totalPending = (clone $query)->where('status', 'pending')->sum('amount');
        $totalRejected = (clone $query)->where('status', 'rejected')->sum('amount');

        return view('reports.index', compact(
            'expenses',
            'totalApproved',
            'totalPending',
            'totalRejected',
            'department',
            'categories',
            'users'
        ));
    }
}
