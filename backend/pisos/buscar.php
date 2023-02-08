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
        </form>
    </body>
</html>
<?php
if (isset($_REQUEST['buscar'])){
    //declaracion de variables 
    $calle=$_REQUEST['calle'];
    $numero=$_REQUEST['numero'];
    $piso=$_REQUEST['piso'];
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
    //coenexion con el servidor 
    $conexion = mysqli_connect ("localhost", "root", "rootroot")  or die ("No se puede conectar con el servidor");
    //coenexion con la base de datos 
    mysqli_select_db ($conexion,"inmobiliaria") or die ("No se puede seleccionar la base de datos");
    //crecion de consulta 
    $query =("select * from pisos where calle='$calle' and piso='$piso' and  numero='$numero' and  puerta='$puerta'");
    //echo $query;
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
      echo "<a href=pisos.html> voler </a>";
   

    }
}

?>
