<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormItem extends Model
{
    use HasFactory;
    public $guarded=[];

    const TYPE_QUESTION='question';

    protected $hidden=['created_at','updated_at'];


    public function form()
    {
        return $this->belongsTo(Form::class,'form_id','id');
    }

    public function items()
    {
        return $this->hasMany(FormItem::class, 'parent_id','id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function response()
    {
        return $this->hasOne(Response::class,'form_items_id','id');

    }

}
