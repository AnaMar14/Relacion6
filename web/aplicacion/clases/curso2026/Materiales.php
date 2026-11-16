<?php
 enum Materiales:int{

    case Madera=5;
    case Hierro=10;
    case Acero=15;
    case Plastico=20;

    //funcion para obtener el nombre del material
    function get_material():string{
         return $this->name; 
    }

 
 }