<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionDetail extends Model
{
    use HasFactory;

    protected $hidden=['id','created_at','updated_at','condition_id'];
}
