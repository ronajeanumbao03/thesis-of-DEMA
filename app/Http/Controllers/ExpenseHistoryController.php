<?php

// app/Http/Controllers/ExpenseHistoryController.php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ExpenseHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $department = Department::where('department_head_id', $user->id)->firstOrFail();

        $query = Expense::with('user')
            ->where('department_id', $department->id)
            ->whereIn('status', ['approved', 'rejected']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('month')) {
            $query->whereMonth('expense_date', $request->month);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }

        $expenses = $query->latest()->paginate(10)->withQueryString();

        // Totals for filtered set
        $totalApproved = (clone $query)->where('status', 'approved')->sum('amount');
        $totalPending = (clone $query)->where('status', 'pending')->sum('amount');
        $totalRejected = (clone $query)->where('status', 'rejected')->sum('amount');

        return view('expense-history.index', compact(
            'expenses',
            'totalApproved',
            'totalPending',
            'totalRejected'
        ));
    }

    public function destroy(Expense $expense)
    {
        $user = auth()->user();
        $department = Department::where('department_head_id', $user->id)->first();

        // Ensure the expense belongs to the user's department
        if (!$department || $expense->department_id !== $department->id) {
            abort(403, 'Unauthorized action.');
        }

        $expense->delete();

        return redirect()->route('expenses.history')->with('toast', [
            'type' => 'success',
            'message' => 'Expense deleted successfully.',
        ]);
    }

}

