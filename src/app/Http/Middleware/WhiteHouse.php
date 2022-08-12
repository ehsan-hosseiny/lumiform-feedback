<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class WhiteHouse
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

        try {
            $locale_in_header = $request->headers->get('lang') ?? $request->headers->get('locale');
            $local_in_query =
                $request->query->get('lang');

            if (!is_null($locale_in_header)) {
                App::setLocale($locale_in_header);
            }

            if (!is_null($local_in_query)) {
                App::setLocale($local_in_query);
            }
        } catch (Exception $err) {
        }

        $customMessage = null;
        $customCode = null;

        /** requests that are not api-related, should continue */
        if (!str_starts_with($request->path(), 'api/v1')) {
            return $next($request);
        }


        $acceptHeader = $request->header('Accept');
        if ($acceptHeader !== 'application/json') {

            $request->headers->set("Accept", "application/json");
        }
        $contentTypeHeader = $request->header('Content-Type');
        if (!str_starts_with($request->path(), 'api/v1/business-customer/upload-logo')) {
            if ($contentTypeHeader !== 'application/json') {
                $request->headers->set("Content-Type", "application/json");
            }
        }
        $response = $next($request);

        $body = $response->getOriginalContent();

        if ($response->exception instanceof AuthenticationException) {
            $customMessage = "UNAUTHORIZED";
            $customCode = 401;
            $body = [];
        }

        if ($response->exception instanceof AuthorizationException) {
            $customMessage = "FORBIDDEN";
            $customCode = 403;
            $body = [];
        }


        if (isset($body['message'])) {
            $customMessage = $body['message'];
            unset($body['message']);
        }

        $code = $response->getStatusCode();
        if ($code === 422) {
            $customMessage = $this->exceptionMessages($body);
        }
        $newContent = $this->createResponse(
            $body,
            is_null($customMessage) ? $this->generateMessage($code) : $customMessage,
            $customCode === null ? $code : $customCode
        );
        return $newContent;
    }

    private function exceptionMessages($body)
    {
        $message = "";
        foreach ($body['errors'] as $key => $value) {
            $message .= $key . ":\n";
            foreach ($value as $item) {
                $message .= $item . "\n";
            }
        }
        return $message;
    }

    public function createResponse($data, $message, $code = null, $version = null)
    {
        return response()->json([
            "data" => $data,
            "message" => $message,
            "code" => $code,
        ], $code);
    }

    public function generateMessage($code)
    {
        switch ($code) {
            case 401:
                return __('common.generate_message_not_authenticate');
                break;
            default:
                return 'n/a';
                break;
        }
    }

    public function getVersion()
    {
        return [
            "ios" => settings()->list("ios", "global"),
            "android" => settings()->list("android", "global")
        ];
    }
}
