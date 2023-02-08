<html>
   <head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="codigoCSS.css">
   </head>
</html>
<?php
//incluimos variables externas 
include "../servidor.php";
//conexion con el servidor 
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$query = "select * from usuario";
$consulta = mysqli_query ($conexion,$query) or die ("Fallo en la consulta");
//resultado de consulta 
$nfilas = mysqli_num_rows ($consulta);
if ($nfilas > 0)
{
   echo ("<TABLE>\n");
   echo ("<TR>\n");
   echo ("<TH>nombre</TH>\n");
   echo ("<TH>correo</TH>\n");
   echo ("<TH>tipo</TH>\n");
   echo ("</TR>\n");

   for ($i=0; $i<$nfilas; $i++)
   {
      $resultado = mysqli_fetch_array ($consulta);
      echo ("<TR>\n");
      echo ("<TD>" . $resultado['nombres'] . "</TD>\n");
      echo ("<TD>" . $resultado['correo'] . "</TD>\n");
      echo ("<TD>" . $resultado['tipo_usuario'] . "</TD>\n");
      echo ("</TR>\n");
   }

   echo ("</TABLE>\n");
   echo "<a href=usuarios.html> voler </a>";
} 
else
   echo("No hay usuarios disponibles");
//cerramos conexion 
mysqli_close($conexion)
?>