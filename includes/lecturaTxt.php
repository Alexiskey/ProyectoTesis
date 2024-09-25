<?php
// Este bloque manejará las solicitudes GET para leer la primera línea de lectura.txt
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $file = 'lectura.txt'; // Asegúrate de que la ruta sea correcta
    if (file_exists($file)) {
        // Leer la primera línea del archivo
        $linea = fgets(fopen($file, "r")); // Abre el archivo en modo lectura
        echo $linea; // Devuelve la primera línea
        exit; // Termina el script aquí para no ejecutar más
    } else {
        echo "El archivo no existe.";
        exit; // Termina el script aquí
    }
}

// Este bloque manejará la solicitud POST para actualizar el contenido de lectura.txt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = 'lectura.txt';
    // Escribir "Esperando tarjeta..." en el archivo
    file_put_contents($file, "Esperando tarjeta..." . PHP_EOL);
    exit;
}
?>

