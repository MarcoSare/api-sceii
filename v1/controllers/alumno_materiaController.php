<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
include_once('../modelsDAO/alumno_materiaDAO.php');
include_once('../authorization/authorization.php');
require_once('responseHttp.php');

    class alumno_materiaController extends responseHttp{

        function inscribir($data){
            try{
                $auth = new authorization();
            $token_data = $auth->authorizationByTypeUSer("alumno");
            
            $aluMat = new alumno_materiaDAO();
            $status = $aluMat->inscribir($data,$token_data['data']['id']);
            if($status["status"]===true){
                $this->status201("Materia Inscrita con exito");
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

        function dar_baja($data){
            try{
            $auth = new authorization();
            $token_data = $auth->authorizationByTypeUSer("alumno");
            $aluMat = new alumno_materiaDAO();
            $status = $aluMat->dar_baja($data,$token_data['data']['id']);
            if($status["status"]===true){
                $this->status201("Se ha dado de baja de la materia con exito");
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

        function indexByAlumno(){
            try{
            $auth = new authorization();
            $token_data = $auth->authorizationBytoken();
            $aluMat = new alumno_materiaDAO();
            $status = $aluMat->indexByAlumno($token_data['data']['id']);
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

       

    }
?>