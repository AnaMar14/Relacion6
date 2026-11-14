<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
require_once(dirname(__FILE__). "/../../scripts/librerias/arrayMuebles.php");
//controlador

$arrayMuebles=obtenerMuebles();
$arrayPropsAdicionales=[];
$MuebleElegido = $_GET["selectMuebles"] ?? 1;
$barra=[
     [
       "TEXTO"=> "Inicio",
       "ENLACE" =>"/index.php",
       "ADICIONAL"=>">>"],
     [ 
       "TEXTO"=> "Otro"   
     ],  
     [ 
       "TEXTO"=> "index",
       "ADICIONAL"=> "&copy;&copy;"   
     ]
];
$datos=[

    "arrayMuebles"=>$arrayMuebles,
    "arrayPropsAdicionales"=>$arrayPropsAdicionales,
    "MuebleElegido"=>$MuebleElegido
];

//dibuja la plantilla de la vista
inicioCabecera("PÁGINA PRINCIPAL");
cabecera();
finCabecera();
inicioCuerpo("PÁGINA PRINCIPAL",$barra);
cuerpo($datos);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{
    ?>
     <?php   


}

//vista
function cuerpo($datos)
{
?>
    <table class="tabla">
        <tr>
            <th>Índice mueble</th>
            <th>Tipo mueble</th>
            <th>Nombre mueble</th>
            <th>Fabricante</th>
            <th>Fecha Inicio Venta</th>
            <th>Fecha Fin Venta</th>
            <th>Precio</th>
            <th>Características extra</th>
           
        </tr>
        <tr>
           <td>1</td>
           <td><?php echo(get_class($datos["arrayMuebles"][1]))?></td>
           <td><?php echo($datos["arrayMuebles"][1]->getNombre())?></td>
           <td><?php echo($datos["arrayMuebles"][1]->getFabricante())?></td>
           <td><?php echo($datos["arrayMuebles"][1]->getFechaIniVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][1]->getFechaFinVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][1]->getPrecio())?></td>
           <td><?php echo($datos["arrayMuebles"][1]->getCaracteristicas())?></td>
           
        </tr>
        <tr>
           <td>2</td>
           <td><?php echo(get_class($datos["arrayMuebles"][2]))?></td>
           <td><?php echo($datos["arrayMuebles"][2]->getNombre())?></td>
           <td><?php echo($datos["arrayMuebles"][2]->getFabricante())?></td>
           <td><?php echo($datos["arrayMuebles"][2]->getFechaIniVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][2]->getFechaFinVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][2]->getPrecio())?></td>
           <td><?php echo($datos["arrayMuebles"][2]->getCaracteristicas())?></td>
           
        </tr>
        <tr>
           <td>3</td>
           <td><?php echo(get_class($datos["arrayMuebles"][3]))?></td>
           <td><?php echo($datos["arrayMuebles"][3]->getNombre())?></td>
           <td><?php echo($datos["arrayMuebles"][3]->getFabricante())?></td>
           <td><?php echo($datos["arrayMuebles"][3]->getFechaIniVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][3]->getFechaFinVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][3]->getPrecio())?></td>
           <td><?php echo($datos["arrayMuebles"][3]->getCaracteristicas())?></td>
           
        </tr>
        <tr>
           <td>4</td>
           <td><?php echo(get_class($datos["arrayMuebles"][4]))?></td>
           <td><?php echo($datos["arrayMuebles"][4]->getNombre())?></td>
           <td><?php echo($datos["arrayMuebles"][4]->getFabricante())?></td>
           <td><?php echo($datos["arrayMuebles"][4]->getFechaIniVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][4]->getFechaFinVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][4]->getPrecio())?></td>
           <td><?php echo($datos["arrayMuebles"][4]->getCaracteristicas())?></td>
           
        </tr>
        <tr>
           <td>5</td>
           <td><?php echo(get_class($datos["arrayMuebles"][5]))?></td>
           <td><?php echo($datos["arrayMuebles"][5]->getNombre())?></td>
           <td><?php echo($datos["arrayMuebles"][5]->getFabricante())?></td>
           <td><?php echo($datos["arrayMuebles"][5]->getFechaIniVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][5]->getFechaFinVenta())?></td>
           <td><?php echo($datos["arrayMuebles"][5]->getPrecio())?></td>
           <td><?php echo($datos["arrayMuebles"][5]->getCaracteristicas())?></td>
           
        </tr>
    </table>
    <br>
    <br>
    <form method="get">
        <input type="submit" value="Mostrar Mueble" name="mostrarMueble">
        <input type="submit" value="Modificar Mueble" name="modificarMueble">
        <select name="selectMuebles" id="selectMuebles">
            <option value="1" <?=($datos["MuebleElegido"]==1)? "selected":"" ?>>MESA ECO</option>
            <option value="2" <?=($datos["MuebleElegido"]==2)? "selected":"" ?>>ESTANTERÍA ROBLE</option>
            <option value="3" <?=($datos["MuebleElegido"]==3)? "selected":"" ?>>SILLA OFICINA RESTAURADA</option>
            <option value="4" <?=($datos["MuebleElegido"]==4)? "selected":"" ?>>ARMARIO CLÁSICO</option>
            <option value="5" <?=($datos["MuebleElegido"]==5)? "selected":"" ?>>TABURETE ALTO</option>
        </select>
    </form>

    <?php
      if(isset($_GET["mostrarMueble"])){
        $mueble=$datos["arrayMuebles"][$_GET["selectMuebles"]];
        ?>
        <h2>DATOS MUEBLE</h2>
        <p>
        <?php
        echo( "Nombre del mueble: " . $mueble->getNombre());
        ?>
        </p>

         <p>
        <?php
        echo( "Fabricante del mueble: " . $mueble->getFabricante());
        ?>
        </p>

         <p>
        <?php
        echo( "Pais de fabricación: " . $mueble->getPais());
        ?>
        </p>

         <p>
        <?php
        echo( "Año de fabricación: " . $mueble->getAnio());
        ?>
        </p>

         <p>
        <?php
        echo( "Fecha inicio de venta: " . $mueble->getFechaIniVenta());
        ?>
        </p>

         <p>
        <?php
        echo( "Fecha fin de venta: " . $mueble->getFechaFinVenta());
        ?>
        </p>

         <p>
        <?php
        echo( "Precio del mueble: " . $mueble->getPrecio());
        ?>
        </p>

         <p>
        <?php
        echo( "Características adicionales: " . $mueble->getCaracteristicas());
        ?>
        </p>
        <?php
        $datos["arrayPropsAdicionales"]= $mueble->damePropiedadesAdicionales();
        foreach( $datos["arrayPropsAdicionales"] as $propsAdicionales ){
            $metodo="get" . $propsAdicionales;
            ?>
            <p>
            <?php
            echo($propsAdicionales . ": " . $mueble->$metodo());
            ?>
            </p>
            <?php
        }
        ?>
    <?php
      }
    ?>
<!-- 
    Al pulsar el botón formulario Modificar Mueble se abrirá una nueva ventana con un
formulario que permitirá modificar los datos del mueble indicado. En el formulario se
mostrarán inicialmente los datos que tiene el mueble según el tipo del mismo. Cuando se
envíe el formulario, se deben validar los datos enviados según las condiciones del
apartado 1 y 2. La mitad mediante una instancia auxiliar del tipo de mueble, llamando a
los métodos set, y la otra mitad de las propiedades se debe validar directamente usando
condiciones. Si todo es correcto se actualizará el mueble correspondiente y se mostrará
un resumen con los datos recogidos. Habrá un enlace a ir a Index.php que nos permitirá
volver a la página principal
Ojo, al no trabajar con sesiones, al recargar la página no aparecerán los cambios en el
mueble que hemos modificado. -->
    <br><br>
   
<?php

  

}