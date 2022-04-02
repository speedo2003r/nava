<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;

if (!function_exists('get_json_response_for_exception')) {
    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    function get_json_response_for_exception(Request $request, Throwable $e)
    {
        if ($e instanceof UnauthorizedHttpException || $e instanceof AuthenticationException) {
            return json_response(null, null,
                401, ['exception' => collect(__('Error 401 ! .. Unauthorized !'))]);
        } elseif ($e instanceof AuthorizationException) {
            return json_response(null, null,
                403, ['exception' => collect(__('Error 403 ! .. You Dont Have The Required Permission For This Action  !'))]);
        } elseif (($e instanceof ModelNotFoundException) || ($e instanceof NotFoundHttpException)) {
            return json_response(null, null,
                404, ['exception' => collect(__('Error 404 ! .. Requested Data Not Found !'))]);
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            return json_response(null, null,
                405, ['exception' => collect(__('Error 405 ! .. Method Not Allowed Exception !'))]);
        } elseif ($e instanceof ErrorException) {
            return json_response(null, null,
                500, ['exception' => collect(__('Error 500 ! .. Internal server error !'))]);
        } else {
            return json_response(null, null,
                500, ['exception' => collect(__('Internal server error !'))]);
        }
    }
}


if (!function_exists('is_api_call')) {
    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    function is_api_call(Request $request)
    {
        return strpos($request->getUri(), '/api/') !== false;
    }
}
