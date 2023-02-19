<html>
    <head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="../../codigoCSS.css">
    </head>
    <body>
        <form action='buscar.php'>
            Calle:<input class='input'  type="text" name="calle"><br>
            Numero:<input class='input'  type="text" name="numero"><br>
            Piso:<input class='input' type="number" name="piso"><br>
            puerta:<input class='input' type="text" name="puerta"><br>
            <input class='input'  type="submit" value="buscar" name='buscar'>
            <a href="pisos.html">volver </a>
        </form>
    </body>
</html>
<?php
if (isset($_REQUEST['buscar'])){
    //declaracion de variables 
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
    if ($errores == ""){
        //coenexion con el servidor 
            $conexion = mysqli_connect ("localhost", "root", "rootroot")  or die ("No se puede conectar con el servidor");
        //coenexion con la base de datos 
            mysqli_select_db ($conexion,"inmobiliaria") or die ("No se puede seleccionar la base de datos");
        //crecion de consulta 
            $query =("select * from pisos where calle='$calle' and piso='$piso' and  numero='$numero' and  puerta='$puerta'");
            $consulta = mysqli_query ($conexion,$query) or die ("Fallo en la consulta");

    //mostrar resultados 
    $nfilas = mysqli_num_rows ($consulta);
    if ($nfilas > 0)
    {
        echo  ("<TABLE>\n");
        echo  ("<TR>\n");
        echo  ("<TH>calle</TH>\n");
        echo  ("<TH>numero</TH>\n");
        echo  ("<TH>piso</TH>\n");
        echo  ("<TH>puerta</TH>\n");
        echo  ("<TH>zona</TH>\n");
        echo  ("<TH>precio</TH>\n");
        echo  ("<TH>imagen</TH>\n");

   

  
        echo  ("</TR>\n");
      $resultado = mysqli_fetch_array ($consulta);
      echo  ("<TR>\n");
      echo  ("<TD>" . $resultado['calle'] . "</TD>\n");
      echo  ("<TD>" . $resultado['numero'] . "</TD>\n");
      echo  ("<TD>" . $resultado['piso'] . "</TD>\n");
      echo  ("<TD>" . $resultado['puerta'] . "</TD>\n");
      echo  ("<TD>" . $resultado['zona'] . "</TD>\n");
      echo  ("<TD>" . $resultado['precio'] . "</TD>\n");
      echo ("<TD> <img src='".$resultado['imagen']."' width='100px'></TD>\n");

      
      echo  ("</TR>\n");
      echo "<br> <a href=pisos.html> volver </a>";
   

    }
    }
    else {
        echo $errores;
    }
}

?>
