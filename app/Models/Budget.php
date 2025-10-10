<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'department_id',
        'amount',
        'total_amount',
        'spent_amount',
        'remaining_amount',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
