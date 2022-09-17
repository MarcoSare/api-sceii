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

    class preguntaDAO extends baseDatos{  
        
        
        function crear($data,$id_jefe_laboratorio){
            try{
            $user = new usuarioDAO;
            $id_jefe_laboratorio = $user->getIdTypeUser($id_jefe_laboratorio);    
            $parms="";
            $parms.="'".$data['pregunta']."'";
            $parms.=",'".$data['id_cuestionario']."'";
            $parms.=",'".$id_jefe_laboratorio."'";
            $this->consulta("CALL crea_pregunta(".$parms.");");
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