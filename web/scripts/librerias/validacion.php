
<?php

/**
 * Función que comprueba que un número entero se encuentre dentro de 
 * un rango indicado, y si no lo está, se le asigna un número por defecto
 * al número inicialmente comprobado.
 * Sanea el número introducido en caso de que no sea valido.
 *
 * @param int $var Numero a comprobar
 * @param int $min  Numero que define el valor minimo del rango
 * @param int $max Numero que define el valor maximo del rango
 * @param int $defecto Numero que se asigna por defecto si no entra en el rango
 * @return bool Devuelve true si el número cumple con el rango, y false si no. Además en caso de false
 * se cambia el valor original del número introducido por el por defecto indicado.
 */

function validaEntero(int &$var, int $min, int $max, int $defecto):bool{
   if ((filter_var($var,FILTER_VALIDATE_INT)===false)){ //si no es un número int válido, lo sanea
    $var=filter_var($var,FILTER_SANITIZE_NUMBER_INT);
   }

       if($var>=$min && $var<=$max){
            return true;
        }
            $var=$defecto;
            return false;
   
}


/************************************************************************************* */

/**
 * Función que comprueba que un número real se encuentre dentro de 
 * un rango indicado, y si no lo está, se le asigna un número por defecto
 * al número inicialmente comprobado.
 * Sanea el número introducido en caso de que no sea valido.
 *
 * @param float $var Numero a comprobar
 * @param float $min  Numero que define el valor minimo del rango
 * @param float $max Numero que define el valor maximo del rango
 * @param float $defecto Numero que se asigna por defecto si no entra en el rango
 * @return bool Devuelve true si el número cumple con el rango, y false si no. Además en caso de false
 * se cambia el valor original del número introducido por el por defecto indicado.
 */

function validaReal(float &$var, float $min, float $max, float $defecto):bool{
     if ((filter_var($var, FILTER_VALIDATE_FLOAT)===false)){ //si no es un número real válido, lo sanea
    $var=filter_var($var,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION); //allow_fraction nos permite
                                                                                    //el uso de un punto para indicar decimales al pasarle el número
                                                                                    //que debe sanear. De otra forma sanea quitando el punto.
    }
    if($var>=$min && $var<=$max){
        return true;
    }
    $var=$defecto;
    return false;
}

/************************************************************************************* */
//filter_var no tiene opciones para fechas por lo que usamos la misma función que en val_normal

/**
 * Función que comprueba que una fecha introducida sea correcta y tenga el formato
 * dd/mm/aaaa. Si es correcta se devuelven los meses y dias con dos digitos
 * y si no lo es, a la fecha inicial se le asigna una fecha por defecto.
 *
 * @param string $var Fecha introducida a validar
 * @param string $defecto  Fecha que se asigna por defecto si la inicial no es válida
 * @return bool Devuelve true si la fecha introducida es válida y false si no lo es
 */

function validaFecha(string &$var, string $defecto):bool {
    //comprobamos que el formato de la fecha sea xx/xx/xxxx con expresiones regulares

    $patron = "/^[0-3]?[0-9]\/[0-1]?[0-9]\/[0-9]{4}$/"; //en orden dia mes y año

    $fechaDividida= explode("/",$var); //separamos el mes dia y fecha para luego comprobar
    //que sea una fecha válida y real con checkdate
   
    //el orden de checkdate es mes-dia-año por lo que introducimos los indices del array fechaDividida como 1,0,2
    if(preg_match($patron,$var) && checkdate($fechaDividida[1],$fechaDividida[0],$fechaDividida[2])){
       
        //saneamos para que los dias y meses del 1 al 9 se muestren con un 0 al inicio
        $var= date("d/m/Y", strtotime($fechaDividida[1] . "/" .  $fechaDividida[0] . "/" . $fechaDividida[2])); 
        //strotime se toma las fechas introducidas como en formato inglés(mes, dia, año) asi que le introduciremos
        //la fecha en ese orden aprovechando explode para que la interprete bien. Luego indicaremos que el orden sea d/m/Y
       
        return true;
        
    }
    $var=$defecto;
    return false;
    }

/************************************************************************************* */

//filter_var no tiene opciones para horas por lo que usamos la misma función que en val_normal

/**
 * Función que comprueba que una hora introducida sea correcta y tenga el formato
 * hh:mm:ss. Si es correcta se devuelven horas, minutos y segundos de 2 en 2 digitos
 * y si no lo es, a la hora inicial se le asigna una hora por defecto.
 *
 * @param string $var Hora introducida a validar
 * @param string $defecto  Hora que se asigna por defecto si la inicial no es válida
 * @return bool Devuelve true si la hora introducida es válida y false si no lo es
 * 
 */

function validaHora(string &$var,string $defecto):bool{
    //validar hora correcta mediante expresion regular (orden: horas,minutos,segundos)
    $patron = "/^ (([0]?[0-9]) |
                  ([1][0-9]) |
                  ([2][0-3])):
                        (([0]?[0-9]) |
                        ([1-5][0-9])):
                            (([0]?[0-9]) |
                            ([1-5][0-9]))
                  $/x"; //la x hace que ignore los espacios en blanco o saltos de linea
   //separamos horas minutos y segundos para añadirles "0" cuando sea necesario
    $hora_separada=explode(":",$var);
    
    if(preg_match($patron,$var)){
            //si se ha introducido solo un digito en alguno de los valores,
            //se completa añadiendo un 0 a la izquierda
            if(mb_strlen($hora_separada[0])==1){
                $aux=$hora_separada[0];
                $hora_separada[0]= "0".$aux;
            }
            if(mb_strlen($hora_separada[1])==1){
                $aux=$hora_separada[1];
                $hora_separada[1]= "0".$aux;
            }
            if(mb_strlen($hora_separada[2])==1){
                $aux=$hora_separada[2];
                $hora_separada[2]= "0".$aux;
            }
        //devolvemos la hora ya formateada
        $var=$hora_separada[0] . ":" . $hora_separada[1] . ":" . $hora_separada[2]; 
        return true;
    }
    $var=$defecto;
    return false;
}

/************************************************************************************* */

/**
 * Función que comprueba que un correo introducido tenga el formato correcto.
 * Si el formato del correo es correcto, se devuelve el correo saneado (quitandole simbolos y
 * caracteres invalidos) y si no lo es, al correo inicial se le asigna un correo por defecto.
 *
 * @param string $var Correo introducido a validar
 * @param string $defecto Correo que se asigna por defecto si el inicial no es válido
 * @return bool Devuelve true si el correo introducido es válido y false si no lo es
 * 
 */

function validaEmail(string &$var, string $defecto):bool{
    $patron="/^[^@]+@[[:lower:]]+\.([[:lower:]][.]?)+$/";//expresion regular que compruebe la estructura basica de un correo

     if(preg_match($patron,$var)){
        if(filter_var($var, FILTER_VALIDATE_EMAIL)===false){//validamos que el correo sea correcto y si no lo es, lo saneamos
         $var=filter_var($var,FILTER_SANITIZE_EMAIL);
        }

        return true;
    }

    $var=$defecto;
    return false;
}

/************************************************************************************* */
/**
 * Función que comprueba que una cadena introducida no se pase de una longitud 
 * máxima indicada. Si la cadena se pasa de longitud, se le asigna una nueva cadena 
 * por defecto.
 * 
 * @param string $var Cadena a comprobar
 * @param int $longitud Longitud máxima que puede alcanzar la cadena
 * @param string $defecto Cadena que asignamos a la cadena inicial en caso de que
 * sea incorrecta
 * @return bool Devuelve true si la cadena cumple el máximo de longitud y false si
 * se pasa.
 */

function validaCadena(string &$var, int $longitud, string $defecto):bool{
    if(mb_strlen($var)>$longitud){
        $var=$defecto;
        return false;
    }
    //$var=filter_var($var,FILTER_SANITIZE_STRING); obsoleto
    return true;
}

/************************************************************************************* */

/**
 * Función que comprueba que una cadena introducida cumpla una expresión regular indicada.
 * En caso de no cumplirla, a la cadena inicial se le asigna una por defecto.
 * 
 * @param string $var Cadena a comprobar
 * @param string $expresion Expresión regular con la que comprobaremos la validez de la cadena
 * @param string $defecto Cadena que asignamos a la cadena inicial en caso de que
 * no sea válida
 * @return bool Devuelve true si la cadena cumple con la expresion regular y false si
 * no la cumple.
 */

function validaExpresion(string &$var, string $expresion, string $defecto):bool{
   

    if((filter_var($var,FILTER_VALIDATE_REGEXP,["options"=>["regexp"=>$expresion]]))!==false){
        return true;
    }
    $var=$defecto;
    return false;
}
/************************************************************************************* */

/**
 * Función que comprueba que un elemento introducido de valor mixed(cualquier tipo) 
 * se encuentre en los valores o en las claves de un array asociativo pasado como parametro.
 * 
 * @param mixed $var Elemento a buscar dentro del array
 * @param array $posibles Array en el que buscaremos el elemento
 * @param int $tipo Numero que indica si buscaremos el elemento en los valores del array o en los claves
 * (1-> buscar en los valores, 2->buscar en las claves)
 * @return bool Devuelve true si el elemento es encontrado en el array y false si no se encuentra.
 */


function validaRango(mixed $var, array $posibles, int $tipo=1):bool{
    switch($tipo){
        case 1:
            $encontrado=array_search($var,$posibles);
            if($encontrado===false){
                return false;
            }
            return true;
        case 2:
            $claves=array_keys($posibles);
            $encontrado=array_search($var,$claves);
            if($encontrado===false){
                return false;
            }
            return true;
        default:
            return false;
    }
}