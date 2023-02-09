<html>
    <head>
        <title>Práctica PHP+MySQL+Seguridad</title>
        <link rel="stylesheet" href="../codigoCSS.css">
    </head>
    <body>
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

        # Variables
            $nombre = trim(strip_tags($_REQUEST['nombre']));
            $correo = trim(strip_tags($_REQUEST['correo']));
            $clave = trim(strip_tags($_REQUEST['clave']));
            $tipo = trim(strip_tags($_REQUEST['tipo']));

        if (!empty($nombre) && !empty($correo) && !empty($clave) && ($tipo == 1 || $tipo == 2)) {
            
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
                echo "<p style='color: red;'>Ya existe un usuario con ese correo</p>";
            }
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
        else {
            echo "<p style='color: red;'>Faltan campos por rellenar</p>";
        }
    }

?>