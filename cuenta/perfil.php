<?php
session_start();

    # Conexión con el servidor
        include "../servidor.php";

        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);      

    # Consulta
        $query = "select * from usuario where correo like '" . $_SESSION['correo'] . "'";
        // echo $query;

    # Ejecutar consulta
        $consulta = mysqli_query($conexion,$query) or die ("Fallo en la consulta");

    # Sacar los valores de la bbdd
        $bbdd = mysqli_fetch_array($consulta);

        $nombre = $bbdd['nombres'];
        $clave = $bbdd['clave'];
        $tipo = $bbdd['tipo_usuario'];

?>
<html>
    <head>
        <title>Práctica PHP+MySQL+Seguridad</title>
        <link rel="stylesheet" href="../codigoCSS.css">
        <script src="../js.js"></script>
    </head>
    <body>
        <h2><u>Perfil</u></h2>
        <form action="perfil.php" method="post">
            <input type='text' class="input" name="nombre" value='<?php echo $nombre ?>'><br>
            Cambiar contrseña <input type="checkbox" onclick="pass()"><br><br>
            <input type='text' class="claves" name="clave2" id="clave2" placeholder="Contraseña nueva"><span id="span"></span>
            <input type='text' class="claves" name="clave" id="clave" placeholder="Contraseña actual">
            <p class="input">Tipo de usuario:
                <select name="tipo" id="">
                    <option value='<?php echo $tipo ?>'><?php echo $tipo ?></option>
                    <?php
                        if ($tipo == 'vendedor') {
                            echo "<option value='comprador'>comprador</option>";
                            echo "<option value='administrador'>administrador</option>";
                        }
                        elseif ($tipo == 'comprador') {
                            echo "<option value='vendedor'>vendedor</option>";
                            echo "<option value='administrador'>administrador</option>";
                        }
                        elseif ($tipo == 'administrador') {
                            echo "<option value='vendedor'>vendedor</option>";
                            echo "<option value='comprador'>comprador</option>";
                        }
                    ?>
                </select>
            </p>
            <div>
                <input type="submit" class="submit" name="guardar" value="Guardar">
                <button class="submit"><a href="./login.php" style="text-decoration: none; color: black;">Cancelar</a></button>
                <input type="submit" class="submit" name="cerrar" value="Cerrar sesión">
            </div>
        </form>
    </body>
</html>
<?php

    if (isset($_REQUEST['guardar'])) {

        # Variables
            $nombre = trim(strip_tags($_REQUEST['nombre']));
            $clave = trim(strip_tags($_REQUEST['clave']));
            $tipo = trim(strip_tags($_REQUEST['tipo']));
        
        if (!empty($nombre)) {

            if ($tipo == 'vendedor') {
                $tipo = 'vendedor';
            }
            elseif ($tipo == 'comprador') {
                $tipo = 'comprador';
            }
            elseif ($tipo == 'administrador') {
                $tipo = 'administrador';
            }

            # Conexión con el servidor
                include "../servidor.php";

                $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);      

            if (!empty($clave)) {
                
                $clave = md5($clave);

                # Consulta
                $query = "update usuario set nombres = '$nombre', clave = '$clave', tipo_usuario = '$tipo' where correo like '" . $_SESSION['correo'] ."'";
                echo "$query <br>";
            }
            else {
                # Consulta
                $query = "update usuario set nombres = '$nombre', tipo_usuario = '$tipo' where correo like '" . $_SESSION['correo'] ."'";
                echo "$query <br>";
            }


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
    if (isset($_REQUEST['cerrar'])) {
        session_destroy();
        header("Location: login.php");
    }
    mysqli_close($conexion);

?>