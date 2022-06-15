<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

require_once('usuarioDAO.php');

    class alumnoDAO extends usuarioDAO{   
        function registrar($usuario){
            try{
            $parms="";
            $parms.="'".$usuario['nombre']."'";
            $parms.=",'".$usuario['apellidos']."'";
            $parms.=",'".$usuario['correo']."'";
            $parms.=",'".$usuario['clave']."'";
            $parms.=",'".$usuario['genero']."'";
            $parms.=",'".$usuario['fecha_nacimiento']."'";
            $parms.=",'".$usuario['no_control']."'";
            $parms.=",'".$usuario['id_carrera']."'";
            $parms.=",'".$usuario['id_semestre']."'";
                $this->consulta("CALL insert_usuario_alumno(".$parms.");");
                $token = $this->insertToken($usuario['correo']);
                $array = array (
                    "status" => true,
                    "data" => array(
                        "token" => $token
                    ));
                return $array;
                }
                catch (Exception $e){
                $array = [
                    "status" => false,
                    "error" => $e->getMessage(),
                    ];
                return $array;
                }
        }
    
        
    }
    
    

?>