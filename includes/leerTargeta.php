<?php
require_once("_db.php"); 
global $conexion; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $file = 'lectura.txt';
    if (isset($_POST['uid'])) {

        $uid = $_POST['uid'];
        if (file_exists($file)) {
            $lines = file($file); 
            // Reemplazar la primera línea con el nuevo UID
            $lines[0] = $uid . PHP_EOL;
            file_put_contents($file, implode("", $lines)); // Escribe el contenido actualizado
        } else {
            file_put_contents($file, $uid . PHP_EOL);
        }

        echo $uid ."\n"; 
        echo "Lectura existosa";
    } else {
        echo "Esperando lectura...";
    }
    mysqli_close($conexion);
}
?>
