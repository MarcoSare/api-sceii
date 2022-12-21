<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});


include_once('../modelsDAO/bitacoraDAO.php');
include_once('../authorization/authorization.php');
include_once('../models/usuario.php');
require_once('responseHttp.php');

    class bitacoraController extends responseHttp{

      
        function registro($data){
            try{
            $auth = new authorization();
            $token_data = $auth->authorizationBytoken();
            $bitacora = new bitacoraDAO;
           $status = $bitacora->registro($token_data['data']['id'], $data);
           if($status["status"]===true){
            $this->status201($status['message']);
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