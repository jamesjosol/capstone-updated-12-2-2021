<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function school_year() {
        return $this->belongsTo('App\Models\SchoolYear');
    }

    public function section() {
        return $this->belongsTo('App\Models\Section');
    }

    public function student() {
        return $this->belongsTo('App\Models\Student');
    }
}
