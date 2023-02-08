<html>
    <head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="../../codigoCSS.css">
    </head>
    <body>
    <form action="borrar.php" method="get">
        <input class='input' type="text" name="nombre" placeholder="Nombre">
        <input class='input' type="email"  name="correo" placeholder="correo">
        <input class='input' type="password" name="pass" placeholder="password">
        <select name="tipo">
            <option>.......</option>
            <option  value="administrador">Administrador</option>
            <option  value="comprador">Comprador</option>
            <option  value="vendedor ">Vendedor</option>
        </select>
        <input  class='input' type="submit" name="enviar" value="enviar">
        </form>
    <body>
   </html> 
   <?php
   if (isset($_REQUEST['enviar'])){
        //variables 
        $name=$_REQUEST['nombre'];
        $email=$_REQUEST['correo'];
        $pass=$_REQUEST['pass'];
        $tipo=$_REQUEST['tipo'];
        //errores
        $errores="";
        if (strip_tags(trim($name==""))){
            $errores= $errores."<li>Falta el nombre\n";
        }
        if (strip_tags(trim($email)=="")){
            $errores=$errores."<li>Falta el correo\n";
        }
        if (strip_tags(trim($pass)=="")){
            $errores=$errores."<li>Falta la password \n";
        }
    
        if (strip_tags(trim($tipo)=="")){
            $errores=$erroes."<li>Falta el tipo de usuario\n";
        }

        
        if ($errores != ""){
            echo $errores;
        }
        else {
            //conexion con el servidor 
            include "../servidor.php";
            $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
            //crecion de consulta 
            $consulta="delete  from usuario where nombres='$name' and correo='$email' and clave='$pass' and tipo_usuario='$tipo'";
            //resultado de consulta 

            if(mysqli_query($conexion,$consulta)){
                echo "oferta dada de baja";
                echo "<br>";
                echo "<a href='usuarios.html'>Volver</a>";
            }
            else {
                echo "error en la eliminacion de la noticia";
                echo "<br>";
                echo "<a href='usuarios.html'>Volver</a>";
            }
            //cerramos conexion 
            mysqli_close($conexion);
        }
    }
?>