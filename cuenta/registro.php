<html>
    <head>
        <title>Práctica PHP+MySQL+Seguridad</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../codigoCSS.css">
    </head>
    <body>
        <a href="../index.php"><img src="../imagenes_index/logo.png" alt="" class="home"></a>
        <h2><u>Registro</u></h2>
        <p class="otro">¿Ya tienes una cuenta? <a href="./login.php">Inicia Sesión</a></p>
        <form action="registro.php" method="post">
            <input type="text" class="input" name="nombre" placeholder="Nombre" required><br>
            <input type="email" class="input" name="correo" placeholder="Correo electrónico" required><br>
            <input type="password" class="input" name="clave" placeholder="Contraseña" required><br>
            <p class="input">¿Qué te interesa?
                <select name="tipo" id="" required>
                    <option value="0"> </option>
                    <option value="1">Comprar</option>
                    <option value="2">Vender</option>
                </select>
            </p>
            <input type="submit" class="submit" name="registrar" value="Registrar">
        </form>
    </body>
</html>
<?php

    if (isset($_REQUEST['registrar'])) {

        # Declarar variables con control de etiqueras y espacios
            $nombre = trim(strip_tags($_REQUEST['nombre']));
            $correo = trim(strip_tags($_REQUEST['correo']));
            $clave = trim(strip_tags($_REQUEST['clave']));
            $tipo = trim(strip_tags($_REQUEST['tipo']));

        # Control de errores
            if (strlen($nombre) > 4 && filter_var($correo, FILTER_VALIDATE_EMAIL) && strlen($clave) >= 8 && ($tipo == 1 || $tipo == 2)) {
                
                $clave = md5($clave);

                # Determinar el tipo de usuario
                    if ($tipo == 1) {
                        $tipo = 'comprador';
                    }
                    elseif ($tipo == 2) {
                        $tipo = 'vendedor';
                    }
                
                # Filtrar usuarios existentes
                    # Conexión con el servidor
                        include "../servidor.php";

                        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);      
                    
                    # Consulta
                        $query = "select * from usuario where correo like '$correo'";

                    # Ejecutar consulta
                        $consulta = mysqli_query($conexion,$query) or die ("Fallo en la consulta");

                    # Nº de filas de la consulta
                    $rows = mysqli_num_rows($consulta);

                    if ($rows == 1) {
                        echo "<p class='alertas'>Ya existe un usuario con ese correo</p>";
                    }
                # Si no existe el usuario en la bbdd se registra
                    else {

                        # Consulta
                            $query = "insert into usuario values (null, '$nombre', '$correo', '$clave', '$tipo')";
                            // echo "$query <br>";

                        # Ejecutar consulta
                            $consulta = mysqli_query($conexion,$query) or die ("Fallo en la consulta");

                            if ($consulta) {
                                header("Location: login.php");
                            }
                            else {
                                echo "error";
                            }
                    }
            }
        # Si los campos no son correctos
            else {
                $error = "";
                if (strlen($nombre) <= 4) {
                    $error = $error . "<li class='alertas'>El nombre debe tener como mínimo 5 caracteres</li>\n";
                }
                if (empty($correo)) {
                    $error = $error . "<li class='alertas'>Falta por rellenar el correo o no has introducido uno válido</li>\n";
                }
                if (strlen($clave) < 8) {
                    $error = $error . "<li class='alertas'>La contraseña debe tener un mínimo de 8 caracteres</li>\n";
                }
                if ($tipo == 0) {
                    $error = $error . "<li class='alertas'>Especifica que tipo de cliente quieres ser</li>\n";
                }
                echo $error;
            }

        mysqli_close($conexion);
    }

?>