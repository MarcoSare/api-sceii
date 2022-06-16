<?php
include_once('../modelsDAO/materiaDAO.php');
include_once('../authorization/authorization.php');
require('responseHttp.php');

    class materiaController extends responseHttp{

        function crea_materia($data){
            $auth = new authorization();
            $token_data = $auth->authorizationByTypeUSer("docente");
            $materia = new materiaDAO();
            echo "id_u: ".$token_data['data']['id'];
           $status = $materia->crear($data, $token_data['data']['id']);
           if($status["status"]===true){
            $this->status201("Registro exitoso", $status["data"]);
           }
           else{
            $this->status400($status["error"]);
           }
        }

        



    }




?>