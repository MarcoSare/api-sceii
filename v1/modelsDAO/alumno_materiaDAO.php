<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

require_once('usuarioDAO.php');


    class alumno_materiaDAO extends usuarioDAO{ 

        function  inscribir($data,$id_usuario){
            try{
                $usuario = new usuarioDAO(); //getIdTypeUser
                $id_alumno  = $usuario->getIdTypeUser($id_usuario);
                $this->consulta("call inscribir_materia('".$id_alumno."','".$data['codigo']."');");
                $array = array (
                    "status" => true,
                    "message" => 'Materia Incrita con exito');
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

        function  dar_baja($data,$id_usuario){
            try{
                $usuario = new usuarioDAO(); //getIdTypeUser
                $id_alumno  = $usuario->getIdTypeUser($id_usuario);
                $this->consulta("call dar_baja_materia('".$id_alumno."','".$data['id_materia']."');");
                $array = array (
                    "status" => true,
                    "message" => 'Se ha dado de baja de la materia con exito');
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

        function indexByAlumno($id_usuario){
            try{
                $usuario = new usuarioDAO(); //getIdTypeUser
                $id_alumno  = $usuario->getIdTypeUser($id_usuario);
                $this->consulta("call index_alumno_materia('".$id_alumno."');");
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


       
    }
    
    

?>