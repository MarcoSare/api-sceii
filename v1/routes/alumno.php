<?php
header('Content-Type: application/json');
include("../controllers/usuarioController.php");
  


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $usuario = new usuarioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $usuario->login($data);
        exit;
    }
    
   

?>