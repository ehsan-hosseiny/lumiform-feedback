<?php

namespace App\Http\Middleware;

use App\Events\RequestCaptureEvent;
use Auth;
use Closure;
use Exception;
use Illuminate\Http\Request;

class RequestCapture
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (str_starts_with($request->path(), 'api/v1')) {
            try {
                if ($request->segment(3) != 'analytics') {
                    event(new RequestCaptureEvent([
                        "user_agent" => $request->header('user-agent'),
                        "headers" => json_encode($request->header()),
                        "path" => $request->segment(3),
                        "auth_id" => auth()->id(),
                        "method" => $request->getMethod(),
                        "response" => json_encode($response->getOriginalContent()),
                    ]));
                }
            } catch (Exception $err) {
            }
            return $response;
        }
        return $response;
    }
}
