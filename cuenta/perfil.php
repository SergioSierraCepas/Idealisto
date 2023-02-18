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
        <a href="../index.php"><img src="../imagenes_index/logo.png" alt="" class="home"></a>
        <h2><u>Perfil</u></h2>
        <form name="perfil" action="perfil.php" method="post">
            <input type='text' class="input" name="nombre" value='<?php echo $nombre ?>'><br>
            Cambiar contrseña <input type="checkbox" id="checkbox" onclick="pass()"><br>
            <span id="span2"></span><input type='password' class="claves" name="clave" id="clave" placeholder="Contraseña actual"><span id="span"></span>
            <input type='password' class="claves" name="clave2" id="clave2" placeholder="Contraseña nueva">
            <p class="input">Tipo de usuario:
                <select name="tipo" id="">
                    <option value='<?php echo $tipo ?>'><?php echo $tipo ?></option>
                    <?php
                        # Posibilidad de cambiar de tipo de usuario
                            if ($tipo == 'vendedor') {
                                echo "<option value='comprador'>comprador</option>";
                            }
                            elseif ($tipo == 'comprador') {
                                echo "<option value='vendedor'>vendedor</option>";
                            }
                    ?>
                </select>
            </p>
            <div>
                <input type="submit" class="submit" name="guardar" value="Guardar">
                <input type="submit" class="submit" name="cerrar" value="Cerrar sesión">
            </div>
        </form>
    </body>
</html>
<?php

    if (isset($_REQUEST['guardar'])) {

        # Declarar variables con control de etiqueras y espacios
            $nombre = trim(strip_tags($_REQUEST['nombre']));
            $clave = trim(strip_tags($_REQUEST['clave']));
            $clave2 = trim(strip_tags($_REQUEST['clave2']));
            $tipo = trim(strip_tags($_REQUEST['tipo']));
        
        if (strlen($nombre) > 4) {

            if ($tipo == 'vendedor') {
                $tipo = 'vendedor';
            }
            elseif ($tipo == 'comprador') {
                $tipo = 'comprador';
            }

            # Conexión con el servidor
                include "../servidor.php";

                $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);      
            
            # Si se quiere cambiar la contraseña
                if (strlen($clave) > 8 && strlen($clave2) > 8) {
                    
                    $clave = md5($clave);

                    # Consulta
                        $query = "select * from usuario where correo like '" . $_SESSION['correo'] . "' and clave = '$clave'";
                        // echo "$query <br>";

                    # Ejecutar consulta
                        $consulta = mysqli_query($conexion,$query);

                        $bbdd = mysqli_fetch_array($consulta);

                        # Si la contraseña es correcta cambiarla
                            if ($bbdd['clave'] == $clave) {

                                $clave2 = md5($clave2);
                                    
                                # Consulta
                                $query = "update usuario set nombres = '$nombre', clave = '$clave2', tipo_usuario = '$tipo' where correo like '" . $_SESSION['correo'] ."'";
                                // echo "$query <br>";
                            }
                }
                elseif (strlen($clave) > 1 && strlen($clave) < 8 && strlen($clave2) > 1 && strlen($clave2) < 8) {
                    echo "<p class='alertas'>La contraseña debe tener un mínimo de 8 caracteres</p>";
                }
            # Sino actualizar todos los datos menos la contraseña
                else {
                    # Consulta
                    $query = "update usuario set nombres = '$nombre', tipo_usuario = '$tipo' where correo like '" . $_SESSION['correo'] ."'";
                    echo "$query <br>";
                }

            # Ejecutar consulta
                $consulta = mysqli_query($conexion,$query);

                if ($consulta) {
                    header("Location: ../index.php");
                }
                else {
                    echo "error";
                }
        }
        else {
            echo "<p class='alertas'>Faltan cambos por rellenar</p>";
        }
    }
    if (isset($_REQUEST['cerrar'])) {
        session_destroy();
        header("Location: login.php");
    }
    mysqli_close($conexion);

?>