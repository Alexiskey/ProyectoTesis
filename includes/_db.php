<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "ingresos_rfid";

$conexion = mysqli_connect($host, $user, $password, $database);
if(!$conexion){
    die("No se realizó la conexión a la base de datos. El error fue: " . mysqli_connect_error());
}
?>
