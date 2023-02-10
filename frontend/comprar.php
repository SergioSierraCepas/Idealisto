<html>
    <head>
        <title>Práctica PHP+MySQL+Seguridad</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../codigoCSS.css">
    </head>
    <body>
        
<?php

    session_start();

        # Conexión con el servidor
            include "../servidor.php";

            $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        # Consulta
            $query = "select * from pisos";

        # Ejecutar consulta
            $consulta = mysqli_query($conexion,$query) or die ("Fallo en la consulta");

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
                echo "<input type='submit' class='submit' name='añadir' value='Comprar'>";
                echo "</form>";
                echo "</div>";
            }
        }
        else {
            echo "<p> Actualmente no hay contenido, inténtelo más tarde.</p>";
        }

        if (isset($_REQUEST['añadir'])) {
            
            if ($_SESSION['correo'] == null) {
                header("Location: login.php");
            }
            else {

                #echo "tu usuario es " . $_SESSION['correo'];
                
                $id_piso = $_REQUEST['id_piso'];
                $id_user = $_REQUEST['id_user'];
                $precio = $_REQUEST['precio'];

                # Conexión con el servidor
                   

                    $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                # Consulta
                    $query = "insert into comprados values ($id_user, $id_piso, $precio)";
                    # echo $query;

                # Ejecutar consulta
                    if (mysqli_query($conexion,$query)) {
                        
                        echo "Piso comprado";

                        # Conexión con el servidor
                        

                            $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                        # Consulta
                            $query = "delete from pisos where Codigo_piso = '$id_piso'";
                            # echo $query;

                        # Ejecutar consulta
                            $consulta = mysqli_query($conexion,$query);
                    }
                    else {
                        echo "No ha sido posible";
                    }
            }
            mysqli_close($conexion);
        }
?>

    </body>
</html>