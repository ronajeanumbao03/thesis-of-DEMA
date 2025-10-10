<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadTreasurer extends Model {
    protected $primaryKey = 'head_treasurer_id';
    protected $fillable = ['treasurer_name', 'section_assigned'];

    public function section() {
        return $this->belongsTo(Section::class, 'section_assigned');
    }
}
