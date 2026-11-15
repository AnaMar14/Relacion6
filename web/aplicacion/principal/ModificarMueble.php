<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
require_once(dirname(__FILE__) . "/../../scripts/librerias/arrayMuebles.php");
//controlador

$arrayMuebles=obtenerMuebles();

//el índice llega por GET desde el index (primera vez) y por POST (al enviar el formulario)
$indice=$_POST["indice"] ?? $_GET["selectMuebles"] ?? 1;

//si el índice no es una clave del array de muebles, mostramos página de error
if(!validaRango($indice,$arrayMuebles,2)){
    paginaError("El mueble indicado no existe");
    exit();
}
$indice=(int)$indice;
$mueble=$arrayMuebles[$indice];
$esReciclado=($mueble instanceof MuebleReciclado);

$errores=[];
$modificado=false;

//valores iniciales del formulario: los datos que tiene el mueble según su tipo
$valores=[
    "nombre"=>$mueble->getNombre(),
    "fabricante"=>$mueble->getFabricante(),
    "pais"=>$mueble->getPais(),
    "anio"=>$mueble->getAnio(),
    "fechaIniVenta"=>$mueble->getFechaIniVenta(),
    "fechaFinVenta"=>$mueble->getFechaFinVenta(),
    "precio"=>$mueble->getPrecio()
];
if($esReciclado){
    $valores["porcentajeReciclado"]=$mueble->get_porcentajeReciclado();
}
else{
    $valores["peso"]=$mueble->get_Peso();
    $valores["serie"]=$mueble->get_serie();
}

//se ha enviado el formulario
if(isset($_POST["modificar"])){

    //recogemos los datos enviados (si algún campo no llega como cadena se queda vacío)
    foreach($valores as $campo=>$valor){
        $valores[$campo]=(isset($_POST[$campo]) && is_string($_POST[$campo]))? trim($_POST[$campo]) : "";
    }

    /************************************************************************ */
    // validación mediante una instancia auxiliar llamando a los métodos set
    //(nombre, año, fecha inicio venta y fecha fin venta)
    //la instancia auxiliar se crea con los datos actuales del mueble, que son válidos

    if($esReciclado){
        $aux=new MuebleReciclado($mueble->getNombre(),$mueble->getFabricante(),$mueble->getPais(),
            $mueble->getAnio(),$mueble->getFechaIniVenta(),$mueble->getFechaFinVenta(),
            $mueble->getPrecio(),$mueble->get_porcentajeReciclado());
    }
    else{
        $aux=new MuebleTradicional($mueble->getNombre(),$mueble->getFabricante(),$mueble->getPais(),
            $mueble->getAnio(),$mueble->getFechaIniVenta(),$mueble->getFechaFinVenta(),
            $mueble->getPrecio(),$mueble->get_Peso(),$mueble->get_serie());
    }

    if(!$aux->setNombre($valores["nombre"])){
        $errores["nombre"]="El nombre es obligatorio y puede tener un máximo de 40 caracteres";
    }

    //setAnio recibe un entero, así que antes comprobamos que lo sea
    if(filter_var($valores["anio"],FILTER_VALIDATE_INT)===false || !$aux->setAnio((int)$valores["anio"])){
        $errores["anio"]="El año debe ser un entero entre 2020 y " . date("Y");
    }

    // la fecha de inicio depende del año y la de fin de la de inicio
    if(!$aux->setFechaIniVenta($valores["fechaIniVenta"])){
        $errores["fechaIniVenta"]="Fecha incorrecta (dd/mm/aaaa) o anterior al 1 de enero del año de fabricación";
    }

    if(!$aux->setFechaFinVenta($valores["fechaFinVenta"])){
        $errores["fechaFinVenta"]="Fecha incorrecta (dd/mm/aaaa) o anterior a la fecha de inicio de venta";
    }

    /************************************************************************ */


    //fabricante: siempre empieza por "FaMu:" y se recorta a 30 caracteres (no puede dar error)
    $fabricante=$valores["fabricante"];
    if(!str_starts_with($fabricante,"FaMu:")){
        $fabricante="FaMu:" . $fabricante;
    }
    $fabricante=mb_substr($fabricante,0,30);

    //país: máximo 20 caracteres
    if(mb_strlen($valores["pais"])>20){
        $errores["pais"]="El país puede tener un máximo de 20 caracteres";
    }

    //precio: real, no puede ser menor de 30 (admitimos la coma como separador decimal)
    $precio=str_replace(",",".",$valores["precio"]);
    if(!is_numeric($precio) || $precio<30 || $precio>100000){
        $errores["precio"]="El precio debe ser un número entre 30 y 100000";
    }
    else{
        $precio=(float)$precio;
    }

    if($esReciclado){
        //porcentaje de reciclado: entero entre 0 y 100
        if(filter_var($valores["porcentajeReciclado"],FILTER_VALIDATE_INT,
            ["options"=>["min_range"=>0,"max_range"=>100]])===false){
            $errores["porcentajeReciclado"]="El porcentaje debe ser un entero entre 0 y 100";
        }
    }
    else{
        //peso: real entre 15 y 300
        $peso=str_replace(",",".",$valores["peso"]);
        if(!is_numeric($peso) || $peso<15 || $peso>300){
            $errores["peso"]="El peso debe ser un número entre 15 y 300";
        }
        else{
            $peso=(float)$peso;
        }

        //serie: cadena que no puede estar vacía
        if($valores["serie"]===""){
            $errores["serie"]="La serie no puede estar vacía";
        }
    }

    /************************************************************************ */
    //si todo es correcto actualizamos el mueble del array

    if(count($errores)==0){
        $mueble->setNombre($aux->getNombre());
        $mueble->setFabricante($fabricante);
        $mueble->setPais($valores["pais"]);
        $mueble->setAnio($aux->getAnio());
        $mueble->setFechaIniVenta($aux->getFechaIniVenta());
        $mueble->setFechaFinVenta($aux->getFechaFinVenta());
        $mueble->setPrecio($precio);
        $peso = null; 
        if($esReciclado){
            $mueble->set_porcentajeReciclado((int)$valores["porcentajeReciclado"]);
        }
        else{
            $mueble->set_Peso($peso);
            $mueble->set_serie($valores["serie"]);
        }
       
        $arrayMuebles[$indice]=$mueble;
        $modificado=true;
    }
}

$barra=[
     [
       "TEXTO"=> "Inicio",
       "ENLACE" =>"/index.php",
       "ADICIONAL"=>">>"],
     [
       "TEXTO"=> "Página principal",
       "ENLACE" =>"/aplicacion/principal/index.php",
       "ADICIONAL"=>">>"],
     [
       "TEXTO"=> "Modificar mueble"
     ]
];
$datos=[
    "indice"=>$indice,
    "mueble"=>$mueble,
    "esReciclado"=>$esReciclado,
    "valores"=>$valores,
    "errores"=>$errores,
    "modificado"=>$modificado
];

//dibuja la plantilla de la vista
inicioCabecera("MODIFICAR MUEBLE");
cabecera();
finCabecera();
inicioCuerpo("MODIFICAR MUEBLE",$barra);
cuerpo($datos);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera()
{
    ?>
    <?php
}

// muestra el mensaje de error de un campo (si lo tiene)
function mostrarError(array $errores, string $campo)
{
    if(isset($errores[$campo])){
        echo("<span class=\"error\">" . htmlspecialchars($errores[$campo]) . "</span>");
    }
}

//vista
function cuerpo(array $datos)
{
    $mueble=$datos["mueble"];
    $valores=$datos["valores"];
    $errores=$datos["errores"];

    if($datos["modificado"]){
        //resumen con los datos recogidos
        ?>
        <h2>MUEBLE MODIFICADO CORRECTAMENTE</h2>
        <p>Índice del mueble: <?= $datos["indice"] ?></p>
        <p>Tipo de mueble: <?= get_class($mueble) ?></p>
        <p>Nombre del mueble: <?= htmlspecialchars($mueble->getNombre()) ?></p>
        <p>Fabricante del mueble: <?= htmlspecialchars($mueble->getFabricante()) ?></p>
        <p>Pais de fabricación: <?= htmlspecialchars($mueble->getPais()) ?></p>
        <p>Año de fabricación: <?= $mueble->getAnio() ?></p>
        <p>Fecha inicio de venta: <?= $mueble->getFechaIniVenta() ?></p>
        <p>Fecha fin de venta: <?= $mueble->getFechaFinVenta() ?></p>
        <p>Precio del mueble: <?= $mueble->getPrecio() ?></p>
        <p>Características adicionales: <?= htmlspecialchars($mueble->getCaracteristicas()) ?></p>
        <?php
        foreach($mueble->damePropiedadesAdicionales() as $propAdicional){
            $metodo="get" . $propAdicional;
            ?>
            <p><?= ltrim($propAdicional,"_") ?>: <?= htmlspecialchars($mueble->$metodo()) ?></p>
            <?php
        }
        ?>
        <p>Recuerda: al no trabajar con sesiones, si recargas la página no aparecerán los cambios.</p>
        <?php
    }
    else{
        //formulario con los datos del mueble según su tipo
        ?>
        <h2>MODIFICAR MUEBLE <?= $datos["indice"] ?> (<?= get_class($mueble) ?>)</h2>
        <form method="post" action="modificarMueble.php">
            <input type="hidden" name="indice" value="<?= $datos["indice"] ?>">

            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" class="for_texto" name="nombre" id="nombre" value="<?= htmlspecialchars($valores["nombre"]) ?>">
                <?php mostrarError($errores,"nombre"); ?>
            </p>
            <p>
                <label for="fabricante">Fabricante:</label>
                <input type="text" class="for_texto" name="fabricante" id="fabricante" value="<?= htmlspecialchars($valores["fabricante"]) ?>">
                <?php mostrarError($errores,"fabricante"); ?>
            </p>
            <p>
                <label for="pais">País:</label>
                <input type="text" class="for_texto" name="pais" id="pais" value="<?= htmlspecialchars($valores["pais"]) ?>">
                <?php mostrarError($errores,"pais"); ?>
            </p>
            <p>
                <label for="anio">Año de fabricación:</label>
                <input type="text" class="for_texto" name="anio" id="anio" value="<?= htmlspecialchars($valores["anio"]) ?>">
                <?php mostrarError($errores,"anio"); ?>
            </p>
            <p>
                <label for="fechaIniVenta">Fecha inicio de venta:</label>
                <input type="text" class="for_texto" name="fechaIniVenta" id="fechaIniVenta" placeholder="dd/mm/aaaa" value="<?= htmlspecialchars($valores["fechaIniVenta"]) ?>">
                <?php mostrarError($errores,"fechaIniVenta"); ?>
            </p>
            <p>
                <label for="fechaFinVenta">Fecha fin de venta:</label>
                <input type="text" class="for_texto" name="fechaFinVenta" id="fechaFinVenta" placeholder="dd/mm/aaaa" value="<?= htmlspecialchars($valores["fechaFinVenta"]) ?>">
                <?php mostrarError($errores,"fechaFinVenta"); ?>
            </p>
            <p>
                <label for="precio">Precio:</label>
                <input type="text" class="for_texto" name="precio" id="precio" value="<?= htmlspecialchars($valores["precio"]) ?>">
                <?php mostrarError($errores,"precio"); ?>
            </p>

            <?php
            if($datos["esReciclado"]){
                ?>
                <p>
                    <label for="porcentajeReciclado">Porcentaje reciclado:</label>
                    <input type="text" class="for_texto" name="porcentajeReciclado" id="porcentajeReciclado" value="<?= htmlspecialchars($valores["porcentajeReciclado"]) ?>">
                    <?php mostrarError($errores,"porcentajeReciclado"); ?>
                </p>
                <?php
            }
            else{
                ?>
                <p>
                    <label for="peso">Peso:</label>
                    <input type="text" class="for_texto" name="peso" id="peso" value="<?= htmlspecialchars($valores["peso"]) ?>">
                    <?php mostrarError($errores,"peso"); ?>
                </p>
                <p>
                    <label for="serie">Serie:</label>
                    <input type="text" class="for_texto" name="serie" id="serie" value="<?= htmlspecialchars($valores["serie"]) ?>">
                    <?php mostrarError($errores,"serie"); ?>
                </p>
                <?php
            }
            ?>
            <p>
                <input type="submit" class="boton" value="Modificar" name="modificar">
            </p>
        </form>
        <?php
    }
    ?>
    <br>
    <a href="/aplicacion/principal/index.php">Ir a Index.php</a>
    <br><br>
    <?php
}