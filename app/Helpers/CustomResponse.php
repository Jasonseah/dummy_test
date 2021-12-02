<?php

function custom_response($data = [], $message, $code = 200)
{
    $jsonObject = [
        "message" => $message,
        'data'    => $data
    ];

    return response()->json($jsonObject, $code);
}


function custom_error_response($err_trace = [], $message, $code = 400)
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
