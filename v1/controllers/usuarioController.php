<?php
require('../modelsDAO/alumnoDAO.php');
require('responseHttp.php');

    class usuarioController extends responseHttp{
        function registro_alumno($data){
            $alumno = new alumnoDAO();
           $status = $alumno->registrar($data);
           if($status===true){
            $this->status201("Registro exitoso");
           }
           else{
            $this->status400($status);
           }
        
        }



    }




?>