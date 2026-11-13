<?php

final class MuebleTradicional extends MuebleBase{

    private float $_peso;
    private string $_serie;


    //getters y setters
    public function get_Peso()
    {
        return $this->_peso;
    }

    public function set_Peso(float $peso):bool
    {
        if($peso>=15 && $peso<=300){

        $this->_peso = $peso;
        return true;
        }
        return false;
    }

    public function get_serie()
    {
        return $this->_serie;
    }

    public function set_serie(string $_serie)
    {
        $this->_serie = $_serie;

        return $this;
    }

     //constructor
    #[Override]
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA",
     int $anio = 2020, string $FechaIniVenta = "01/01/2020", string $FechaFinVenta = "31/12/2040",
      float $precio = 30, float $peso=15, string $serie="S01")
    {
        parent::__construct($nombre, $fabricante, $pais, $anio, $FechaIniVenta, $FechaFinVenta, $precio);
        if(!$this->set_Peso($peso)){
            throw new Exception("Peso debe de estar entre 15 y 300");
        }
        $this->set_serie($serie);
    }

     //metodo sobreescrito de MuebleBase
    #[Override]
    public function damePropiedadesAdicionales(): array
    {
        return["_peso","_serie"];
    }

    //toString
    #[Override]
    public function __toString(): string
    {
        return parent::__toString() . ",pesa " . $this->_peso
        . " y su serie es " . $this->_serie;
    }
   
}