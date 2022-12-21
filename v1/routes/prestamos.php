<?php
header('Content-Type: application/json');
include("../controllers/prestamosController.php");
  


    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $prestamo = new prestamosController();
        $data = (json_decode(file_get_contents('php://input'),true));
        $prestamo->addPrestamo($data);
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        if(isset($_REQUEST['tipo'])){
            $tipoUsuario = $_REQUEST['tipo'];
            if($tipoUsuario="usuario"){
            $prestamo = new prestamosController();
            $data = (json_decode(file_get_contents('php://input'),true));
            $prestamo->indexPrestamoUsuario();
            exit;
            }
        }
        if(isset($_REQUEST['id_prestamo'])){
            $id = $_REQUEST['id_prestamo'];
            $prestamo = new prestamosController();
            $data = (json_decode(file_get_contents('php://input'),true));
            $prestamo->getOnePrestamo($id);
            exit;
        }

        
        
    }
    
    
   

?>