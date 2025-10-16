<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'expenses';

    // Define the fillable fields to protect against mass-assignment vulnerabilities
    protected $fillable = [
        'user_id',
        'department_id',
        'expense_date',
        'category',
        'amount',
        'description',
        'receipt',
        'status',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class); // An expense belongs to a user
    }

    public function department()
    {
        return $this->belongsTo(Department::class); // An expense belongs to a department
    }
}
