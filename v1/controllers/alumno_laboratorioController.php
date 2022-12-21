<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
include_once('../modelsDAO/alumno_laboratorioDAO.php');
include_once('../authorization/authorization.php');
require_once('responseHttp.php');

    class alumno_laboratorioController extends responseHttp{
        function indexByAlumno(){
            try{
            $auth = new authorization();
            $token_data = $auth->authorizationBytoken();
            $aluLab = new alumno_laboratorioDAO();
            $status = $aluLab->indexByAlumno($token_data['data']['id']);
            if($status["status"]===true){
                $this->status201("exito", $status["data"]);
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

        function inscribir($data){
            try{
            $auth = new authorization();
            $token_data = $auth->authorizationByTypeUSer("alumno");
            $aluMat = new alumno_laboratorioDAO();
            $status = $aluMat->inscribir($data,$token_data['data']['id']);
            if($status["status"]===true){
                $this->status201("Laboratorio Inscrito con éxito");
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