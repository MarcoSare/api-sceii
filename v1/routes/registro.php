<?php
header('Content-Type: application/json');
include("../controllers/usuarioController.php");
    
    


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $tipoUsuario = $_REQUEST['tipo'];
        if($tipoUsuario == "alumno"){
        $usuario = new usuarioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $usuario->registro_alumno($data);
        exit;
        }
        if($tipoUsuario == "docente"){
            $usuario = new usuarioController();
            $data = (json_decode(file_get_contents('php://input'),true));
            $usuario->registro_docente($data);
            exit;
        }
        if($tipoUsuario == "visitante"){
            $usuario = new usuarioController();
            $data = (json_decode(file_get_contents('php://input'),true));
            $usuario->registro_visitante($data);
            exit;
        }
    }else
    if($_SERVER['REQUEST_METHOD'] == "PATCH"){
            $usuario = new usuarioController();
            $usuario->dar_alta();
            exit;

    }
    
   
?>