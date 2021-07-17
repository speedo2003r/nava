<?php

namespace App\Traits;

trait ResponseTrait
{
    /**
     * keys : success, fail, needActive, exit, blocked
     */
    function ApiResponse($key, $msg, $data = [], $anotherKey = [])
    {
        $allResponse['key'] = (string) $key;
        $allResponse['msg'] = (string) $msg;

        if ($data != [] || $key == 'success') {
            $allResponse['data']    = $data;
        }

        if (!empty($anotherKey)) {
            foreach ($anotherKey as $key => $value) {
                $allResponse[$key] = (string) $value;
            }
        }
        return response()->json($allResponse);
    }
    
    function successResponse($data = [], $anotherKey = [])
    {
        return $this->ApiResponse('success', trans('api.send'), $data, $anotherKey);
    }
}
