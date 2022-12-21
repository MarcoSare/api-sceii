<?php
header('Content-Type: application/json');
include("../controllers/alumno_laboratorioController.php");
  


    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $aluLab = new alumno_laboratorioController();
        $aluLab->indexByAlumno();
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $aluLab = new alumno_laboratorioController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $aluLab->inscribir($data);
        exit;
    }
   

?>