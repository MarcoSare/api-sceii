<?php
header('Content-Type: application/json');
include("../controllers/practicasController.php");
    
    


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $practicas = new practicasController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $practicas->crea_practica($data);
        exit;
    }
    
   
?>