<html>
    <head>
    <head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="../../codigoCSS.css">
    </head>
    </head>
    <body>
        <form action="alta.php" method="get">
        <input class='input'  type="text" name="nombre" placeholder="Nombre"><br>
        <input class='input' type="email"  name="correo" placeholder="correo"><br>
        <input type="password" name="pass" placeholder="password"><br>
        <select name="tipo">
            <option></option>
            <option  value="administrador">Administrador</option>
            <option  value="comprador">Comprador</option>
            <option  value="vendedor ">Vendedor</option>
        </select><br>
        <input class='input' type="submit" name="enviar" value="enviar" onClick= comprobar>
        <a id='volver' href='usuarios.html'>Volver</a>
        </form>
        
    </body>
<html>
<?php
if (isset($_REQUEST['enviar'])){
    //Variables 
    $name=$_REQUEST['nombre'];
    $email=$_REQUEST['correo'];
    $pass=$_REQUEST['pass'];
    $tipo=$_REQUEST['tipo'];
    //Errores
    $errores="";
    if ( strip_tags (trim($name==""))){
        $errores= $errores."<li>Falta el nombre\n";
    }
    if ( strip_tags(trim($email)=="")){
        $errores=$errores."<li>Falta el correo\n";
    }
    if ( strip_tags(trim($pass)=="")){
        $errores=$errores."<li>Falta la password \n";
    }
    if ( strip_tags(trim($tipo)=="")){
        $errores=$erroes."<li>Falta el tipo de usuario\n";
    }
    if ($errores != ""){
        echo $errores;
    }
    else {
        $pass=md5($pass);
        //incluimos variables externas 
        include "../servidor.php";
        //conexion con el servidor
        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        //crecion de consulta 
         $consulta="insert into usuario (nombres,correo,clave,tipo_usuario) values ('$name','$email','$pass','$tipo')";
        //resultado de consulta 
        if (mysqli_query($conexion,$consulta)){
            echo "oferta dada de alta";
            echo "<br>";
            
        }
        else {
            echo "error en la subida de la noticia";
            echo "<br>";
           
        }
        //cerramos conexion 
        mysqli_close($conexion);
    }
}
?>