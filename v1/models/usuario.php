<?php
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

include_once("../resources/class.phpmailer.php");
include_once("../resources/class.smtp.php");
include_once('plantilla.php');
class model_usuario{
    function enviar_confirmacion($link,$nombre,$apellidos,$correo){
        $mail = new PHPMailer();
        $plantilla = new plantilla_mail();
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host="smtp.gmail.com"; //mail.google
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Port = 465;     // set the SMTP port for the GMAIL server
    $mail->SMTPDebug  = false;  // enables SMTP debug information (for testing)
                              // 1 = errors and messages
                              // 2 = messages only
    $mail->SMTPAuth = true;   //enable SMTP authentication
    
    $mail->Username =   "sceii.itcelaya@gmail.com"; // SMTP account username
    $mail->Password = "okqrjsltakrujeuj";  // SMTP account password
      
    $mail->From="sceii.itcelaya@gmail.com";
    $mail->FromName=utf8_encode("Sistema de Control Estudiantil de Ingeniería Industrial");
    $mail->Subject = "Registro completo";
    $mail->MsgHTML($plantilla-> get_plantilla(($nombre.' '.$apellidos), $link));
    $mail->AddAddress($correo);
    //$mail->AddAddress("admin@admin.com");
    if (!$mail->Send()) 
          echo  "Error: " . $mail->ErrorInfo;
    else { 
         //$result= $oBD->inserta($cad);
           //header("location: ../login.php?e=2"); 
         }

    }

    function enviarCodigoPass($codigo,$nombre,$apellidos,$correo){
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host="smtp.gmail.com"; //mail.google
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Port = 465;     // set the SMTP port for the GMAIL server
    $mail->SMTPDebug  = false;  // enables SMTP debug information (for testing)
                              // 1 = errors and messages
                              // 2 = messages only
    $mail->SMTPAuth = true;   //enable SMTP authentication
    
    $mail->Username =   "sceii.itcelaya@gmail.com"; // SMTP account username
    $mail->Password = "okqrjsltakrujeuj";  // SMTP account password
      
    $mail->From="sceii.itcelaya@gmail.com";
    $mail->FromName=utf8_decode("Sistema de control academico de ingeniería Industrial");
    $mail->Subject = utf8_decode("Recuperación de cuenta");
    $mail->MsgHTML(utf8_decode("<h1>Hola ".$nombre." ".$apellidos."</h1><h2>Codigo de recuperación de contraseña : ".$codigo."</h2>"));
    $mail->AddAddress($correo);
    //$mail->AddAddress("admin@admin.com");
    if (!$mail->Send()) 
          echo  "Error: " . $mail->ErrorInfo;
    else { 
         //$result= $oBD->inserta($cad);
           //header("location: ../login.php?e=2"); 
         }

    }
}






?>