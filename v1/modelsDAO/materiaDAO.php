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

    class materiaDAO extends baseDatos{  
        
        function getMateriaById($id_materia){
            try{
            $this->consulta("CALL get_materia('".$id_materia."');");
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
        
        function crear($datos,$id_usuario){
            try{
            $usuario = new usuarioDAO(); //getIdTypeUser
            $id_docente  = $usuario->getIdTypeUser($id_usuario);
            $codigo = $this->getCodigo();
            $parms="";
            $parms.="'".$datos['nombre']."'";
            $parms.=",'".$codigo."'";
            $parms.=",'".$id_docente."'";
            $parms.=",'".$datos['id_semestre']."'";
                $this->consulta("CALL crea_materia(".$parms.");");
                $array = array (
                    "status" => true,
                    "data" => array(
                        "codigo" => $codigo
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

        function borrar($id){
            try{
                $this->consulta("CALL delete_materia('".$id."');");
                $array = array (
                    "status" => true,
                    "message" => 'Registro borrado con exito');
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

        function editar($data){
            try{
                $parms="";
                $parms.="'".$data['id']."'";
                $parms.=",'".$data['nombre']."'";
                $parms.=",'".$data['id_semestre']."'";
                $this->consulta("call edit_materia(".$parms.");");
                $array = array (
                    "status" => true,
                    "message" => 'Registro editado con exito');
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

        function indexByDocente($id_usuario){
            try{
                $usuario = new usuarioDAO(); //getIdTypeUser
                 $id_docente  = $usuario->getIdTypeUser($id_usuario);
                $this->consulta("call index_materia_docente('".$id_docente."');");
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

        function getDocenteByMateria($id){
            try{
                $registro = $this->saca_registro("CALL get_docente_by_materia('".$id."');");
                $usuario = new usuarioDAO(); //getIdTypeUser
                $id_usuario  = $usuario->getIdUser($registro->id_docente,"docente");
                $array = array (
                    "status" => true,
                    "data" => array(
                        "id_docente" =>  $id_usuario 
                    ));
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

        function getCodigo(){
            $bandera = true;
            $codigo="";
            while($bandera){
                try{
                    $lenght = rand(5,10);
                    for($i=0;$lenght>$i;$i++){
                        $n = rand(1,3);
                        if($n==1){
                           $codigo.=chr(rand(48,57)); 
                        }else
                        if($n==2){
                        $codigo.=chr(rand(65,90)); 
                        }else{
                            $codigo.=chr(rand(97,122)); 
                        }
                    }
                    $this->consulta("CALL veri_codigo('".$codigo."');");
                    $bandera = false;
                }
                catch(Exception  $e){
                    $bandera = true;
                }
            }
            return $codigo;
            
        }
    
        
    }
    
    

?>