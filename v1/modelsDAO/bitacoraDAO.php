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

    class bitacoraDAO extends baseDatos{  
        
        
        function registro ($id_usuario,$data){
            try{
                date_default_timezone_set('America/Mexico_City');
                $date_time = date("Y-m-d G:i:s");  
                $parms="";
                $parms.="'".$id_usuario."'";
                $parms.=",'".$data['id_laboratorio']."'";
                $parms.=",'".$date_time."'";
                $parms.=",'".$data['codigo_bitacora']."'";
                $message = $this->saca_registro("CALL registro_bitacora(".$parms.");");
                    $array = array (
                        "status" => true,
                        "message" => $message->message
                    );
                    return $array;
                    }
                    catch (Exception $e){
                    //"d: ". $e;
                    $array = [
                        "status" => false,
                        "error" => $e->getMessage(),
                        ];
                    return $array;
                    }
        }

       
    
        
    }
    
    

?>