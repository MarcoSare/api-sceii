<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

include_once('../modelsDAO/alumnoDAO.php');
include_once('../modelsDAO/docenteDAO.php');
include_once('../modelsDAO/visitanteDAO.php');
include_once('../modelsDAO/jefe_laboratorioDAO.php');
include_once('../authorization/authorization.php');
include_once('../models/usuario.php');
require_once('responseHttp.php');

    class usuarioController extends responseHttp{

        function registro_alumno($data){
            $alumno = new alumnoDAO();
           $status = $alumno->registrar($data);
           if($status["status"]===true){
            $this->enviar_confirmacion($data);
            $this->status201("Registro exitoso", $status["data"]);
           }
           else{
            $this->status400($status["error"]);
           }
        }

        function registro_jefe_laboratorio($data){
            $jefe_laboratorio = new jefe_laboratorioDAO();
           $status = $jefe_laboratorio->registrar($data);
           if($status["status"]===true){
            $this->status201("Registro exitoso", $status["data"]);
           }
           else{
            $this->status400($status["error"]);
           }
        }

        function registro_docente($data){
            $docente = new docenteDAO();
            $status = $docente->registrar($data);
            if($status["status"]===true){
                $this->enviar_confirmacion($data);
                $this->status201("Registro exitoso", $status["data"]);
               }
               else{
                $this->status400($status["error"]);
               }
        }

        function registro_visitante($data){
            $visitante = new visitanteDAO();
            $status = $visitante->registrar($data);
            if($status["status"]===true){
                $this->enviar_confirmacion($data);
                $this->status201("Registro exitoso", $status["data"]);
               }
               else{
                $this->status400($status["error"]);
               }
        }

        function getCodigoForgetPass($data){
            $usuario = new alumnoDAO();//usamos el objeto alumno para logear ya que hereda de usuario y puede acceder a eso metodos
            $status = $usuario->getCodigoForgetPass($data);
            if($status["status"]===true){
                $this->enviar_codigo_pass($data,$status['data']['codigo']);
                $this->status201("Codigo enviado exitosamente", $status["data"]);
               }
               else{
                $this->status400($status["error"]);
               }
        }

        function veriCodigoForgetPass($data){
            $usuario = new alumnoDAO();//usamos el objeto alumno para logear ya que hereda de usuario y puede acceder a eso metodos
            $status = $usuario->veriCodigoForgetPass($data);
            if($status["status"]===true){
                $this->status201("Confirmacion exitosamente");
               }
               else{
                $this->status400($status["error"]);
               }
        }

        function cambiaPassword($data){
            $usuario = new alumnoDAO();//usamos el objeto alumno para logear ya que hereda de usuario y puede acceder a eso metodos
            $status = $usuario->cambiaPassword($data);
            if($status["status"]===true){
                $this->status201("Password actualizada exitosamente");
               }
               else{
                $this->status400($status["error"]);
               }
        }
        

        function dar_alta(){
            $usuario = new alumnoDAO();//usamos el objeto alumno para logear ya que hereda de usuario y puede acceder a eso metodos
            $status = $usuario->dar_alta();
            if($status["status"]===true){
                $this->status201("Su cuenta ha sido dada de alta exitosamente", $status["data"]);
               }
               else{
                $this->status400($status["error"]);
               }
        }

        function login($data){
            $usuario = new alumnoDAO();//usamos el objeto alumno para logear ya que hereda de usuario y puede acceder a eso metodos
            $status = $usuario->login($data);
            if($status["status"]===true){
                $this->status201("Login exitoso", $status["data"]);
               }
               else{
                $this->status400($status["error"]);
               }
        }

        function editUsuario($data){
            $auth = new authorization();
            $usuario = new alumnoDAO();
            $token_data = $auth->authorizationByToken();
            $status = $usuario->editUsuario($data, $token_data['data']['id']);
            if($status["status"]===true){
                $this->status201("Datos actualizado correctamente");
               }
               else{
                $this->status400($status["error"]);
               }
        }
        function deleteUsuario($data){
            $auth = new authorization();
            $usuario = new alumnoDAO();
            $token_data = $auth->authorizationByToken();
            $status = $usuario->deleteUsuario($data, $token_data['data']['id']);
            if($status["status"]===true){
                $this->status201("Su cuenta ha sido eliminada correctamente");
               }
               else{
                $this->status400($status["error"]);
               }
        }

        function getUsuario(){
            $auth = new authorization();
            $usuario = new alumnoDAO();
            $token_data = $auth->authorizationByToken();
            $status = $usuario->getUsuario($token_data['data']['id']);
            if($status["status"]===true){
                $this->status201("exito",$status["data"]);
               }
               else{
                $this->status400($status["error"]);
               }
        }

        function enviar_confirmacion($data){
            $usuario = new alumnoDAO();
            $registro = $usuario->saca_registro("select id, tipoUsuario from usuario where correo = '".$data['correo']."'");
            $id = $registro->id;
            $email = new model_usuario();
            $token = $usuario->creaToken($id,"","");
            $link="https://labmanufactura.net/SCEII/confirmarCuenta/".$token;
            $email->enviar_confirmacion($link,$data['nombre'],$data['apellidos'],$data['correo']);
        }


        function enviar_codigo_pass($data, $codigo){
            $usuario = new alumnoDAO();
            $registro = $usuario->saca_registro("select nombre, apellidos from usuario where correo = '".$data['correo']."'");
            $nombre = $registro->nombre;
            $apellidos = $registro->apellidos;
            $email = new model_usuario();
            $email->enviarCodigoPass($codigo,$nombre,$apellidos,$data['correo']);
        }

        



    }




?>