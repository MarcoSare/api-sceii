<?php
header('Content-Type: application/json');
include("../controllers/materiaController.php");
  


    if($_SERVER['REQUEST_METHOD'] == "GET"){
    $materia = new materiaController();
    $data = (json_decode(file_get_contents('php://input'),true));
    $materia->get_materia($data);
    exit;
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $materia = new materiaController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $materia->crea_materia($data);
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $materia = new materiaController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $materia->borra_materia($data);
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == "PATCH"){
        $materia = new materiaController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $materia->edita_materia($data);
        exit;
    }

?>