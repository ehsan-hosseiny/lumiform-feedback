<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseDetail extends Model
{
    use HasFactory;
    protected $hidden=['created_at','updated_at','id'];

    public function conditions()
    {
        return $this->hasMany(Condition::class,'response_details_id','id');
    }
}
