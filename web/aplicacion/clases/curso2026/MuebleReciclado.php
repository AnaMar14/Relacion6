<?php

final class MuebleReciclado extends MuebleBase{

    //variables
    private int $_porcentajeReciclado;

    //getters y setters
    public function get_porcentajeReciclado()
    {
        return $this->_porcentajeReciclado;
    }

   
    public function set_porcentajeReciclado(int $porcentajeReciclado):bool
    {
        if($porcentajeReciclado>=0 && $porcentajeReciclado<=100){
            $this->_porcentajeReciclado = $porcentajeReciclado;
            return true;
        } 
        return false;
    }   

    //constructor
     public function __construct(
        string $nombre,
        string $fabricante = "FaMu:",
        string $pais = "ESPAÑA",
        int $anio = 2020,
        string $fechaIniVenta = "01/01/2020",
        string $fechaFinVenta = "31/12/2040",
        float $precio = 30,
        int $porcentajeReciclado = 10,
        Caracteristicas $carac
    ) {
        
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio, $carac);

       
        if (!$this->set_porcentajeReciclado($porcentajeReciclado)) {
            throw new Exception("Porcentaje debe de estar entre 0 y 100");
        }
    }

    //redefinir metodo heredado damePropiedadesAdicionales
    #[Override]
    public function damePropiedadesAdicionales(): array
    {
        return ["_porcentajeReciclado"] ;
    }

   #[Override]
   public function __toString(): string
   {
    return parent::__toString()  . 
        " y un porcentaje de reciclado del " 
        . $this->_porcentajeReciclado;;
   }
}