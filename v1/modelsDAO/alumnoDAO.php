<?php
require('usuarioDAO.php');

    class alumnoDAO extends usuarioDAO{   
        function registrar($usuario){
            //$token = $this->creaToken($usuario['correo'],"alumno");
            //$parms = "'".$token."'";
            $parms="";
            $parms.="'".$usuario['nombre']."'";
            $parms.=",'".$usuario['apellidos']."'";
            $parms.=",'".$usuario['correo']."'";
            $parms.=",'".$usuario['clave']."'";
            $parms.=",'".$usuario['genero']."'";
            $parms.=",'".$usuario['fecha_nacimiento']."'";
            $parms.=",'".$usuario['no_control']."'";
            $parms.=",'".$usuario['id_carrera']."'";
            $parms.=",'".$usuario['id_semestre']."'";
            try{
                $this->consulta("CALL insert_usuario_alumno(".$parms.");");
                $this->insertToken($usuario['correo']);
                return true;
            }
            catch (Exception $e){
                return mysqli_error($this->conn);
            }
             
        }
    
        
    }
    
    

?>