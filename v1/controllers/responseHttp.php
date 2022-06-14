<?php

class responseHttp{
    function status201($message, $data=null){
        http_response_code(201);
        $array = [
            "message" => $message
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


}

?>