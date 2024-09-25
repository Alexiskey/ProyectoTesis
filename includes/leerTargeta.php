<?php
// Este bloque PHP manejará las solicitudes POST desde AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = mysqli_connect("localhost", "root", "", "ingresos_rfid");

    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Definir la variable $file antes de usarla
    $file = 'lectura.txt'; // Asegúrate de que la ruta sea correcta y que el archivo exista

    if (isset($_POST['uid'])) {
        // Sanitiza la entrada
        $uid = $_POST['uid'];
        
        // Comprobar si el archivo existe
        if (file_exists($file)) {
            // Leer el contenido actual del archivo
            $lines = file($file); // Lee el archivo en un array de líneas

            // Reemplazar la primera línea con el nuevo UID
            $lines[0] = $uid . PHP_EOL;

            // Guardar el contenido actualizado en el archivo
            file_put_contents($file, implode("", $lines)); // Escribe el contenido actualizado
        } else {
            // Si el archivo no existe, crear uno nuevo y escribir el UID
            file_put_contents($file, $uid . PHP_EOL);
        }

        echo $uid; // Aquí podrías hacer algo más con el UID
    } else {
        echo "Esperando lectura...";
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
