<?php
$conexion= mysqli_connect("localhost", "root", "", "ingresos_rfid");

if(isset($_POST['registrar'])){

    if(strlen($_POST['nombre']) >=1 && strlen($_POST['Apellido1'])  >=1 && strlen($_POST['rol'])  >=1 
    && strlen($_POST['Rut'])  >=1 && strlen($_POST['TagRFID'])  >=1){

      $NombreUsuario = trim($_POST['nombre']);
      $Apellido1Usuario = trim($_POST['Apellido1']);
      $Apellido2Usuario = trim($_POST['Apellido2']);
      $Rut = trim($_POST['Rut']);
      $rol = trim($_POST['rol']);
      $TagRFID = trim($_POST['TagRFID']);

      $consulta = "INSERT INTO `usuario` ( `NombreUsuario`, `Apellido1Usuario`, `Apellido2Usuario`, `idRol`, `TagRFID`, `rut`) 
      VALUES ( '$NombreUsuario', '$Apellido1Usuario', '$Apellido1Usuario', '$rol', '$TagRFID', '$Rut')";
      #$consulta =  "INSERT INTO `usuario` (`idUsuario`, `NombreUsuario`, `Apellido1Usuario`, `Apellido2Usuario`, `idRol`, `TagRFID`, `status`) 
      #VALUES (NULL, 'Valentina', 'Vega', NULL, '3', '7736346', NULL)";
      mysqli_query($conexion, $consulta);
      mysqli_close($conexion);

      header('Location: ../views/adminUser.php');
  }
}

?>