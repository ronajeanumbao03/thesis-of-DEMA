<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $department = $user->department;

        if (!$department) {
            abort(403, 'You are not assigned to any department.');
        }

        $totalBudget = $department->annual_budget;

        $totalSpent = Expense::where('department_id', $department->id)
            ->where('status', 'approved')
            ->sum('amount');

        $monthlyExpenses = Expense::selectRaw('MONTH(expense_date) as month, SUM(amount) as total')
            ->where('department_id', $department->id)
            ->where('status', 'approved')
            ->groupByRaw('MONTH(expense_date)')
            ->orderBy('month')
            ->get();

        $chartData = array_fill(1, 12, 0);
        foreach ($monthlyExpenses as $expense) {
            $chartData[(int) $expense->month] = $expense->total;
        }

        $categoryBreakdown = Expense::selectRaw('category, SUM(amount) as total')
            ->where('department_id', $department->id)
            ->where('status', 'approved')
            ->groupBy('category')
            ->get();

        $topCategories = $categoryBreakdown->sortByDesc('total')->take(5)->values();

        return view('user.dashboard', compact(
            'totalBudget',
            'totalSpent',
            'chartData',
            'categoryBreakdown',
            'topCategories'
        ));
    }
}
