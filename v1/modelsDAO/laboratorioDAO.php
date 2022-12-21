<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

require_once('connection.php');
require_once "../vendor/autoload.php";
require_once('usuarioDAO.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

    class laboratorioDAO extends baseDatos{  
        
        
        function crear($datos,$id_usuario){
            try{
            $usuario = new usuarioDAO(); //getIdTypeUser
            $id_jefe  = $usuario->getIdTypeUser($id_usuario);
            //echo $id_jefe;
            $codigo_bitacora = $this->get_codigo_bitacora($datos['nombre'], $id_jefe);
            //echo $codigo_bitacora;
            $parms="";
            $parms.="'".$id_jefe."'";
            $parms.=",'".$datos['nombre']."'";
            $parms.=",'".$this->get_codigo_acceso()."'";
            $parms.=",'".$codigo_bitacora."'";
                
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

        function get_laboratorio($id){
            try{    
            $this->consulta("CALL get_laboratorio(".$id.");");
            $asoc = $this->get_array_query();
                $array = array (
                    "status" => true,
                    "data" => $asoc
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


        function get_laboratorio_cod_acc($coidgo_acceso){
            try{
            $registro = $this->saca_registro("select id from laboratorio where codigo_acceso = '".$coidgo_acceso."'");
            if($registro==null){
                $array = [
                    "status" => false,
                    "error" => "El laboratorio no existe",
                    ];
                return $array;
            }
            $id = $registro->id;   
            $this->consulta("CALL get_laboratorio(".$id.");");
            $asoc = $this->get_array_query();
                $array = array (
                    "status" => true,
                    "data" => $asoc
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


        function get_codigo_acceso(){
            $leng =  rand(5, 10);
            $codigo="";
            for($i=0;$leng>$i;$i++){
                $opcion = rand(0,2);
                if($opcion==0)
                    $codigo.= chr(rand(48,57));
                    else 
                    if($opcion==1)
                        $codigo.= chr(rand(65,90));
                        else
                            $codigo.= chr(rand(97,122));    
            }
            return $codigo;
        }

        function get_codigo_bitacora($nombre,$id_jefe){
            $time = time();
            $token = array(
                "time" => $time,
                "data" => [
                    "nombre" => $nombre,
                    "id" => $id_jefe
                ]
                );
                $jwt = JWT::encode($token,"sceiiv199","HS256");
                return $jwt;
        }
        

       
    
        
    }
    
    

?>