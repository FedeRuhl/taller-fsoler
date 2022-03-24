<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function sendResponse($data, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendOK()
    {
    	$response = [
            'success' => true,
            'message' => "",
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function sendServiceError($error)
    {
    	$response = [
            'success' => false,
            'message' => $error->description,
            'code' => $error->code,
            'type' => $error->type, 
        ];        

        return response()->json($response, $error->httpCode);
    }
}