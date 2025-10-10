<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Remittance extends Model
{
   use HasFactory;

    protected $primaryKey = 'remittance_id';

    protected $fillable = [
        'treasurer_id',
        'event_id',
        'amount',
        'remittance_date',
        'remarks',
    ];

    // Relationship: Remittance belongs to Treasurer
    public function treasurer()
    {
        return $this->belongsTo(Treasurer::class, 'treasurer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
