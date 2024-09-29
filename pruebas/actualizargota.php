<?php
require_once("../includes/_db.php"); 
global $conexion;


// Obtener todas las filas de la tabla
$resultado = $conexion->query("SELECT * FROM accesos_logs");

// Crear un conjunto para rastrear horas generadas
$horasGeneradas = [];

while ($fila = $resultado->fetch_assoc()) {
    $idAccesoLog = $fila['idAccesoLog'];
    
    do {
        // Generar un día aleatorio entre 9 y 13
        $diaAleatorio = rand(9, 13);
        // Definir el mes y el año (ajusta según sea necesario)
        $mes = date('m'); // Mes actual
        $anio = date('Y'); // Año actual

        // Generar la fecha completa
        $fechaAleatoria = sprintf('%04d-%02d-%02d', $anio, $mes, $diaAleatorio); 

        // Generar una hora aleatoria entre 9 AM y 7 PM
        $horaAleatoria = sprintf('%02d:%02d:00', rand(9, 19), rand(0, 59)); // Horas aleatorias entre 9 y 19, minutos aleatorios entre 0 y 59
        $fechaHoraAleatoria = "$fechaAleatoria $horaAleatoria"; // Concatenar fecha y hora
    } while (in_array($fechaHoraAleatoria, $horasGeneradas)); // Asegurarse de que no esté ya en el conjunto

    // Agregar la hora generada al conjunto
    $horasGeneradas[] = $fechaHoraAleatoria;
    // Seleccionar un nuevo idArea aleatorio de la lista permitida
    $nuevoIdArea = [1, 2, 4, 6, 7][array_rand([1, 2, 4, 6, 7])]; // Seleccionar un idArea aleatorio

    // Actualizar los campos horaAcceso y idArea
    $conexion->query("UPDATE accesos_logs SET horaAcceso = '$fechaHoraAleatoria', idArea = $nuevoIdArea WHERE idAccesoLog = $idAccesoLog");
}

// Cerrar la conexión
$conexion->close();
?>
