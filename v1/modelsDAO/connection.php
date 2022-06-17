<?php

class baseDatos{

	var $conn;
	var $bloque;
	var $numeRegistros;
	function __construct()
	{
		
	}
	function conecta(){
		$this->conn = mysqli_connect("localhost", "root","","sceii");
        return $this->conn;
	}

	function consulta($query){
		$this->conecta();
		$this->bloque = mysqli_query($this->conn, $query);
		if(strpos(strtoupper($query),"SELECT") !== false)
		$this->numeRegistros=mysqli_num_rows($this->bloque);
		$this->cerrar();
		return $this->bloque;
	}

	function get_array_query(){
		$arreglo = array();
		while($row=mysqli_fetch_assoc($this->bloque)){
			$arreglo[] = $row;
		}
		return $arreglo;
	}


	function inserta($query){
		$this->conecta();
		mysqli_query($this->conn, $query);
		$this->cerrar();
	}
	
	function saca_registro($query){
		$this->consulta($query);
		return mysqli_fetch_object($this->bloque);
	}

	function procesar(){

	}
	function cerrar(){
		mysqli_close($this->conn);
	}

	


}
?>