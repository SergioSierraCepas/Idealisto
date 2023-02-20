<html>
    <head>
        <title>Práctica PHP+MySQL+Seguridad</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../codigoCSS.css">
    </head>
    <body>
        <a href="../index.php"><img src="../imagenes_index/logo.png" alt="" class="home"></a>
<?php

    session_start();

        # Conexión con el servidor
            include "../../servidor.php";

            $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        # Consulta
            $query = "select * from pisos";

        # Ejecutar consulta
            $consulta = mysqli_query($conexion,$query);

        # Nº de filas de la consulta
        $rows = mysqli_num_rows($consulta);

        if ($rows > 0) {

            for ($i = 0; $i < $rows; $i++) {
        
                $bbdd = mysqli_fetch_array($consulta);
        
                echo "<div class='pisos'>";
                echo "<form action='comprar.php' method='post'>";
                echo "<img src='" . $bbdd['imagen'] . "' class='value'><br><br>";
                echo "<p>C/" . $bbdd['calle'] . " Nº " . $bbdd['numero'] . "</p>";
                echo "<p>Piso: " . $bbdd['piso'] . "º " . $bbdd['puerta'] . "</p>";
                echo "<p>CP: " . $bbdd['cp'] . "</p>";
                echo "<p>Dimensiones: " . $bbdd['metros'] . " m2</p>";
                echo "<p>Localidad: " . $bbdd['zona'] . "</p>";
                echo "<p>Precio: " . $bbdd['precio'] . "€</p>";
                echo "<input type='hidden' name='precio' value=" . $bbdd['precio'] . ">";
                echo "<input type='hidden' name='id_piso' value=" . $bbdd['Codigo_piso'] . ">";
                echo "<input type='hidden' name='id_user' value=" . $bbdd['usuario_id'] . ">";
                echo "<input type='submit' class='submit' name='comprar' value='Comprar'>";
                echo "</form>";
                echo "</div>";
            }
        }
        else {
            echo "<p style='font-size: 120%; background-color: white; padding: .5%;'>Actualmente no hay contenido, inténtelo más tarde.</p>";
        }

        if (isset($_REQUEST['comprar'])) {
            
            # Comprobar si ha iniciado sesión
                if ($_SESSION['correo'] == null) {
                    header("Location: ../../cuenta/login.php");
                }
                else {
                    
                    $id_piso = $_REQUEST['id_piso'];
                    $id_user = $_REQUEST['id_user'];
                    $precio = $_REQUEST['precio'];

                    # Conexión con el servidor
                        include "../../servidor.php";

                        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                    # Consulta
                        $query = "insert into comprados values ($id_user, $id_piso, $precio)";
                        // echo $query;

                    # Ejecutar consulta
                        if (mysqli_query($conexion,$query)) {
                            
                            echo "<h2>Piso comprado</h2>";

                            # Consulta
                                $query = "delete from pisos where Codigo_piso = '$id_piso'";
                                // echo $query;

                            # Ejecutar consulta
                                $consulta = mysqli_query($conexion,$query);
                        }
                        else {
                            echo "<p class='alertas'>No ha sido posible</p>";
                        }
                }
            mysqli_close($conexion);
        }
?>

    </body>
</html>