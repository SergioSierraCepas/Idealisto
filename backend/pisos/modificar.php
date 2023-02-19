<html>
    <hrad>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../codigoCSS.css">
    </head>
    <body>
        <form action='modificar.php'>
            Calle:<input type="text" name="calle"><br>
            Numero:<input type="text" name="numero"><br>
            Piso:<input type="number" name="piso"><br>
            puerta:<input type="text" name="puerta"><br>
            <input type="submit" value="modificar" name='modificar'>
            <a id='volver'  href="pisos.html">volver </a>
        </form>
    </body>
</html>
<?php
if (isset($_REQUEST['modificar'])){
    //declaracion de variables 
    $calle=strip_tags(trim($_REQUEST['calle']));
    $piso=strip_tags(trim($_REQUEST['piso']));
    $numero=strip_tags(trim($_REQUEST['numero']));
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
    if ($puerta == "") {
        $errores = $errores . "<li>El campo 'Puerta' está vacío.\n";
    }

    else {
         //conexion con el servidor 
            $conexion= mysqli_connect("localhost","root","rootroot") or die ("no se puede conectar con el servidor");
        //conexion con la base de datos 
            mysqli_select_db($conexion,"inmobiliaria") or die ("no se puede seleccionar la base de datos");
        //crecion de consulta 
            $query="select * from pisos where calle='$calle' and piso='$piso' and numero='$numero' and  puerta='$puerta';";
            $consulta = mysqli_query ($conexion,$query) or die ("Fallo en la consulta");
        //mostrar resultados 
            $nfilas=mysqli_num_rows($consulta);
        if ($nfilas == 0){
            echo "ERROR!!";
        }
        else{
            $resultado =mysqli_fetch_array($consulta);
            echo "<h3> Cambie cualquier campo  para modificar la oferta</h3>";
            echo "<form  action='modificar.php' method='POST' enctype='multipart/form-data'>";
            echo "
                Calle:<input class='input'  type='text' name='calle'  value=".$resultado['calle']."><br>
                Numero:<input class='input' type='text' name='numero'  value=".$resultado['numero']."><br>
                Piso:<input class='input' type='number' name='piso'  value=".$resultado['piso']."><br>
                puerta:<input class='input' type='text' name='puerta'  value=".$resultado['puerta']."><br>
                Codigo Postal <input clas='input' type='number' name='cp'  value=".$resultado['cp']."><br>
                metros(m2):<input class='input' type='number' name='m2'  value=".$resultado['metros']."><br>
                zona:<input class='input' type='text' name='zona'  value=".$resultado['zona']."><br>
                precio:<input class='input'  type='number' name='precio'  value=".$resultado['precio']."><br>
                <input class='input' type='hidden' name='max-size' vale='102400'><br>
                imagen <input class='input'  type='file' name='imagen'><br>";
            echo "<input class='input' type='hidden' name='codigo' value=".$resultado["Codigo_piso"].">";
            echo "<input class='input' type='submit' value='actualizar' name='entrar2'>";
            echo "</form>";

        }
    }

}

if (isset($_REQUEST['entrar2'])){
    //declaramos variables 
    $calle=strip_tags(trim($_REQUEST['calle']));
    $numero=strip_tags(trim($_REQUEST['numero']));
    $piso=strip_tags(trim($_REQUEST['piso']));
    $puerta=strip_tags(trim($_REQUEST['puerta']));
    $cp=strip_tags(trim($_REQUEST['cp']));
    $m=strip_tags(trim($_REQUEST['m2']));
    $zona=strip_tags(trim($_REQUEST['zona']));
    $precio=strip_tags(trim($_REQUEST['precio']));
    $codigo=strip_tags(trim($_REQUEST['codigo']));
    $file=strip_tags(trim($_FILES['imagen']['tmp_name']));
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
    if ($puerta == "") {
        $errores = $errores . "<li>El campo 'Puerta' está vacío.\n";
    }
    if (!is_numeric($cp) || $cp == "") {
        $errores = $errores . "   <li>El campo 'Código postal' debe ser numérico." . $cp . "\n";
    }
    if (!is_numeric($m) || $m == "") {
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
    if(is_uploaded_file($file)){
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
    elseif ($_FILES['imagen']['error'] == UPLOAD_ERR_FORM_SIZE) {
        $maxsize = $_REQUEST['tamaño'];
        $errores = $errores . "<li>El tamaño del fichero supera el límite predeterminado";
    }       //mover foto a la ubicacion final 
    if ($fichero){
        move_uploaded_file($_FILES['imagen']['tmp_name'],$directorio . $imagen);
    }

    //no se ha introducido ningun ficfero o no se ha podido subir 
    if($file ==""){
         //conexion al servidor 
         $conexion=mysqli_connect("localhost","root","rootroot") or die ("no se puede conectar con el servidor");
         //conexion con la base de datos 
         mysqli_select_db($conexion,"inmobiliaria") or die ("no se puede seleccionar la base de datos");
         //crecion de consulta e inserccion de la consulta 
         $consulta="update pisos set calle='$calle',numero='$numero',piso='$piso',puerta='$puerta',cp='$cp',metros='$m',zona='$zona',precio='$precio' where Codigo_piso='$codigo'" or die ("fallo en la consulta ");
 
         //resultado de la consulta 
         if (mysqli_query($conexion,$consulta)){
             echo "oferta actualizada";
             echo "<br>";
            
    
         }
         else {
             echo "error al actualizar la noticia";
             echo "<br>";
         }
       
     
    }
    else{
 
    if ($errores == ""){
        //conexion al servidor 
        $conexion=mysqli_connect("localhost","root","rootroot") or die ("no se puede conectar con el servidor");
        //conexion con la base de datos 
        mysqli_select_db($conexion,"inmobiliaria") or die ("no se puede seleccionar la base de datos");
        //crecion de consulta e inserccion de la consulta 
        $consulta="update pisos set calle='$calle',numero='$numero',piso='$piso',puerta='$puerta',cp='$cp',metros='$m',zona='$zona',precio='$precio', imagen='$ruta' where Codigo_piso='$codigo'" or die ("fallo en la consulta ");

        //resultado de la consulta 
        if (mysqli_query($conexion,$consulta)){
            echo "oferta actualizada";
            echo "<br>";
            
   
        }
        else {
            echo "error al actualizar la noticia";
            echo "<br>";
        }
        //cerramos conexion 
        mysqli_close($conexion);
    }
    }

    //mostrar errores 
    if ($errores!= "" || $imagen == ''){
    echo  " errores:\n";
         echo $errores;
        
      
    }
    

}
?>