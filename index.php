<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="codigoCSS.css">
    <title>Práctica PHP+MySQL+Seguridad</title>
</head>
    <body>
        <div class="divlogo">
            <?php
                if ($_SESSION['correo'] == null) {
                    echo "<a href='./cuenta/login.php'><img src='./imagenes_index/pibe.jpg' class='imglogin' title='Iniciar Sesión'></a>";
                }
                else {
                    echo "<a href='./cuenta/perfil.php'><img src='./imagenes_index/pibe.jpg' class='imglogin' title='Perfil'></a>";
                }
            ?>
          
            <img src="./imagenes_index/logo.png" alt="" class="logoindex">
        </div>
            <table class="index">
                <tr>
                    <td>
                        <a href="./frontend/comprar.php"><img src="./imagenes_index/compra.jpg" alt="" class="fotosindex"></a>
                    </td>
                    <td>
                        <a href="./frontend/vender.php"><img src="./imagenes_index/vender.jpg" alt="" class="fotosindex"></a>
                    </td>
                    <td>
                        <a href="./frontend/mis_pisos.php"><img src="./imagenes_index/mis_pisosjpg.jpg" alt="" class="fotosindex"></a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="pindex"><i>Comprar un piso</i></p>
                    </td>
                    <td>
                        <p class="pindex"><i>Vender un piso</i></p>
                    </td>
                    <td>
                        <p class="pindex"><i>Mis pisos</i></p>
                    </td>
                </tr>


        </div>
    </body>
</html>