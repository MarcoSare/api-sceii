<?
    require "../vendor/autoload.php";
    use Firebase\JWT\JWT;
    
    class jsonWebToken{
        function creaToken($correo, $typeUser){
            $time = time();
            $token = array(
                "iat" => $time,
                "exp" => $time + (86400*180),
                "data" => [
                    "correo" => $correo,
                    "typeUser" => $typeUser
                ]
                );
                $jwt = JWT::encode($token,"sceiiv199","HS256");
                return $jwt;
        }   
    }
   

?>