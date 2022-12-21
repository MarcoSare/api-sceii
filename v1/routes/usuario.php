<?php
header('Content-Type: application/json');
include("../controllers/usuarioController.php");

    if($_SERVER['REQUEST_METHOD'] == "PATCH"){
        $usuario = new usuarioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $usuario->editUsuario($data);
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $usuario = new usuarioController();
        $usuario->getUsuario();
        exit;
    }
    
     if($_SERVER['REQUEST_METHOD'] == "POST"){
         $metodo = $_REQUEST['metodo'];
         if($metodo=="PATCH"){
            $usuario = new usuarioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $usuario->editUsuario($data);
        exit;     
         }
         if($metodo=="DELETE"){
            $usuario = new usuarioController();
            $data = (json_decode(file_get_contents('php://input'),true));
            $usuario->deleteUsuario($data);
            exit;         
         }
        
    }
    
    
?>