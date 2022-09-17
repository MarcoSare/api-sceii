<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});


include_once('../modelsDAO/respuestaDAO.php');
include_once('../authorization/authorization.php');
include_once('../models/usuario.php');
require_once('responseHttp.php');

    class respuestaController extends responseHttp{

      
        function crea_respuesta($data){
            try{
            $auth = new authorization();
            $token_data = $auth->authorizationByTypeUSer("jefe laboratorio");
            //echo ($token_data['data']['id']);
            $respuesta = new respuestaDAO();
           $status = $respuesta->crear($data,$token_data['data']['id']);
           if($status["status"]===true){
            $this->status201("Registro exitoso");
           }
           else{
            $this->status400($status["error"]);
           }
        }
        catch(Exception $e){
            $this->status400($e->getMessage());
            exit;
        }
        }
    }

?>