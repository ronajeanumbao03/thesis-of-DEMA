<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'description',
        'annual_budget',
        'department_head_id',
    ];

    /**
     * Relationship: Department has one head (user)
     */
    public function head()
    {
        return $this->belongsTo(User::class, 'department_head_id');
    }

    /**
     * Relationship: Department has many users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship: Department has many expenses
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Relationship: Department has one budget
     */
    public function budget()
    {
        return $this->hasOne(Budget::class);
    }

    /**
     * Cascade delete relationships when deleting a department
     */
    protected static function booted()
    {
        static::deleting(function ($department) {
            // Delete budget
            $department->budget()->delete();

            // Delete expenses (optional — or use soft delete if you want to retain them)
            $department->expenses()->delete();

            // Unassign users from department
            $department->users()->update(['department_id' => null]);

            // Unassign department head
            $department->department_head_id = null;
            $department->saveQuietly();
        });
    }
}
