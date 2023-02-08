<html>
    <head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="codigoCSS.css">
    </head>
    <body>
        <form action="buscar.php" method="get">
            <input class='input' type="text" name="name" placeholder="nombre">
            <input class='input' type='email' name="correo" placeholder="correo">
            <select name="tipo">
                <option>.......</option>
                <option  value="administrador">Administrador</option>
                <option  value="comprador">Comprador</option>
                <option  value="vendedor ">Vendedor</option>
            <input class='input' type="submit" name="buscar" value="buscar">
        </select>

        <form>
    </body>

</html>
<?php
if (isset($_REQUEST['buscar'])){
    //variables 
    $name=$_REQUEST['name'];
    $email=$_REQUEST['correo'];
    $tipo=$_REQUEST['tipo'];
    //errores
    $errores="";
    if (strip_tags(trim($name==""))){
        $errores= $errores."<li>Falta el nombre\n";
    }
    if (strip_tags(trim($email)=="")){
        $errores=$errores."<li>Falta el correo\n";
    }
    if (Strip_tags(trim($tipo)=="")){
        $errores=$erroes."<li>Falta el tipo de usuario\n";
    }
    
    if ($errores!= ""){
        echo $errores ;
    }
    else {
        //incluimos variables externas 
        include "../servidor.php";
        //conexion con el servidor 
        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        //declaracion de consulta 
        
        $query="select * from usuario where nombres='$name' and correo='$email' and tipo_usuario='$tipo'";
        //echo $query;
        //aplicamos consulta 
        $consulta = mysqli_query ($conexion,$query) or die ("fallo de la consulta");
        
        
        //mostramos resultado 
        $nfilas=mysqli_num_rows($consulta);
        if ($nfilas > 0)
        {
           echo  ("<TABLE>\n");
           echo  ("<TR>\n");
           echo  ("<TH>nombre</TH>\n");
           echo  ("<TH>correo</TH>\n");
           echo  ("<TH>Clave</TH>\n");
           
        
          
           echo ("</TR>\n");
        
           for ($i=0; $i<$nfilas; $i++)
           {
              $resultado = mysqli_fetch_array ($consulta);
              echo  ("<TR>\n");
              echo  ("<TD>" . $resultado['nombres'] . "</TD>\n");
              echo  ("<TD>" . $resultado['correo'] . "</TD>\n");
              echo  ("<TD>" . $resultado['tipo_usuario'] . "</TD>\n");
             
        
              
              echo ("</TR>\n");
           }
        
           echo "</TABLE>\n";
           echo "<br>";
           echo "<a href='usuarios.html'>Volver</a>";
           
        } 
        else{
            echo ("No hay usuarios disponibles");
            echo "<a href='usuarios.html'>Volver</a>";
        }
        //cerramos conexion 
        
        mysqli_close($conexion);
    }
}
?>

    





