<?php
//Response Success
function responseSuccess($data, $status, $message ="")
{
    $response = [
        "message" => $message,
        "data" => $data["data"]
    ];
    return response()->json($response, $status);
}

// Response Fail
function responseFail ($errors, $message = "", $status)
{
    $response = [
        "message" => $message,
        "errors" => $errors
    ];
    return response()->json($response, $status);
}
