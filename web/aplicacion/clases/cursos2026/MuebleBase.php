<?php

abstract class MuebleBase{
    //Variables
    private const int _MAXIMO_MUEBLES=0;
    private static int $_numMuebles;
    private string $_nombre;
    private string $_fabricante;
    private string $_pais;
    private string $_anio;
    private string $_FechaIniVenta;
    private string $_FechaFinVenta;
    private float $_precio;

    //getters y setters

    public function getMaximoMuebles():int{
        return self::_MAXIMO_MUEBLES;
    }

    public function getNumMuebles():int{
        return self::$_numMuebles;
    }

    public function setNumMuebles(int $numMuebles):void{
        self::$_numMuebles=$numMuebles;
    }

    
}
?>