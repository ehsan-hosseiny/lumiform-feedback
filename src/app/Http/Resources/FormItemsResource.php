<?php

namespace App\Http\Resources;

use App\Models\FormItem;
use Illuminate\Http\Resources\Json\JsonResource;

class FormItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'uuid' => $this->uuid,
            'title' => $this->title,
            "image_id" => $this->image_id,
            "type" => $this->type,
            'categories' => $this->categories ?? [],
            "response_type" => $this->response_type,
            "required" => $this->required,
            "negative" => $this->negative,
            "notes_allowed" => $this->notes_allowed,
            "photos_allowed" => $this->photos_allowed,
            "issues_allowed" => $this->issues_allowed,
            "responded" => $this->responded,
        ];
        if (count($this->items) > 0) {
            $result['items'] = $this->whenNotNull(FormItemsResource::collection($this->items));
        }
        if ($this->type == FormItem::TYPE_QUESTION) {
            $result['check_conditions_for'] = [];
        }
        if ($this->response) {
            $result['params'] = [
                "response_set" => $this->response->uuid,
                "multiple_selection" => $this->response->multiple_selection
            ];
            if(count($this->response->detail)>0){
                $result['params']['responses']=$this->response->detail;
            }
            if (count($this->response->detail) > 0) {
                foreach ($this->response->detail as $detail) {
                    if (count($detail->conditions) > 0) {
                        foreach ($detail->conditions as $condition) {
                            if (count($condition->list) > 0) {
                                foreach ($condition->list as $conditionDetail) {

                                    $result['check_conditions_for'][] = $conditionDetail;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }
}
