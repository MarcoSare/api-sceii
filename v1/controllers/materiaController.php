<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

include_once('../modelsDAO/materiaDAO.php');
include_once('../authorization/authorization.php');
require_once('responseHttp.php');

    class materiaController extends responseHttp{

        function idex_materia_docente(){
            try{

            
            $auth = new authorization();
            $token_data = $auth->authorizationByTypeUSer("docente");
            $materia = new materiaDAO();
           $status = $materia->indexByDocente($token_data['data']['id']);
           if($status["status"]===true){
            $this->status201("exitoso", $status["data"]);
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

        function get_materia($data){
            try{
                $materia = new materiaDAO();
                $status = $materia->getMateriaById($data['id']);
               if($status["status"]===true){
                $this->status201("exitoso", $status["data"]);
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

        function crea_materia($data){
            try{
                $auth = new authorization();
            $token_data = $auth->authorizationByTypeUSer("docente");
            $materia = new materiaDAO();
           $status = $materia->crear($data, $token_data['data']['id']);
           if($status["status"]===true){
            $this->status201("Registro exitoso", $status["data"]);
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

        function borra_materia($data){
            try{
                $materia = new materiaDAO();
                //echo $data['id'];
                $id_docente = $materia->getDocenteByMateria($data['id']);
                if($id_docente['status']===false){
                    $this->status400($id_docente["error"]);
                }
                $auth = new authorization();
                $auth->authorizationById($id_docente['data']['id_docente']);
               $status = $materia->borrar($data['id']);
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

        function edita_materia($data){
            try{
            $materia = new materiaDAO();
            //echo $data['id'];
            $id_docente = $materia->getDocenteByMateria($data['id']);
            if($id_docente['status']===false){
                $this->status400($id_docente["error"]);
            }
            $auth = new authorization();
            $auth->authorizationById($id_docente['data']['id_docente']);
           $status = $materia->editar($data);
           if($status["status"]===true){
            $this->status201($status['message']);
            exit;
           }
           else{
            $this->status400($status["error"]);
            exit;
           }
        }
        catch(Exception $e) {
            $this->status400($e->getMessage());
            exit;
        }
        }

        



    }
?>