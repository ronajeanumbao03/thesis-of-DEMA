<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class NotificationExpenseController extends Controller
{
    public function approve(Expense $expense)
    {
        if ($expense->status === 'pending') {
            $expense->status = 'approved';
            $expense->save();

            return response()->json(['message' => 'Expense approved']);
        }

        return response()->json(['message' => 'Action not allowed'], 403);
    }

    public function reject(Expense $expense)
    {
        if ($expense->status === 'pending') {
            $expense->status = 'rejected';
            $expense->save();

            return response()->json(['message' => 'Expense rejected']);
        }

        return response()->json(['message' => 'Action not allowed'], 403);
    }
}
