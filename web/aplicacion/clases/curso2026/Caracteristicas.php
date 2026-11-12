<?php

class Caracteristicas implements IteratorAggregate{

    //variables
    private array $_caracteristicas=[];

    //redefinicion metodos magicos 
    public function __set(string $name, mixed $value, ...$otras):void
    {
        if(!array_key_exists($name,$this->_caracteristicas)){
            if(array_key_exists("ULTIMA",$this->_caracteristicas)){
                throw new \Exception('No se puede añadir ' . $name 
                . ', ya se indicó la característica "ÚLTIMA" ' );
            }
        }
        $this->_caracteristicas[$name] = $value;
        
    }

    public function __get(string $nombre): mixed {
        return $this->datos[$nombre] ?? null;
    }

    public function __isset(string $nombre): bool {
        return isset($this->datos[$nombre]);
    }

    public function __unset(string $nombre): void {
        unset($this->datos[$nombre]);
    }

    //iterador
    #[Override]
    public function getIterator(): Iterator
    {
        return new ArrayIterator(array_reverse($this->_caracteristicas,true));
    }

    //toString

    public function __toString():string
    {
        $resultado="";
        
        foreach($this->_caracteristicas as $clave=>$valor){
            $resultado.= $clave . ":" . $valor . ";";
           
        }
        return $resultado;
    }
}