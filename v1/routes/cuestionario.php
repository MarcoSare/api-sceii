<?php
header('Content-Type: application/json');
include("../controllers/cuestionarioController.php");
    
    


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $cuestionario = new cuestionarioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $cuestionario->crea_cuestionario($data);
        exit;
    }
    
   
?>