<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
header('Content-Type: application/json');
include("../controllers/usuarioController.php");
require_once("../modelsDAO/connection.php");//'connection.php');
include_once "../vendor/autoload.php";
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        try{
            $data = json_decode(file_get_contents('php://input'),true);
        //Autorización del token 
        $token_data = authorizationBytoken();
        $image = $data["imagen"];
        //$extencion = $data["extencion"];
        $image = str_replace('data:image/png;base64,','',$image);
        $image = str_replace(' ',"+",$image);
        $imgName = "ImagenesUsuarios/foto_perfil_".$token_data['data']['id'].'.jpg';
        $host= $_SERVER["HTTP_HOST"];
        file_put_contents($imgName, base64_decode($image));
        http_response_code(201);
        $array = [
            "message" => "se ha subido exitosamente la imagen",
            "code" =>  "201",
            "link" => "http://".$host.getRoute()."ImagenesUsuarios/foto_perfil_".$token_data['data']['id'].'.jpg'
        ];
        echo json_encode($array);
        }
        catch(Exception $e){
                echo $e;
        }
        
    }

    function getRoute(){
        $data = explode("/",$url= $_SERVER["REQUEST_URI"]); 
        $return ="";
        for($i=0;count($data)-1>$i;$i++)
        $return.= $data[$i]."/";
        return $return;
    }

    function authorizationBytoken(){
        try{
            $bd = new baseDatos();
            $headers = apache_request_headers();
            if(isset($headers['Authorization']))
            $token = $headers['Authorization'];
            else
            $token = $headers['authorization'];
            $bd->consulta("CALL veri_token('".$token."');");
            $jwt_decode = decode_jwt($token);
            $array = json_decode(json_encode($jwt_decode, true),true);
                if(isset($array['data']['id']))
                return $array;
                else{
                    $http = new responseHttp();
                    $http->status401('Error ustede no tiene authorización');
                    exit;
                }
        }
        catch(Exception $e){
            $http = new responseHttp();
            $http->status500("no se ha subido la imagen al servidor". $e);
            exit;
        }
    }

    function decode_jwt($token){
        $jwt_decode = JWT::decode($token, new Key("sceiiv199", 'HS256'));
        return  $jwt_decode;
    }
?>