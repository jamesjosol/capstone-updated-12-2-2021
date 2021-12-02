<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sections() {
        return $this->hasMany('App\Models\Section');
    }

    public static function list() {
        $levels = Level::all();
        $list = [];
        foreach($levels as $l) {
            $list[$l->id] = $l->level;
        }
        return $list;
    }
}
