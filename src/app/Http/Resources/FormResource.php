<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'checklist' => [
                'checklist_title'=> $this->checklist->title,
                'checklist_description'=> $this->checklist->description,
                'form'=> [
                    'type' => $this->type,
                    'items' =>[
                        'uuid'=>$this->formItems[0]->uuid,
                        'title'=>$this->formItems[0]->title,
                        'type'=>$this->formItems[0]->type,
                        'items' => $this->whenNotNull(FormItemsResource::collection($this->formItems[0]->items)),
                    ]
                ]
            ],

        ];
    }
}
