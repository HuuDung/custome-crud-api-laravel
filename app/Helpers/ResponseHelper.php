<?php
function responseSuccess($data, $status, $message ="")
{
    $response = [
        "message" => $message,
        "data" => $data["data"]
    ];
    return response()->json($response, $status);
}
