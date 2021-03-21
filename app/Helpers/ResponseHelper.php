<?php
//Response Success
function responseSuccess($data, $status, $message = "")
{
    $response = [
        "message" => $message,
        "data" => $data["data"]
    ];
    return response()->json($response, $status);
}

// Response Fail
function responseFail($errors, $message = "", $status)
{
    $response = [
        "message" => $message,
        "errors" => $errors
    ];
    return response()->json($response, $status);
}

//Response Message Success
function responseMessageSuccess($message, $status)
{
    $response = [
        "message" => $message,
    ];
    return response()->json($response, $status);
}

// Response Message Fail
function responseMessageFail($message = "", $status)
{
    $response = [
        "message" => $message,
    ];
    return response()->json($response, $status);
}
