<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

include_once('../modelsDAO/laboratorioDAO.php');
include_once('../authorization/authorization.php');
require_once('responseHttp.php');

    class laboratorioController extends responseHttp{


        function crea_laboratorio($data){
            try{
            $auth = new authorization();
            $token_data = $auth->authorizationByTypeUSer("jefe laboratorio");
            $laboratorio = new laboratorioDAO();
           $status = $laboratorio->crear($data, $token_data['data']['id']);
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


        function get_laboratorio($id){
            try{
            $laboratorio = new laboratorioDAO();
           $status = $laboratorio->get_laboratorio($id);
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

        function get_laboratorio_cod_acc($id){
            try{
            $laboratorio = new laboratorioDAO();
           $status = $laboratorio->get_laboratorio_cod_acc($id);
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