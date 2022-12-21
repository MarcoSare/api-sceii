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


class prestamosDAO extends baseDatos{

	function addPrestamo($data){
		try{
			$parms="";
			$parms.="'".$data['nombre_herramienta']."'";
			$parms.=",'".$data['descripcion']."'";
            $parms.=",'".$data['fecha_fin']."'";
            $parms.=",'".$data['id_laboratorio']."'";
            $parms.=",'".$data['correo']."'";
			$this->consulta("CALL add_prestamo(".$parms.");");
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

    function indexPrestamoUsuario($id){
		try{
			
			$this->consulta("CALL index_prestamo_usuario('".$id."');");
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

    function getOnePrestamo($id){
		try{
			
			$this->consulta("CALL get_one_prestamo('".$id."');");
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




}


?>