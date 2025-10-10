<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;

class ExpenseController extends Controller
{
    // Show the form to submit an expense
    public function create()
    {
        $departments = [];

        if (Auth::user()->department_id) {
            $department = Department::find(Auth::user()->department_id);
            if ($department) {
                $departments = [$department];
            }
        }

        return view('expenses.submit-expense', compact('departments'));
    }

    // Store the submitted expense
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'expense_date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'receipt' => 'nullable|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);

        $receiptFileName = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $receiptFileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('receipts'), $receiptFileName);
        }

        $expense = Expense::create([
            'user_id' => Auth::id(),
            'department_id' => $request->department_id,
            'expense_date' => $request->expense_date,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'receipt' => $receiptFileName,
            'status' => 'pending',
        ]);

        // ✅ Notify Head
        $department = Department::find($request->department_id);
        if ($department && $department->department_head_id) {
            Notification::create([
                'user_id' => $department->department_head_id,
                'type' => 'pending',
                'message' => Auth::user()->first_name . " submitted ₱" . number_format($request->amount, 2) . " for approval.",
            ]);
        }

        // ✅ Budget Check
        $totalBudget = $department->annual_budget;
        $totalSpent = $department->expenses()->where('status', 'approved')->sum('amount');
        $projectedTotal = $totalSpent + $request->amount;

        if ($projectedTotal > $totalBudget) {
            Notification::create([
                'user_id' => Auth::id(),
                'type' => 'over_budget',
                'message' => 'Your submission exceeds the department budget.',
            ]);
        } elseif ($totalBudget - $projectedTotal <= 5000) {
            Notification::create([
                'user_id' => Auth::id(),
                'type' => 'low_budget',
                'message' => 'Remaining department budget is running low.',
            ]);

            if ($department->department_head_id) {
                Notification::create([
                    'user_id' => $department->department_head_id,
                    'type' => 'low_budget',
                    'message' => 'Remaining budget for ' . $department->name . ' is low.',
                ]);
            }
        }

        return redirect()->route('user.dashboard')->with('toast', [
            'type' => 'success',
            'message' => 'Expense submitted successfully!',
        ]);
    }

    public function mySubmissions(Request $request)
    {
        // Get the current authenticated user
        $user = Auth::user();

        // Retrieve the expenses based on the search query and per_page value
        $query = Expense::where('user_id', $user->id);

        // Handle the search functionality
        if ($request->has('search') && $request->search) {
            $query->where('category', 'like', '%' . $request->search . '%');
        }

        // Handle pagination
        $perPage = $request->get('per_page', 10);
        $expenses = $query->paginate($perPage);

        return view('expenses.my-submissions', compact('expenses'));
    }
    public function show($id)
    {
        $expense = Expense::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('expenses.show', compact('expense'));
    }

    public function see($id)
    {
        $expense = Expense::with(['user', 'department'])->findOrFail($id);

        return view('expenses.see', compact('expense'));
    }

    public function pendingApprovals()
    {
        $user = auth()->user();

        $department = Department::where('department_head_id', $user->id)->first();

        if (!$department) {
            abort(403, 'You are not assigned as a department head.');
        }

        $expenses = Expense::where('department_id', $department->id)
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('expenses.approvals', compact('expenses'));
    }

    public function approve(Expense $expense)
    {
        $this->authorizeAction($expense);

        $expense->status = 'approved';
        $expense->save();

        // Mark related notification as read
        Notification::where('expense_id', $expense->id)
            ->where('user_id', $expense->user_id)
            ->update(['read' => true]);

        // Optional: push notification for user
        Notification::create([
            'user_id' => $expense->user_id,
            'message' => 'Your expense of ₱' . number_format($expense->amount, 2) . ' has been approved.',
            'read' => false,
            'expense_id' => $expense->id, // optional for linking
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Expense approved.',
        ]);
    }


    public function reject(Expense $expense)
    {
        $this->authorizeAction($expense);

        $expense->status = 'rejected';
        $expense->save();

        Notification::where('expense_id', $expense->id)
            ->where('user_id', $expense->user_id)
            ->update(['read' => true]);

        Notification::create([
            'user_id' => $expense->user_id,
            'message' => 'Your expense of ₱' . number_format($expense->amount, 2) . ' has been rejected.',
            'read' => false,
            'expense_id' => $expense->id,
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'danger',
            'message' => 'Expense rejected.',
        ]);
    }

    private function authorizeAction(Expense $expense)
    {
        $user = auth()->user();
        $department = Department::where('department_head_id', $user->id)->first();

        if (!$department || $expense->department_id !== $department->id) {
            abort(403);
        }
    }

}
