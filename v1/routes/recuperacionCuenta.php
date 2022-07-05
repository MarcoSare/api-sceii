<?php
header('Content-Type: application/json');
include("../controllers/usuarioController.php");
    
    


    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $correo = $_REQUEST['correo'];
        $usuario = new usuarioController();
        $data = array("correo" => $correo);
        $usuario->getCodigoForgetPass($data);//only correo
        exit;
    }else
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $usuario = new usuarioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $usuario->veriCodigoForgetPass($data);//only correo y codigo
        exit;
    }
    else
    if($_SERVER['REQUEST_METHOD'] == "PATCH"){
        $usuario = new usuarioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $usuario->cambiaPassword($data);//only correo y codigo
        exit;
    }
    
   
?>