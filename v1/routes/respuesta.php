<?php
header('Content-Type: application/json');
include("../controllers/respuestaController.php");
    
    


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $respuesta = new respuestaController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $respuesta->crea_respuesta($data);
        exit;
    }
    
   
?>