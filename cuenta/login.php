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

        # Variables
            $correo = trim(strip_tags($_REQUEST['correo']));
            $clave = trim(strip_tags($_REQUEST['clave']));

        # Comprobar usuario
        if (!empty($correo) && !empty($clave)) {

            $_SESSION['correo'] = $correo;
            $_SESSION['clave'] = $clave;
            
            # Conexión con el servidor
                include "../servidor.php";

                $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);      

            # Consulta
                $query = "select * from usuario where correo like '$correo' and clave = $clave";
                // echo "$query <br>";

            # Ejecutar consulta
                $consulta = mysqli_query($conexion,$query) or die ("Fallo en la consulta");
                
            # Nº de filas de la consulta
                $rows = mysqli_num_rows($consulta);

            if ($rows == 1) {
                $bbdd = mysqli_fetch_array($consulta);
                if ($bbdd['tipo_usuario'] == 'aministrador') {
                    header("Location: ../backend/backend.html");
                }
                elseif ($bbdd['tipo_usuario'] == 'vendedor') {
                    header("Location: javascript:history.back()");
                }
                elseif ($bbdd['tipo_usuario'] == 'comprador') {
                    header("Location: javascript:history.back()");
                }
            }
            else {
                echo "<p style='color: red;'>Este usuario no está dado de alta</p>";
            }
        }
        else {
            echo "<p style='color: red;'>El correo o la contraseña no es correcto</p>";
        }
        mysqli_close($conexion);
    }
?>