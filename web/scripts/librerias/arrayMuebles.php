<?php
function obtenerMuebles():array{
$catalogoMuebles=[];

$catalogoMuebles[1] = new MuebleReciclado('Mesa Eco', 'FaMu:SACAL', 'ESPAÑA', 2022, '01/01/2022', '31/12/2040', 45, 20);
$catalogoMuebles[1]->añadirCaracteristicas('color', 'verde', 'material', 'palets');

$catalogoMuebles[2] = new MuebleTradicional('Estantería Roble', 'FaMu:KETTAL', 'ESPAÑA', 2020, '01/06/2020', '31/12/2040', 150, 80, 'S01');
$catalogoMuebles[2]->añadirCaracteristicas('estantes', 4, 'acabado', 'barniz');

$catalogoMuebles[3] = new MuebleReciclado('Silla Oficina Restaurada', 'FaMu:SANCAL', 'PORTUGAL', 2021, '15/03/2021', '31/12/2030', 35, 50);
$catalogoMuebles[3]->añadirCaracteristicas('ergonomica', "si", 'tapizado', 'azul');

$catalogoMuebles[4] = new MuebleTradicional('Armario Clásico', 'FaMu:DOCA', 'FRANCIA', 2023, '10/01/2023', '31/12/2040', 320, 120, 'S02');
$catalogoMuebles[4]->añadirCaracteristicas('espejo', "si", 'puertas', 3);

$catalogoMuebles[5] = new MuebleReciclado('Taburete Alto', 'FaMu:KETTAL', 'ESPAÑA', 2024, '01/01/2024', '31/12/2035', 30, 10);
$catalogoMuebles[5]->añadirCaracteristicas('altura_cm', 75, 'plegable', "si");


    return $catalogoMuebles;
}