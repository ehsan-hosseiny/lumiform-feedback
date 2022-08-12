<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    public function list()
    {
        return $this->hasMany(ConditionDetail::class,'condition_id','id');

    }
}
