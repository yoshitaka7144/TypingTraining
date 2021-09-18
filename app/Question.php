<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 問題Model
 */
class Question extends Model
{
    public function category(){
        return $this->belongsTo("App\Category");
    }
}
