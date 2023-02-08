<html>
   <head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="../../codigoCSS.css">
   </head>
</html>
<?php
//conectamos con el servidor
$conexion = mysqli_connect ("localhost", "root", "rootroot")  or die ("No se puede conectar con el servidor");
//conectamos con la base de datos 
mysqli_select_db ($conexion,"inmobiliaria") or die ("No se puede seleccionar la base de datos");
//declaramos la consulta 
$query = "select * from pisos";
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

   for ($i=0; $i<$nfilas; $i++)
   {
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
   }

   echo  ("</TABLE>\n");
   echo "<a href=pisos.html> voler </a>";
} 
else
   echo  ("No hay noticias disponibles");
//cerramos conexion 
mysqli_close($conexion)

?>
