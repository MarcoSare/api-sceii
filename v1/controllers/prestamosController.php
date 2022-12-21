<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

include_once('../modelsDAO/prestamosDAO.php');
include_once('../authorization/authorization.php');
require_once('responseHttp.php');

    class prestamosController extends responseHttp{
        function addPrestamo($data){
            try{
            $auth = new authorization();
            $auth->authorizationByTypeUSer("jefe laboratorio");
            $prestamo = new prestamosDAO();
           $status = $prestamo->addPrestamo($data);
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
//USE 4139110_sceii;

        function indexPrestamoUsuario(){
            try{
            $auth = new authorization();
            $token_data = $auth->authorizationBytoken();
            $prestamo = new prestamosDAO();
           $status = $prestamo->indexPrestamoUsuario($token_data['data']['id']);
           if($status["status"]===true){
            $this->status201("exito",$status["data"]);
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

        function getOnePrestamo($id_prestamo){
            try{
            $prestamo = new prestamosDAO();
           $status = $prestamo->getOnePrestamo($id_prestamo);
           if($status["status"]===true){
            $this->status201("exito",$status["data"]);
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