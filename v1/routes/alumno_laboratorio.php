<?php
header('Content-Type: application/json');
include("../controllers/alumno_laboratorioController.php");
  


    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $aluLab = new alumno_laboratorioController();
        $aluLab->indexByAlumno();
        exit;
    }
    
   

?>