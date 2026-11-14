<?php

// Enviamos la cabecera HTTP de redirección al navegador
header("Location: aplicacion/principal/index.php");

// Aseguramos que el script se detenga inmediatamente después de ordenar la redirección
exit();