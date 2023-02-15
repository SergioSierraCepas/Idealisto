<html>
    <head>
        <title>Práctica PHP+MySQL+Seguridad</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../codigoCSS.css">
    </head>
    <body>
    </body>
<html>
<?php
session_start();
if ($_SESSION['correo'] == null) {
    header("Location: ../cuenta/login.php");
}
else {
    //incluimos variables externas
        include "../servidor.php";
        $correo=$_SESSION['correo'];
    //echo $correo;
    //conectamos con la base de datos 
        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);   
    //declaramos consulta para sacar id 
        $query1 = "select usuario_id from usuario where correo like '" . $_SESSION['correo'] . "'";
    //echo $query1;
        $consulta1= mysqli_query($conexion,$query1) or die ("no existe ningun usuario con su correo ");
            $bbdd = mysqli_fetch_array($consulta1);
            $user_id = $bbdd['usuario_id'];
    //echo "--$user_id----";
    //segunda consulta sacamos resulta dos 
        $query2= " select * from pisos where usuario_id like '$user_id'";
        $consulta2 = mysqli_query($conexion,$query2) or die ("Fallo en la consulta");
    //mostramos resultado de la consulta 
        $rows = mysqli_num_rows($consulta2);

    if ($rows > 0) {

        for ($i = 0; $i < $rows; $i++) {

            $bbdd = mysqli_fetch_array($consulta2);
        
            echo "<div class='pisos'>";
            echo "<form action='comprar.php' method='post'>";
            echo "<img src='" . $bbdd['imagen'] . "' class='value'><br><br>";
            echo "<p>C/" . $bbdd['calle'] . " Nº " . $bbdd['numero'] . "</p>";
            echo "<p>Piso: " . $bbdd['piso'] . "º " . $bbdd['puerta'] . "</p>";
            echo "<p>CP: " . $bbdd['cp'] . "</p>";
            echo "<p>Dimensiones: " . $bbdd['metros'] . " m2</p>";
            echo "<p>Localidad: " . $bbdd['zona'] . "</p>";
            echo "<p>Precio: " . $bbdd['precio'] . "€</p>";
            echo "<input type='submit' class='submit' name='añadir' value='Comprar'>";
            echo "</form>";
            echo "</div>";
        }
    
    }
    else {
        echo "<p> Actualmente no hay contenido, inténtelo más tarde.</p>";
    }
    mysqli_close($conexion);
}
?>
