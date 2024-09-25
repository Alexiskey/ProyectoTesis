<?php
$conexion= mysqli_connect("localhost", "root", "", "ingresos_rfid");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los valores enviados por Arduino
$uid = $_GET['uid'];
$Area = $_GET['Area'];

// Insertar en la base de datos
$sql = "INSERT INTO accesos_logs (idAccesoLog, idUsuario, idArea, tipoAcesso)
VALUES (NULL, (SELECT idUsuario FROM usuario WHERE tagNFC = '$uid'), '$Area', 'Entrada');";

if ($conn->query($sql) === TRUE) {
    
    echo "Nuevo registro creado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
