<?php
header('Content-Type: application/json');
include("../controllers/materiaController.php");
  


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $materia = new materiaController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $materia->crea_materia($data);
        exit;
    }

?>