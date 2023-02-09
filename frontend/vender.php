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
        <?php

            if ($_SESSION['correo'] == null) {
                header("Location: login.php");
            }
            else {

        ?>
        <h2>Dar de alta un piso</h2>
        <div>
            <form action="vender.php" method="post" enctype="multipart/form-data">
                <input type="text" name="calle" placeholder="Calle" required><br>
                <input type="number" name="numero" placeholder="Número" required><br>
                <input type="number" name="piso" placeholder="Piso" required><br>
                <input type="text" name="puerta" placeholder="Puerta" required><br>
                <input type="number" name="cp" placeholder="CP" required><br>
                <input type="number" name="metros" placeholder="Metros2" required><br>
                <input type="text" name="zona" placeholder="Localidad" required><br>
                <input type="float" name="precio" placeholder="Precio" required><br>
                <input type="hidden" name="tamaño" value="100000">
                <input type="file" name="imagen" required><br>
                <input type="submit" class="submit" name="añadir" value="Dar de Alta">
            </form>
        </div>
        <?php
            }

            if (isset($_REQUEST['añadir'])) {

                # Variables

                    $calle = trim(strip_tags($_REQUEST['calle']));
                    $numero = trim(strip_tags($_REQUEST['numero']));
                    $piso = trim(strip_tags($_REQUEST['piso']));
                    $puerta = trim(strip_tags($_REQUEST['puerta']));
                    $cp = trim(strip_tags($_REQUEST['cp']));
                    $metros = trim(strip_tags($_REQUEST['metros']));
                    $zona = trim(strip_tags($_REQUEST['zona']));
                    $precio = trim(strip_tags($_REQUEST['precio']));

                # Subir foto al servidor

                    $copiaFichero = false;

                # Copia de fichero en directorio tmp
                # Para evitar la unicidad de nombre se añade una marca de tiempo

                    if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                        $nombreDirectorio = "../pisos/";
                        $nombreFichero = $_FILES['imagen']['name'];
                        $copiaFichero = true;

                        # Si ya existe un archivo con ese nombre se sobreescribe

                            $ruta = $nombreDirectorio . $nombreFichero;
                            if (is_file($ruta)) {
                                $id = time();
                                $nombreFichero = $id . "-" . $nombreFichero;
                                echo "--" . $nombreFichero . "--";
                            }
                    }
                    
                # Si supera el límite de tamaño establecido

                    elseif ($_FILES['imagen']['error'] == UPLOAD_ERR_FORM_SIZE) {
                        $maxsize = $_REQUEST['tamaño'];
                        $errores = $errores . "<li>El tamaño del fichero supera el límite predeterminado";
                    }

                # No se ha introducido ningún fichero

                    elseif ($_FILES['imagen']['name'] == "") {
                        $nombreFichero = '';
                        $errores = $errores . "<li>Falta insertar una imagen del piso";
                    }

                # El fichero no se ha podido subir al servidor

                    else {
                        $errores = $errores . "<li>No se ha podido subir el fichero";
                    }

                # Errores

                    if (is_numeric($calle) || $calle == "") {
                        $errores = $errores . "<li>El campo 'Calle' no puede ser un número.\n";
                    }
                    if (!is_numeric($numero) || $numero == "") {
                        $errores = $errores . "<li>El campo 'Número' debe ser numérico." . $numero . "\n";
                    }
                    if (!is_numeric($piso) || $piso == "") {
                        $errores = $errores . "<li>El campo 'Piso' debe ser numérico." . $piso . "\n";
                    }
                    if ($puerta == "") {
                        $errores = $errores . "<li>El campo 'Puerta' está vacío.\n";
                    }
                    if (!is_numeric($cp) || $cp == "") {
                        $errores = $errores . "   <li>El campo 'Código postal' debe ser numérico." . $cp . "\n";
                    }
                    if (!is_numeric($metros) || $metros == "") {
                        $errores = $errores . "<li>El campo 'Metros2' debe ser numérico." . $metros . "\n";
                    }
                    if (is_numeric($zona) || $zona == "") {
                        $errores = $errores . "<li>El campo 'Zona' está vacío.\n";
                    }
                    if (!is_numeric($precio) || $precio == "") {
                        $errores = $errores . "<li>El campo 'Precio' debe ser numérico." . $precio . "\n";
                    }

                    if ($errores != null) {
                        echo $errores;
                    }
                    else {
                        
                        # Comprobar que no existe este piso en la bbdd
                        # Conexión con el servidor
                            include "../servidor.php";

                            $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                        
                        # Consulta
                            $query = "select * from pisos where calle like '$calle' and numero = '$numero' and piso = '$piso' and puerta like '$puerta' and cp = '$cp'";
                            //echo $query."<br>";
                        # Ejecutar consulta
                            $consulta = mysqli_query($conexion,$query);

                        # Nº de filas de la consulta
                        $rows = mysqli_num_rows($consulta);

                        # Si ya existe el piso
                            if ($rows == 1) {
                                echo "<p style='color: red;'>Este piso ya está dado de alta</p>";
                            }
                        # Si no existe lo inserta
                            else {
                                
                                if ($copiaFichero) {
                                    move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreDirectorio . $nombreFichero);
                                }
                                
                                # Sacar el id del usuario conectado
                                    $query = "select usuario_id from usuario where correo like '" . $_SESSION['correo'] . "'";
                                    //echo $query ."<br>";
                                    # Ejecutar consulta
                                        $consulta = mysqli_query($conexion,$query);
                                        $bbdd = mysqli_fetch_array($consulta);
                                        $user_id = $bbdd['usuario_id'];
                                # Consulta
                                    $query = "insert into pisos values ( null, '$calle', $numero, $piso, '$puerta', $cp, $metros, '$zona', $precio, '$ruta', $user_id)";
                                    //echo $query ."<br>";

                                # Ejecutar consulta
                                    $consulta = mysqli_query($conexion,$query);

                                    if ($consulta) {
                                        echo "<div>Piso dado de alta</div>";
                                    }
                                    else {
                                        echo "error";
                                    }

                        }
                }
                mysqli_close($conexion);
            }
        ?>
    </body>
</html>