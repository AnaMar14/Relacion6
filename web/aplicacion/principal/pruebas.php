<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$datos=[
    "muebleRec"=>$muebleReciclado,
    "muebleTrad"=>$muebleTradicional,
    "car"=>$caracteristicas
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
echo($datos["muebleRec"]);
}