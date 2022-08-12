<?php


namespace App\Repositories;

use App\Models\Form;
use App\Models\FormItem;
use Illuminate\Support\Facades\Hash;

class FormRepository
{
    public function find($id)
    {
        return Form::find($id);
    }

    /**
     * @param int $formId
     * @param int $parentId
     * @param string $uuid
     * @param string $title
     * @param string $type
     * @param bool|null $repeat
     * @param int|null $weight
     * @param bool|null $required
     * @param bool|null $negative
     * @param bool|null $noteAllowed
     * @param bool|null $photoAllowed
     * @param bool|null $issuesAllowed
     * @param bool|null $responded
     * @return FormItem
     */
    public function createFormItem(int $formId, int $parentId, string $uuid, string $title, string $type, ?bool $repeat = false,
                                   ?int $weight = 0, ?bool $required = false, ?bool $negative = false, ?bool $noteAllowed = false,
                                   ?bool $photoAllowed = false,?bool $issuesAllowed = false, ?bool $responded = false):FormItem
    {

        return  FormItem::create([
            'form_id' => $formId,
            'parent_id' => $parentId,

            'uuid' => $uuid,
            'title' => $title,
            'type' => $type,
//          'param_id'=>'',
//          'image_id'=>$item['image_id'],
//          'category_id'=>'',
//          'condition_id'=>'',
            'repeat' => $repeat,
            'weight' => $weight,
            'required' => $required,
            'negative' => $negative,
            'notes_allowed' => $noteAllowed,
            'photos_allowed' => $photoAllowed,
            'issues_allowed' => $issuesAllowed,
            'responded' => $responded,
        ]);
    }
}
