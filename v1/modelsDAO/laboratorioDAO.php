<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

require_once('connection.php');
require_once('usuarioDAO.php');

    class laboratorioDAO extends baseDatos{  
        
        
        function crear($datos,$id_usuario){
            try{
            $usuario = new usuarioDAO(); //getIdTypeUser
            $id_jefe  = $usuario->getIdTypeUser($id_usuario);
            //echo $id_jefe;
            $parms="";
            $parms.="'".$id_jefe."'";
            $parms.=",'".$datos['nombre']."'";
           
                
            $this->consulta("CALL crea_laboratorio(".$parms.");");
                $array = array (
                    "status" => true,
                );
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