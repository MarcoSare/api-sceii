<?php
header('Content-Type: application/json');
include("../controllers/alumno_materiaController.php");
  


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $aluMat = new alumno_materiaController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $aluMat->inscribir($data);
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $aluMat = new alumno_materiaController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $aluMat->dar_baja($data);
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $aluMat = new alumno_materiaController();
        $aluMat->indexByAlumno();
        exit;
    }
    
   

?>