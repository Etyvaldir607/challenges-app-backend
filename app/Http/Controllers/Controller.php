<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function sendResponse($result, $message, $code = 200) {
        $response = [
            'success' => true,
            'data' => $result,
            'code' => 200
        ];
        return response()->json($response, $code);
    }

    public function sendError($error, $errorMessages, $code = 200) {
        $response = [
            'success' => false,
            'data' => $error,
        ];

        if ( !empty($errorMessages)) {
            $response['info'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

}
