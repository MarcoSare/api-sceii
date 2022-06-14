<?php
header('Content-Type: application/json');
include("../controllers/usuarioController.php");
//$tipoUsuario = $_REQUEST=['tipo'];


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $usuario = new usuarioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $usuario->registro_alumno($data);
        exit;
    }
   

?>