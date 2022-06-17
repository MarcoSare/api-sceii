<?php
include_once('../modelsDAO/materiaDAO.php');
include_once('../authorization/authorization.php');
require_once('responseHttp.php');

    class materiaController extends responseHttp{

        function idex_materia_docente(){
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

        function crea_materia($data){
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

        function borra_materia($data){
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

        function edita_materia($data){
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
           }
           else{
            $this->status400($status["error"]);
           }
        }

        



    }




?>