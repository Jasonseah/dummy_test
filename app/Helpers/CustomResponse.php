<?php

use Illuminate\Http\JsonResponse;

function custom_response($message, $data = [], $code = 200): JsonResponse
{
    $jsonObject = [
        "message" => $message,
        'data'    => $data
    ];

    return response()->json($jsonObject, $code);
}


function custom_error_response($message, $err_trace = [], $code = 400): JsonResponse
{
    Log::error('Something is really going wrong.', $err_trace);

    $jsonObject = [
        "message" => $message,
    ];

    if (app()->env !== 'production') {
        $jsonObject['err'] = $err_trace;
    }

    return response()->json($jsonObject, $code);
}
