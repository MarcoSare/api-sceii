<?php

class responseHttp{
    function status201($message, $data=null){
        http_response_code(201);
        if(isset($data))
        $array = [
            "message" => $message,
            "data" => $data
        ];
        
        else
        $array = [
            "message" => $message,
        ];
        echo json_encode($array);
    }

    function status400($message){
        http_response_code(400);
        $array = [
            "message" => $message,
            "satus" => "Error",
            "code" =>  "400"

        ];
        echo json_encode($array);
    }
    function status401($message, $data=null){
        http_response_code(401);
        if(isset($data))
        $array = [
            "message" => $message,
            "satus" => "Error",
            "code" =>  "401",
            "data" => $data
        ];
        
        else
        $array = [
            "message" => $message,
            "satus" => "Error",
            "code" =>  "401"

        ];
        echo json_encode($array);
    }

    function status500($message, $data=null){
        http_response_code(401);
        if(isset($data))
        $array = [
            "message" => $message,
            "satus" => "Error",
            "code" =>  "500",
            "data" => $data
        ];
        
        else
        $array = [
            "message" => $message,
            "satus" => "Error",
            "code" =>  "500"

        ];
        echo json_encode($array);
    }


}

?>