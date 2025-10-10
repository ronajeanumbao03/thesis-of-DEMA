<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    protected $primaryKey = 'event_id';
    protected $fillable = ['event_name', 'event_description', 'amount','applied_to'];

    public function section() {
        return $this->belongsTo(Section::class, 'applied_to');
    }

    public function remittances()
    {
        return $this->hasMany(Remittance::class);
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
