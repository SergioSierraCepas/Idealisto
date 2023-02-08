<html>
    <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../codigoCSS.css">
    </head>
    <body>
        <form action="modificar.php" method="get">
        <input class='input' type="text" name="nombre" placeholder="Nombre"><br>
        <input  class='input' type="email"  name="correo" placeholder="correo"><br>
        <select name="tipo"><br>
            <option>.......</option>
            <option  value="administrador">Administrador</option>
            <option  value="comprador">Comprador</option>
            <option  value="vendedor ">Vendedor</option>
        </select><br>
        <input class='input' type="submit" name="enviar" value="enviar">
        </form>
        
    </body>
<html>
<?php
if (isset($_REQUEST['enviar'])){
    //variables 
    $nombre=$_REQUEST['nombre'];
    $email=$_REQUEST['correo'];
    $tipo=$_REQUEST['tipo'];

    //errores
    $errores="";
    if (strip_tags(trim($nombre==""))){
        $errores= $errores."<li>Falta el nombre\n";
    }
    if (strip_tags(trim($email)=="")){
        $errores=$errores."<li>Falta el correo\n";
    }

    if (strip_tags(trim($tipo)=="")){
        $errores=$erroes."<li>Falta el tipo de usuario\n";
    }

    if ($errores != ""){
        echo $errores;
    }
    else {
        //incluimos variables externas 
        include "../servidor.php";
        //conexion con el servidor 
        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        //creacion de consulta 
        $query="select * from usuario where nombres='$nombre' and correo='$email' and tipo_usuario='$tipo'";
        $consulta=mysqli_query($conexion,$query) or die ("fallo en la consulta");
        //comparamos con las filas y si hay alguna coincidencia imprimira los datos de la bsuqueda 
        $nfilas=mysqli_num_rows($consulta);
        if ($nfilas <> 1){
            echo "ERROR!!";
        }
        else{
            $resultado =mysqli_fetch_array($consulta);
                    echo "<form  action='modificar.php' method='GET'>";
                            echo "Nombre <input class='input' type='text' name='nom' value=".$resultado['nombres']."><br>";
                            echo "Correo <input class='input' type='email' name='cor' id='email' value=".$resultado['correo']."><br>";
                            echo "Password <input class='input' type='text' name='pass' value=".$resultado['clave']."><br>";
                            echo "<select name='tip'";
                                echo "<option value=".$resultado['tipo_usuario'].">". $resultado['tipo_usuario']."</option>";
                                echo"<option value='comprador'>comprador</option>
                                     <option value='vendedor'>vendedor</option>
                                     <option value='Administrador'>administrador</option>
                                </select>";
                            echo "<input class='input' type='hidden' name='id' value=".$resultado['usuario_id']."><br><br>";
                            echo "<input class='inpit' type='submit' value='actualizar' name='actualizar'>
                    </form>";

        }
        mysqli_close($conexion);
    }

}

//llamamos al segundo formulario 

if (isset($_REQUEST['actualizar'])){
    //declaramos las variables del segundo formulario 
    $nom=$_REQUEST['nom'];
    $cor=$_REQUEST['cor'];
    $tip=$_REQUEST['tip'];
    $password=$_REQUEST['pass'];
    $id=$_REQUEST['id'];
    //errores
    $errores2="";
    if (strip_tags(trim($nom==""))){
        $errores2= $errores2."<li>Falta el nombre\n";
    }
    if (strip_tags((trim($cor)==""))){
        $errores2=$errores2."<li>Falta el correo\n";
    }

    if (strip_tags(trim($tip)=="")){
        $errores2=$erroes2."<li>Falta el tipo de usuario\n";
    }

    if($errores2!=""){
        echo $errores2;
    }
    else {

        // incluimos variables externas 
        include "../servidor.php";
        //conexion con el servidor 
        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        //creacion de consulta 
        $query="update usuario set nombres='$nom',clave='$password',correo='$cor',tipo_usuario='$tip' where usuario_id=$id ";
        //resultado de consulta 
        if(mysqli_query($conexion,$query)){
            echo "usuario aceptado ";
            echo "<br>";
            echo "<a href='usuarios.html'>Volver</a>";
        }
        else {
            echo "usuario no  aceptado";
            echo "<br>";
            echo "<a href='usuarios.html'>Volver</a>";
        }
        //cerrar 
        mysqli_close ($conexion);

    }

}




?>