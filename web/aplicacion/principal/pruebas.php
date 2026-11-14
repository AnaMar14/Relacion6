<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador
$muebleReciclado=new MuebleReciclado(
    "Mesa de centro Eco",      // Nombre (obligatorio, máx 40, pasará a mayúsculas)
    "Maderas del Sur",         // Fabricante (al no llevar 'FaMu:', se le añadirá delante)
    "ESPAÑA",                  // País (máx 20 caracteres)
    2024,                      // Año (entero entre 2020 y 2026)
    "15/03/2024",              // FechaIniVenta (posterior o igual al 01/01/2024)
    "31/12/2035",              // FechaFinVenta (posterior o igual a FechaIniVenta)
    120.50,                    // Precio (real >= 30)
    85                         // PorcentajeReciclado (entero entre 0 y 100)
);
$muebleTradicional=new MuebleTradicional(
    "Armario Ropero Clásico",  // Nombre
    "FaMu:Artesanos SL",       // Fabricante (ya incluye 'FaMu:', se mantiene)
    "PORTUGAL",                // País
    2022,                      // Año
    "01/06/2022",              // FechaIniVenta
    "31/12/2040",              // FechaFinVenta
    450.00,                    // Precio
    95.5,                      // Peso (real entre 15 y 300)
    "S04-CLASSIC"              // Serie (cadena)
);
// $muebleBase= new MuebleBase(
//         "Mesa de Comedor",       // Nombre
//         "Carpintería Pérez",     // Fabricante (el set le añadirá "FaMu:")
//         "ESPAÑA",                // País
//         2022,                    // Año
//         "15/05/2022",            // Fecha Inicio Venta
//         "20/12/2030",            // Fecha Fin Venta
//         450.50                   // Precio
// );

$c=new Caracteristicas();

$puedeCrearNum=0;

$datos=[
    "muebleRec"=>$muebleReciclado,
    "muebleTrad"=>$muebleTradicional,
    "c"=>$c,
    // "muebleBase"=>$muebleBase,
    "puedeCrearNum"=>$puedeCrearNum

];
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

//dibuja la plantilla de la vista
inicioCabecera("PRUEBAS");
cabecera();
finCabecera();
inicioCuerpo("PRUEBAS",$barra);
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
    <br><br>
   
<?php
  echo("<h2>Mueble Reciclado</h2>");
  echo("get y set muebleReciclado<br>");
  echo($datos["muebleRec"]->get_porcentajeReciclado() . "<br>");
  $datos["muebleRec"]->set_porcentajeReciclado(101);
  echo($datos["muebleRec"]->get_porcentajeReciclado(). "<br>");

  echo("comprobacion toString y constructor <br>");
  echo($datos["muebleRec"] . "<br>");

  echo("metodo damePropiedadesAdicionales <br>");
  print_r($datos["muebleRec"]->damePropiedadesAdicionales());
/**************************************************************************** */
  echo("<h2>Mueble Tradicional</h2>");

  echo($datos["muebleTrad"]->get_Peso(). "<br>");
  $datos["muebleTrad"]->set_Peso(55);
  echo($datos["muebleTrad"]->get_Peso(). "<br>");


  echo($datos["muebleTrad"]->get_serie(). "<br>");
  $datos["muebleTrad"]->set_serie("AAA4");
  echo($datos["muebleTrad"]->get_serie(). "<br>");


  echo("toString<br>");
  echo($datos["muebleTrad"]);

  echo("metodo damePropiedadesAdicionales <br>");
  print_r($datos["muebleTrad"]->damePropiedadesAdicionales());

  echo("<br>añadir caracteristicas<br>");
  $datos["muebleTrad"]->añadirCaracteristicas("color","rojo");
   echo($datos["muebleTrad"]."<br>");
  /******************************************************************** */

  // echo("<h2>Pruebas mueble base quitandote abstract</h2>");
  // //$datos["muebleBase"]->color="red";
  // echo("Getters y setters<br>");
  // echo($datos["muebleBase"]->getMaximoMuebles() . "<br>");
  // echo($datos["muebleBase"]->getNumMuebles(). "<br>");
  // echo($datos["muebleBase"]->getNombre(). "<br>");
  // $datos["muebleBase"]->setNombre("       "). "<br>";
  // echo($datos["muebleBase"]->getNombre(). "<br>");
  // echo($datos["muebleBase"]->getFabricante(). "<br>");
  // $datos["muebleBase"]->setFabricante("ISRA"). "<br>";
  // echo($datos["muebleBase"]->getFabricante(). "<br>");
  // echo($datos["muebleBase"]->getPais(). "<br>");
  // echo($datos["muebleBase"]->getAnio(). "<br>");
  // echo($datos["muebleBase"]->getFechaIniVenta(). "<br>");
  // echo($datos["muebleBase"]->getFechaFinVenta(). "<br>");
  // echo($datos["muebleBase"]->getPrecio(). "<br>");
  // print_r($datos["muebleBase"]->puedeCrear($datos["puedeCrearNum"]) . "<br>");
  // echo($datos["puedeCrearNum"] . "<br>");
  // echo("toString: " . $datos["muebleBase"] );
  // echo("Metodo añadir caracteristicas<br>");
  // $datos["muebleBase"]->añadirCaracteristicas("color","rojo","dimensiones");
  // print_r($datos["muebleBase"]->getCaracteristicas());
/**************************************************************************** */
  echo("<h2>Clase caracterisicas</h2>");
  $datos["c"]->color="red";
  echo($datos["c"]."<br>");
  $datos["c"]->ULTIMA="madera";
  $datos["c"]->color="blue";
  echo($datos["c"]."<br>");
  //$datos["c"]->dimensiones="20x20";
  echo("<h3>Recorrido con foreach</h3>");
  foreach($datos["c"] as $propiedad=>$valor){
    echo($propiedad.":".$valor."<br>");
  }
}