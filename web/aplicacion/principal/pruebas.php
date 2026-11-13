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
);;

$datos=[
    "muebleRec"=>$muebleReciclado,
    "muebleTrad"=>$muebleTradicional,

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

}