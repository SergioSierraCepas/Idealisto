<?php
session_start();
?>
<html>
    <head>
        <title>Práctica PHP+MySQL+Seguridad</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../codigoCSS.css">
    </head>
    <body>
        <a href="../index.php"><img src="../imagenes_index/logo.png" alt="" class="home"></a>
        <h2><u>Inicio de sesión</u></h2>
        <p class="otro">¿Eres nuevo? <a href="registro.php">Registrate</a></p>
        <div>
            <form action="login.php" method="post">
                <input type="email" class="input" name="correo" placeholder="Correo electrónico" required><br>
                <input type="password" class="input" name="clave" placeholder="Contraseña" required><br>
                <input type="submit" class="submit" name="iniciosesion" value="Iniciar Sesión">
            </form>
        </div>
    </body>
</html>
<?php

    if (isset($_REQUEST['iniciosesion'])) {

        # Declarar variables con control de etiqueras y espacios
            $correo = trim(strip_tags($_REQUEST['correo']));
            $clave = trim(strip_tags($_REQUEST['clave']));

        # Si correo no esta vacío y la longitud de clave > 8
            if (filter_var($correo, FILTER_VALIDATE_EMAIL) && strlen($clave) >= 8) {

                # Declarar variables
                    $_SESSION['correo'] = $correo;
                    $clave=md5($clave);
                
                # Conexión con el servidor
                    include "../servidor.php";

                    $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);      

                # Consulta
                    $query = "select * from usuario where correo like '$correo' and clave = '$clave'";
                    // echo "$query <br>";

                # Ejecutar consulta
                    $consulta = mysqli_query($conexion,$query) or die ("Fallo en la consulta");
                    
                # Nº de filas de la consulta
                    $rows = mysqli_num_rows($consulta);

                # Dependiendo del tipo de usuario que sea lo manda a su Index correspondiente
                    if ($rows == 1) {
                        $bbdd = mysqli_fetch_array($consulta);
                        if ($bbdd['tipo_usuario'] == 'administrador') {
                            header("Location: ../backend/backend.html");
                        }
                        elseif ($bbdd['tipo_usuario'] == 'vendedor') {
                            header("Location: ../index.php");
                        }
                        elseif ($bbdd['tipo_usuario'] == 'comprador') {
                            header("Location: ../index.php");
                        }
                    }
                # Si el usuario no existe
                    else {
                        echo "<p class='alertas'>Este usuario no está dado de alta</p>";
                    }
            }
        # Si correo y clave no son correctos
            else {
                echo "<p class='alertas'>El correo o la contraseña no es correcto</p>";
            }

        mysqli_close($conexion);
    }
?>