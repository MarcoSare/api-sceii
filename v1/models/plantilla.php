<?php
class plantilla_mail{
    function get_plantilla($nombre, $link){
        return '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        
        <body>
        <section class="home" id="home" style="
                display:flex;
                justify-content: center;
                align-items: center;">
                <div class="home__container container grid">
                  <div style="
                display:flex;
                justify-content: center;
                align-items: center;">
                          <img src="https://labmanufactura.net/SCEII/public/img/welcome.png" alt="" width="300px"  height="300px">
                  </div>
                  <div class="home__data">
                    <h2 class="home__title"
                    style="
                     text-align: center;
                    "
                    >
                      Sistema de control estudiantil de ingeniería industrial
                    </h2>
                    <h3 class="home__description" style="
                     text-align: center;
                    ">
                      Bienvenido '.$nombre.'<br>
                      Da click en el botónn de abajo para finalizar con tu registro
                    </h3>
                    <div style="
                    display:flex;
                    justify-content: center;
                    align-items: center;
                    ">
                    <a href="'.$link.'" 
                    style = "text-decoration: none;
                    cursor: pointer;
                    border: none;
                    outline: none;
                    font-size: 1rem;
                    display: inline-block;
                    background-color: #46A525;
                    color: #FFF;
                    padding: 1rem 1.75rem;
                    border-radius: .5rem;
                    font-weight: 500;
                    transition: .3s;
                    "
                    >
                    Iniciar
                    </a>
                    </div>
                  </div>
                </div>
              </section>
        </body>
        </html>';
    }
}

?>