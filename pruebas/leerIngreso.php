<?php
require_once("_db.php"); 
global $conexion; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    if(isset($_POST['uid']) && isset($_POST['Area'])){
        $uid = trim($_POST['uid']);
        $area = trim($_POST['Area']);

        $consulta = "INSERT INTO accesos_logs (idAccesoLog, idUsuario, idArea, tipoAcesso)
        VALUES (NULL, (SELECT idUsuario FROM usuario WHERE TagRFID = '$uid'), '$area', 'Entrada');";

        mysqli_query($conexion, $consulta);
        mysqli_close($conexion);

        echo "Ingreso Exitoso.";
        //header('Location: ../views/user.php');
    } else {
        echo "Ingreso Fallido.";
        mysqli_close($conexion);
    }

}
?>