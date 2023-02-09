<?php
session_start();
//incluimos variables externas
include "../servidor.php";
$correo=$_SESSION['correo'];
//echo $correo;
//conectamos con la base de datos 
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);   
//declaramos consulta
$query = "select * from usuario where correo=$correo;";
echo $query;
$consulta = mysqli_query($conexion,$query) or die ("Fallo en la consulta");
//mostramos resultado de la consulta 
$rows = mysqli_num_rows($consulta);

if ($rows > 0) {

    for ($i = 0; $i < $rows; $i++) {

        $bbdd = mysqli_fetch_array($consulta);

        echo "<div class='pisos'>";
        echo "<form action='comprar.php' method='post'>";
        echo "<img src='" . $bbdd['imagen'] . "' class='value' width='95%'><br>";
        echo "C/<input type='text' value='" . $bbdd['calle'] . "' class='value'> Nº<input type='text' value='" . $bbdd['numero'] . "' class='value'><br>";
        echo "Piso: <input type='text' value='" . $bbdd['piso'] . " " . $bbdd['puerta'] . "' class='value'><br>";
        echo "CP: <input type='number' value='" . $bbdd['cp'] . "' class='value'><br>";
        echo "Dimensiones: <input type='text' value='" . $bbdd['metros'] . " m2' class='value'><br>";
        echo "Localidad: <input type='text' value='" . $bbdd['zona'] . "' class='value'><br>";
        echo "Precio: <input type='float' name='precio' value='" . $bbdd['precio'] . "' class='value'>€<br>";
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

