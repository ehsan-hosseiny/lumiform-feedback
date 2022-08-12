<?php

namespace App\Http\Controllers\api\v1\form;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormResource;
use App\Services\FormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class FormController extends Controller
{

    /**
     * FormController constructor.
     * @param FormService $formService
     */
    public function __construct(private FormService $formService)
    {
    }


    /**
     * Create New Form
     * @method POST
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request):JsonResponse
    {
        $data = $this->formService->createForm($request->all());
        return response()->json($data);
    }

    /**
     * Get form by id
     * @method Get
     * @param $id
     * @return JsonResponse
     */
    public function getForm($id)
    {
        $data = $this->formService->getForm($id);
        if(is_null($data)){
            return response()->json(['form not found'],Response::HTTP_NOT_FOUND);
        }
        if (count($data->formItems) == 0) {
            return response()->json([$data->uuid]);
        } else {
            return response()->json([new FormResource($data), Response::HTTP_OK]);
        }
    }

    /**
     * Save Form with answer
     * @method POST
     * @param Request $request
     * @return JsonResponse
     */
    public function saveForm(Request $request):JsonResponse
    {
        $data = $this->formService->saveForm($request->all());
        return response()->json($data);
    }

}
