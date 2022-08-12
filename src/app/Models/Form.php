<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

    const TYPE_FORM = 'form';
    const TYPE_PAGE = 'page';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */

    public $incrementing = true;

    public $guarded=[];

    public function formItems()
    {
        return $this->hasMany(FormItem::class,'form_id','id')->where('parent_id', 0);
    }

    public function checklist()
    {
        return $this->belongsTo(CheckList::class,'check_list_id','id');
    }

    use HasFactory;
}
