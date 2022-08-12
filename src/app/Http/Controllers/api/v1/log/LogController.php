<?php

namespace App\Http\Controllers\api\v1\log;

use App\Http\Controllers\Controller;
use App\Repositories\LogRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class LogController extends Controller
{

    /**
     * return logs
     * @method GET
     * @param Request $request
     * @return JsonResponse
     */
    public function logs(Request $request):JsonResponse
    {
        $data = resolve(LogRepository::class)->list( $request->query('method'),$request->query('endpoint'));
        return response()->json([$data], Response::HTTP_OK);
    }

}
