<?php
// Este bloque PHP manejará las solicitudes POST desde AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = mysqli_connect("localhost", "root", "", "ingresos_rfid");

    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    if(isset($_POST['uid']) && isset($_POST['Area'])){
        $uid = trim($_POST['uid']);
        $area = trim($_POST['Area']);

        $consulta = "INSERT INTO accesos_logs (idAccesoLog, idUsuario, idArea, tipoAcesso)
        VALUES (NULL, (SELECT idUsuario FROM usuario WHERE TagNFC = '$uid'), '$area', 'Entrada');";

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