<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

require_once('usuarioDAO.php');


    class alumno_laboratorioDAO extends usuarioDAO{ 
        function indexByAlumno($id_usuario){
            try{
                $usuario = new usuarioDAO(); //getIdTypeUser
                $id_alumno  = $usuario->getIdTypeUser($id_usuario);
                $this->consulta("call index_alumno_laboratorio('".$id_alumno."');");
                $asoc = $this->get_array_query();
                $array = array (
                    "status" => true,
                    "data" => $asoc);
                return $array;
            }
            catch(Exception $e){
                $array = [
                    "status" => false,
                    "error" => $e->getMessage(),
                    ];
                return $array;
            }
        }

        function  inscribir($data,$id_usuario){
            try{
               
                $usuario = new usuarioDAO(); //getIdTypeUser
                $id_alumno  = $usuario->getIdTypeUser($id_usuario);
                $this->consulta("call inscribir_laboratorio('".$id_alumno."','".$data['codigo']."');");
                $array = array (
                    "status" => true,
                    "message" => 'Labotario Incrito con éxito');
                return $array;
            }
            catch(Exception $e){
                $array = [
                    "status" => false,
                    "error" => $e->getMessage(),
                    ];
                return $array;
            }
        }
    }
    
    

?>