<?php
header('Content-Type: application/json');
include("../controllers/laboratorioController.php");
    
    


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $laboratorio = new laboratorioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $laboratorio->crea_laboratorio($data);
        exit;
    }
    
   
?>