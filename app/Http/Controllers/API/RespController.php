<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RespController extends Controller
{
    /**
     * @param $data
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResponse($data, $message)
    {
        $resp = [
            'success' => true,
            'data' => $data,
            'message' => $message,
        ];

        return response()->json($resp);
    }

    public function getError($error,$errMessages = [])
    {
        $resp = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errMessages)){
            $resp['data'] = $errMessages;
        }

        return response()->json($resp,404);
    }
}
