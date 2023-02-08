<html>
    <head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="codigoCSS.css">
    </head>
    <body>
        <form action="alta.php" method="POST" enctype="multipart/form-data">
            Calle:<input class='input'  type="text" name="calle"><br>
            Numero:<input class='input' type="text" name="numero"><br>
            Piso:<input class='input' type="number" name="piso"><br>
            Puerta:<input class='input' type="text" name="puerta"><br>
            Codigo Postal <input class='input' type="number" name="cp"><br>
            Metros(m2):<input class='input' type="number" name="m2"><br>
            Zona:<input class='input' type="text" name="zona"><br>
            Precio:<input class='input' type="number" name="precio"><br>
             <input  class='input'type="hidden" name="max-size" vale="102400"><br>
            Imagen <input  class='input'type="file" name="imagen"><br>
            Usuario <input class='input' type="text" name="usuario"><br>
            <input class='input' type="submit" value="enviar" name="enviar">
        </form>
    </body>
</html>
<?php
if (isset($_REQUEST['enviar'])){
//declaracion de variables
$calle=strip_tags(trim($_REQUEST['calle']));
$numero=strip_tags(trim($_REQUEST['numero']));
$piso=strip_tags(trim($_REQUEST['piso']));
$puerta=strip_tags(trim($_REQUEST['puerta']));
$cp=strip_tags(trim($_REQUEST['cp']));
$m2=strip_tags(trim($_REQUEST['m2']));
$precio=strip_tags(trim($_REQUEST['precio']));
$zona=strip_tags(trim($_REQUEST['zona']));
$nombre=strip_tags(trim($_REQUEST['usuario']));
$comprobacion=false;

///////////comprobacion existencia usuario /////////////////////////////////
    $conexion= mysqli_connect("localhost","root","rootroot") or die ("no se puede conectar con el servidor");
//conexion con la base de datos 
    mysqli_select_db($conexion,"inmobiliaria") or die ("no se puede seleccionar la base de datos");
//declaramos la consulta 
    $query="select * from usuario where nombres='$nombre'";
//echo $query;
//aplicamos consulta 
    $consulta = mysqli_query ($conexion,$query) or die ("fallo de la consulta");


    //mostramos resultado 
    $nfilas=mysqli_num_rows($consulta);
    if ($nfilas == 0){
        echo "no existe el usuario";
    }
    else {
        $resultado =mysqli_fetch_array($consulta);
        $usuario=$resultado['usuario_id'];
        $comprobacion=true;
    } 
 mysqli_close($conexion);

    //echo $usuario;
 if ($comprobacion){
    echo $numero; 
    echo $piso;
    //comprobacion de errores
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
    if ($puerta == "") {
        $errores = $errores . "<li>El campo 'Puerta' está vacío.\n";
    }
    if (!is_numeric($cp) || $cp == "") {
        $errores = $errores . "   <li>El campo 'Código postal' debe ser numérico." . $cp . "\n";
    }
    if (!is_numeric($metros) || $metros == "") {
        $errores = $errores . "<li>El campo 'Metros2' debe ser numérico." . $metros . "\n";
    }
    if (is_numeric($zona) || $zona == "") {
        $errores = $errores . "<li>El campo 'Zona' está vacío.\n";
    }
    if (!is_numeric($precio) || $precio == "") {
        $errores = $errores . "<li>El campo 'Precio' debe ser numérico." . $precio . "\n";
    }
 

    //subida de imagen
    $fichero=false;
    //copiar el fichero en el directorio con marca de tiempo 
    if (is_uploaded_file($_FILES['imagen']['tmp_name'])){
        $directorio="imagenes/";
        $imagen=$_FILES['imagen']['name'];
        $fichero=true;
        //renombrarlo si ya existe
        $ruta=$directorio . $imagen;
        if (is_file($ruta)){
            $id=time();
            $imagen=$id."--".$imagen;
        }
    }
    //comprobacionde tamaño
    else if($_FILES['imagen']['error']== UPLOAD_ERR_FORM_SIZE) {
        $maxsize=$_REQUEST['max-size'];
        $errores=$errores."<li>el tamaño supera el permitido ($maxsize)\n"; 
    }
    //no se ha introducido ningun fichero o no se ha podido subir 
    else if ($_FILES['imagen']['name'] ==""){
        $imagen='';
        $errores = $errores ."<li> no se ha introducido una imagen \n";
    }
    else{
        $errores=$errores ."<li>no se ha podido subir el fichero\n";
    }

    //mostrar errores 
    if ($errores!= "" || $imagen == ''){
        echo  (" errores:\n");
        echo  ($errores);
        echo  ("<P>[ <A HREF='javascript:history.back()'>Volver</A> ]</P>\n");
      
    }
    //mover foto a la ubicacion final 
    if ($fichero){
        move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio . $imagen);
    }


    if ($errores == ""){
        echo "swss";
        //conexion al servidor 
            $conexion=mysqli_connect("localhost","root","rootroot") or die ("no se puede conectar con el servidor");
        //conexion con la base de datos 
            mysqli_select_db($conexion,"inmobiliaria") or die ("no se puede seleccionar la base de datos");
        //crecion de consulta e inserccion de la consulta 
            $consulta="insert into pisos (calle,numero,piso,puerta,cp,metros,zona,precio,imagen,usuario_id) values ('$calle','$numero','$piso','$puerta','$cp','$m2','$zona','$precio','$ruta','$usuario')";
        echo $consulta;
        //resultado de la consulta 
        if (mysqli_query($conexion,$consulta)){
            echo "oferta dada de alta";
            echo "<br>";
            echo "<a href='pisos.html'>Volver</a>";
        }
        else {
            echo "error en la subida de la noticia";
            echo "<br>";
            echo "<a href='pisos.html'>Volver</a>";
        }
    }
    //cerramos conexion 
    mysqli_close($conexion);
}
}
?>