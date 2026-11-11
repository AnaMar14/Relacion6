<?php
require_once __DIR__ . "/../../../scripts/librerias/validacion.php";
abstract class MuebleBase{
    //Variables
    private const int _MAXIMO_MUEBLES=10;
    private static int $_numMuebles=0;
    private string $_nombre;
    private string $_fabricante;
    private string $_pais;
    private int $_anio;
    private string $_FechaIniVenta;
    private string $_FechaFinVenta;
    private float $_precio;
    

    //prohibimos asginar propiedades de manera dinamica
    public function __set(string $nombre, mixed $valor): void
    {
    throw new Exception("No se permite crear ni modificar la propiedad '$nombre' directamente");
    }
    
    
    //getters y setters
    //maximo muebles
    public static function getMaximoMuebles():int{
        return self::_MAXIMO_MUEBLES;
    }
    //numero muebles
    public static function getNumMuebles():int{
        return self::$_numMuebles;
    }

    //  nombre 
    public function getNombre(): string
    {
        return $this->_nombre;
    }

    public function setNombre(string $nombre): bool
    {   
        if(trim($nombre)=="" || !validaCadena($nombre,40,"")){
            return false;
        }

            $this->_nombre = mb_strtoupper($nombre);
            return true;
     
    }

    // fabricante
    public function getFabricante(): string
    {
        return $this->_fabricante;
    }

    public function setFabricante(string $fabricante): bool
    {
        $fabricante=trim($fabricante);
       if(!str_starts_with($fabricante, "FaMu:")){
        $fabricante="FaMu:" . $fabricante;
       }

        $this->_fabricante = mb_substr($fabricante,0,30);
       return true;
    }

    // pais
    public function getPais(): string
    {
        return $this->_pais;
    }

    public function setPais(string $pais): bool
    {
        if(validaCadena($pais,20,"")){
            $this->_pais = $pais;
            return true;
        }
        
        return false;
    }

    // año
    public function getAnio(): int
    {
        return $this->_anio;
    }

    public function setAnio(int $anio): bool
    {
        if($anio<2020 || $anio>intval(date('Y'))){
            return false;
        }
        $this->_anio = $anio;
        return true;
    }

    //fecha inicio venta
    public function getFechaIniVenta(): string
    {
        
        return $this->_FechaIniVenta;
    }

    public function setFechaIniVenta(string $fecha): bool
    {
         
        if(!validaFecha($fecha,"01/01/" . date("Y"))){
            return false;
        }
        $fechaIntro= DateTimeImmutable::createFromFormat('!d/m/Y',$fecha);
        $iniFab=new DateTimeImmutable($this->_anio . '-01-01');
       

        if($fechaIntro<$iniFab){

            return false;
        }
        $this->_FechaIniVenta = $fecha;
        return true;
    }

    // fecha fin venta
    public function getFechaFinVenta(): string
    {
        return $this->_FechaFinVenta;
    }

    public function setFechaFinVenta(string $fecha): bool
    {
        if(!validaFecha($fecha,"31/12/2040")){
            return false;
        }
        $fechaIntro= DateTimeImmutable::createFromFormat('!d/m/Y',$fecha);
        $DateIniVenta=DateTimeImmutable::createFromFormat('!d/m/Y',$this->_FechaIniVenta);
       

        if($fechaIntro<$DateIniVenta){

            return false;
        }
        $this->_FechaFinVenta = $fecha;
        return true;
    }

    // precio
    public function getPrecio(): float
    {
        return $this->_precio;
    }

    public function setPrecio(float $precio): bool
    {
        if(!validaReal($precio,30,100000,30)){
            return false;
        }
        $this->_precio = $precio;
        return true;
    }
    
    //constructor
    public function __construct(string $nombre, string $fabricante="FaMu:", string $pais="ESPAÑA",
     int $anio=2020, string $FechaIniVenta="01/01/2020", string $FechaFinVenta="31/12/2040",float $precio=30){
        
        if(self::$_numMuebles> self::_MAXIMO_MUEBLES){
            throw new Exception("Máximo de muebles creados alcanzado");
        } 
        
        if(!$this->setNombre($nombre)){
            throw new Exception("El campo nombre es obligatorio");
        }
        if (!$this->setFabricante($fabricante)) {
            $this->_fabricante = "FaMu:";
        }
        if (!$this->setPais($pais)) {
            $this->_pais = "ESPAÑA";
        }
        if (!$this->setAnio($anio)) {
            $this->_anio = 2020;
        }
        if (!$this->setFechaIniVenta($FechaIniVenta)) {
            $this->_FechaIniVenta = "01/01/" . $this->_anio;
        }
        if (!$this->setFechaFinVenta($FechaFinVenta)) {
            $this->_FechaFinVenta = "31/12/2040";
        }
        if (!$this->setPrecio($precio)) {
            $this->_precio = 30;
        }
        self::$_numMuebles++;
        
        
        
    }

    //metodos
    abstract public function damePropiedadesAdicionales():array;

    public static function puedeCrear(int &$numero):bool{
        if(self::$_numMuebles>=self::_MAXIMO_MUEBLES){

            $numero=0;
            return false;
        }
        $numero=((self::_MAXIMO_MUEBLES)-(self::$_numMuebles));
        return true;
    }

    public function __toString(): string{

        return "MUEBLE de clase " . get_class($this)
        . " con nombre " .  $this->getNombre() 
        . ", fabricante " . $this->getFabricante()
        . ", fabricado en " . $this->getPais()
        . " a partir del año " . $this->getAnio() . ", vendido desde " . 
        $this-> getFechaIniVenta() . " hasta " .
        $this->getFechaFinVenta() . ", precio " . $this->getPrecio();
    }


}
?>