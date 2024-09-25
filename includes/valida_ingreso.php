<?php
$conexion= mysqli_connect("localhost", "root", "", "ingresos_rfid");

if(isset($_POST['Ingresar'])){

  if(strlen($_POST['TagEmpleado'])  >=1 && strlen($_POST['Area'])  >=1){

    $TagEmpleado = trim($_POST['TagEmpleado']);
    $area = trim($_POST['Area']);

    $consulta = "INSERT INTO accesos_logs (idAccesoLog, idUsuario, idArea, tipoAcesso)
    VALUES (NULL, (SELECT idUsuario FROM usuario WHERE TagNFC = '$TagEmpleado'), '$area', 'Entrada');";

    mysqli_query($conexion, $consulta);
    mysqli_close($conexion);

    header('Location: ../views/user.php');
  }
}

?>