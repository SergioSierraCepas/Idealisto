<html>
    <head>
    </head>
    <body>
        <form action="alta.php" method="get">
        <input class='input'  type="text" name="nombre" placeholder="Nombre">
        <input class='input' type="email"  name="correo" placeholder="correo">
        <input type="password" name="pass" placeholder="password">
        <select name="tipo">
            <option>.......</option>
            <option  value="administrador">Administrador</option>
            <option  value="comprador">Comprador</option>
            <option  value="vendedor ">Vendedor</option>
        </select>
        <input class='input' type="submit" name="enviar" value="enviar" onClick= comprobar>
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
            echo "<a href='usuarios.html'>Volver</a>";
        }
        else {
            echo "error en la subida de la noticia";
            echo "<br>";
            echo "<a href='usuarios.html'>Volver</a>";
        }
        //cerramos conexion 
        mysqli_close($conexion);
    }
}
?>