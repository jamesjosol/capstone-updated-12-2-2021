<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function currentYear() {
        $sy = SchoolYear::where('status', 'active')->get()->first();
        return $sy->schoolYr_started . ' - ' . $sy->schoolYr_ended;
    }

    public function enrolls() {
        return $this->hasMany('App\Models\Enroll');
    }


}
