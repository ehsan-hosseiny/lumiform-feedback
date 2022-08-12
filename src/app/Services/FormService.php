<?php


namespace App\Services;


use App\Interfaces\FormInterface;
use App\Repositories\FormRepository;
use App\Repositories\UserResponseRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\CheckList;
use App\Models\Form;
use \Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class AuthService
 * @package App\Services
 */
class FormService implements FormInterface
{

    /**
     * @inheritDoc
     */
    public function createForm(array $data)
    {
        $checkList = CheckList::create([
            'user_id' => auth()->user()->id,
            'title' => $data['checklist']['checklist_title'],
            'description' => $data['checklist']['checklist_description']
        ]);

        $form = Form::create([
            'uuid' => Str::uuid()->toString(),
            'check_list_id' => $checkList->id,
            'type' => $data['checklist']['form']['type'],
        ]);

        $this->buildTree($data['checklist']['form']['items'], $form->id);
        return [
            'data' => 'form created successfully',
            'status_code' => Response::HTTP_CREATED
        ];
    }

    /**
     * @inheritDoc
     */
    public function getForm(int $id)
    {
        return resolve(FormRepository::class)->find($id);
    }


    public function saveForm(array $data)
    {
        foreach ($data['checklist']['form']['items'] as $item) {
            if (array_key_exists('items', $item)) {
                $this->proceedAnswer($item['items']);
            }
        }
        return [
            'data' => 'form saved successfully',
            'status_code' => Response::HTTP_CREATED
        ];
    }

    /**
     * @param $items
     */
    public function proceedAnswer($items)
    {
        foreach ($items as $key => $item) {
            if(array_key_exists('responses', $item)){
                resolve(UserResponseRepository::class)->saveForm(Auth::id(),$item['responses']['uuid']);
            }
            if (array_key_exists('items', $item)) {
                $this->proceedAnswer($item['items']);
            }
        }
    }


    /**
     * @param array $items
     * @param int $formId
     */
    public function buildTree(array $items, int $formId)
    {

        foreach ($items as $item) {
            $formItem = resolve(FormRepository::class)->createFormItem($formId, 0, Str::uuid()->toString(),
                $item['title'], $item['type']);
            if (array_key_exists('items', $item)) {
                $this->iterateItems($item['items'], $formId, $formItem->id);
            }
        }
    }

    /**
     * @param $items
     * @param $formId
     * @param int|null $parentId
     */
    public function iterateItems($items, $formId, ?int $parentId = 0)
    {
        foreach ($items as $key => $item) {
            if (array_key_exists('items', $item)) {
                $formItem = resolve(FormRepository::class)->createFormItem($formId, $parentId, Str::uuid()->toString(),
                    $item['title'], $item['type']);
                $this->iterateItems($item['items'], $formId, $formItem->id);
            } else {
                resolve(FormRepository::class)->createFormItem(
                    $formId, $parentId, Str::uuid()->toString(), $item['title'], $item['type'],
                    isset($item['repeat']) ? $item['repeat'] : false,
                    isset($item['weight']) ? $item['weight'] : 0, $item['required'], $item['negative'],
                    $item['notes_allowed'], $item['photos_allowed'], $item['issues_allowed'], $item['responded']
                );
            }
        }
    }

}
