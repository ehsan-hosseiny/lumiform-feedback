<?php


namespace App\Repositories;

use App\Models\Form;
use App\Models\FormItem;
use App\Models\RequestLog;
use Illuminate\Support\Facades\Hash;

class LogRepository
{
    public function list(?string $method, ?string $endpoint)
    {
        $data = new RequestLog;
        if (!is_null($method)) {
            $data = $data->where('method', strtoupper($method));
        } elseif (!is_null($method)) {
            $data = $data->where('path', $endpoint);
        }

        return $data->get();
    }

}
