<html>
    <head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="../../codigoCSS.css">
    </head>
    <body>
        <form action="alta.php" method="POST" enctype="multipart/form-data">
            Calle:<input class='input' type="text" name="calle"><br>
            Numero:<input class='input' type="text" name="numero"><br>
            Piso:<input class='input' type="number" name="piso"><br>
            Puerta:<input class='input' type="text" name="puerta"><br>
            Usuario <input class='input' type="text" name="usuario"><br>
            <input class='input' type="submit" value="enviar" name="enviar">
        </form>
    </body>
</html>

<?php
if (isset($_REQUEST['enviar'])){
    //declaramos variables 
    $calle=$_REQUEST['calle'];
    $piso=$_REQUEST['piso'];
    $numero=$_REQUEST['numero'];
    $puerta=$_REQUEST['puerta'];
    //errores 
    $errores = "";
    if (strip_tags((trim($calle) == ""))){
        $errores = $errores . "   <LI>Se requiere la calle de la vivienda\n";
    }
    if (!is_numeric((trim($numero) == ""))){
        $errores = $errores . "   <LI>Se requiere un numero de la vivienda\n";
    }
    if (!is_numeric(trim($piso) == "")){
        $errores = $errores . "   <LI>Se requiere un piso de la vivienda de la vivienda\n";
    }
    if (strip_tags(trim($puerta) == "")){
        $errores = $errores . "   <LI>Se requiere un usuario de la vivienda\n";
    }
    else {
        //conexion con el servidor 
        $conexion= mysqli_connect("localhost","root","rootroot") or die ("no se puede conectar con el servidor");
        //conexion con la base de datos 
        mysqli_select_db($conexion,"inmobiliaria") or die ("no se puede seleccionar la base de datos");

        // consulta 
        $query="delete  from pisos where calle='$calle' and piso='$piso' and numero='$numero' and  puerta='$puerta';";
        //echo "$query";

        //resultado de consulta 
        if (mysqli_query($conexion,$query)) {

            echo "<h1>oferta eliminada </h1>";
            echo "<br>";
            echo "<a href=pisos.html> voler </a>";
        
        }
        
        else {
        
            echo "<h1>fallo en la eliminacion <h1>";
            echo "<br>";
            echo "<a href=pisos.html> voler </a>";
        
        }
        //cerrar conexion 
        mysqli_close($conexion);
    }
}


?>
