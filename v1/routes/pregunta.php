<?php
header('Content-Type: application/json');
include("../controllers/preguntaController.php");
    
    


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $pregunta = new preguntaController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $pregunta->crea_pregunta($data);
        exit;
    }
    
   
?>