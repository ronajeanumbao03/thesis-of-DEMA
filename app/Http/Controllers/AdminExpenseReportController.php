<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class AdminExpenseReportController extends Controller
{
    public function index(Request $request)
    {
        // Filtered expenses
        $expenses = Expense::with(['user', 'department'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->month, fn($q) => $q->whereMonth('expense_date', $request->month))
            ->latest()
            ->get();

        // Totals by status
        $totalApproved = $expenses->where('status', 'approved')->sum('amount');
        $totalPending = $expenses->where('status', 'pending')->sum('amount');
        $totalRejected = $expenses->where('status', 'rejected')->sum('amount');

        return view('admin.expense-reports.index', compact(
            'expenses',
            'totalApproved',
            'totalPending',
            'totalRejected'
        ));
    }
}
