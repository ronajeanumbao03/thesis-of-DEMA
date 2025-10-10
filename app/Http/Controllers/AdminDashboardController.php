<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Expense;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $departments = Department::with('expenses')->get();

        $totalBudget = $departments->sum('annual_budget');
        $totalSpent = Expense::where('status', 'approved')->sum('amount');

        // Budget vs Actual per department
        $budgetVsActual = $departments->map(function ($dept) {
            return [
                'name' => $dept->name,
                'budget' => (float) $dept->annual_budget,
                'spent' => (float) $dept->expenses->where('status', 'approved')->sum('amount'),
            ];
        });

        // Top 5 departments by expense
        $topDepartments = $budgetVsActual->sortByDesc('spent')->take(5)->values();

        // Top 5 department by expense
        $topSpenders = Department::with([
            'expenses' => function ($query) {
                $query->where('status', 'approved');
            }
        ])
            ->get()
            ->map(function ($dept) {
                return [
                    'name' => $dept->name,
                    'total' => $dept->expenses->sum('amount'),
                ];
            })
            ->sortByDesc('total')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'totalBudget',
            'totalSpent',
            'budgetVsActual',
            'topDepartments',
            'topSpenders'
        ));
    }
}
