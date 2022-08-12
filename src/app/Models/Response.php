<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    public function detail()
    {
        return $this->hasMany(ResponseDetail::class,'response_id','id');
    }
}
