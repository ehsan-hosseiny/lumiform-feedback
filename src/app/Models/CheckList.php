<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    use HasFactory;
    public $guarded=[];

    public function forms()
    {
        return $this->hasMany(Form::class,'check_list_id','id');

    }
}
