<html>
    <head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="../../codigoCSS.css">
    </head>
    <body>
        <form action="baja.php" method="POST" enctype="multipart/form-data">
            Calle:<input class='input' type="text" name="calle"><br>
            Numero:<input class='input' type="text" name="numero"><br>
            Piso:<input class='input' type="number" name="piso"><br>
            Puerta:<input class='input' type="text" name="puerta"><br>
            Usuario <input class='input' type="text" name="usuario"><br>
            <input class='input' type="submit" value="enviar" name="enviar">
            <a href="pisos.html">volver </a>
        </form>
    </body>
</html>

<?php
if (isset($_REQUEST['enviar'])){
    //declaramos variables 
    $calle=strip_tags(trim($_REQUEST['calle']));
    $numero=strip_tags(trim($_REQUEST['numero']));
    $piso=strip_tags(trim($_REQUEST['piso']));
    $puerta=strip_tags(trim($_REQUEST['puerta']));
    //errores 
    $errores = "";
    if (is_numeric($calle) || $calle == "") {
        $errores = $errores . "<li>El campo 'Calle' no puede ser un número.\n";
    }
    if (!is_numeric($numero) || $numero == "") {
        $errores = $errores . "<li>El campo 'Número' debe ser numérico." . $numero . "\n";
    }
    if (!is_numeric($piso) || $piso == "") {
        $errores = $errores . "<li>El campo 'Piso' debe ser numérico." . $piso . "\n";
    }
    if ($puerta == "" ){
        $errores = $errores . "   <LI>Se requiere la puerta de la vivienda\n";
    }
    if ($errores == "" ){
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
           
        
        }
        
        else {
        
            echo "<h1>fallo en la eliminacion <h1>";
            echo "<br>";
           
        
        }
        //cerrar conexion 
        mysqli_close($conexion);
    }
    else {
        echo $errores;
    }
}


?>
