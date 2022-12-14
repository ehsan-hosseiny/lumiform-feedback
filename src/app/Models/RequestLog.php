<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    use HasFactory;

    public $guarded = [];

    public $hidden = ['id', 'created_at', 'updated_at'];

}
