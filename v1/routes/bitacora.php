<?php
header('Content-Type: application/json');
include("../controllers/bitacoraController.php");
    
    


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $bitacora = new bitacoraController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $bitacora->registro($data);
        exit;
    }

   
?>