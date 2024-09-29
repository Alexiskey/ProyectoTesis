<?php
require_once("_db.php"); 

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        // Casos de registros
        case 'editar_registro':
            editar_registro();
            break;

        case 'eliminar_registro':
            eliminar_registro();
            break;

        case 'editar_Area':
            editar_Area();
            break;

        case 'agregar_area':
            agregar_area();
            break;

        case 'eliminar_area':
            eliminar_area();
            break;

        case 'acceso_user':
            acceso_user();
            break;

        case 'registrarUsuario':
            registrarUsuario();
            break;
    }
}

function editar_registro() {
    global $conexion; 
    extract($_POST);
    $consulta = "UPDATE usuario SET NombreUsuario = '$NombreUsuario', Apellido1Usuario = '$Apellido1Usuario', Apellido2Usuario = '$Apellido2Usuario', 
    rut = '$rut', idRol = '$rol', TagRFID = '$TagRFID' 
    WHERE idUsuario = '$idUsuario'";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/adminUser.php');
}

function eliminar_registro() {
    global $conexion; 
    extract($_POST);
    $idUsuario = $_POST['idUsuario'];
    $consulta = "DELETE FROM usuario WHERE idUsuario = $idUsuario";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/adminUser.php');
}

function editar_Area() {
    global $conexion; 
    extract($_POST);
    $consulta = "UPDATE areas SET nombreArea = '$nombreArea', permisosRoles = '$RolesPerm' WHERE idAreas = '$idAreas'";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/adminAreas.php');
}

function agregar_area() {
    global $conexion; 
    extract($_POST);
    $consulta = "INSERT INTO areas (idAreas, nombreArea) VALUES (NULL, '$nombreArea');";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/adminAreas.php'); 
}

function eliminar_area() {
    global $conexion; 
    extract($_POST);
    $idAreas = $_POST['idAreas'];
    $consulta = "DELETE FROM areas WHERE idAreas = $idAreas";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/adminAreas.php');
}

function acceso_user() {
    global $conexion; 
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    session_start();
    $_SESSION['nombre'] = $nombre;

    $consulta = "SELECT * FROM user WHERE nombre='$nombre' AND password='$password'";
    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_num_rows($resultado);

    if ($filas) {
        header('Location: ../views/adminUser.php');
    } else {
        header('Location: ../views/login.php');
        session_destroy();
    }
} 

function registrarUsuario() {
    global $conexion; 

    if (strlen($_POST['nombre']) >= 1 && strlen($_POST['Apellido1']) >= 1 && strlen($_POST['rol']) >= 1 
        && strlen($_POST['Rut']) >= 1 && strlen($_POST['TagRFID']) >= 1) {

        $NombreUsuario = trim($_POST['nombre']);
        $Apellido1Usuario = trim($_POST['Apellido1']);
        $Apellido2Usuario = trim($_POST['Apellido2']);
        $Rut = trim($_POST['Rut']);
        $rol = trim($_POST['rol']);
        $TagRFID = trim($_POST['TagRFID']);

        $consulta = "INSERT INTO `usuario` ( `NombreUsuario`, `Apellido1Usuario`, `Apellido2Usuario`, `idRol`, `TagRFID`, `rut`) 
        VALUES ('$NombreUsuario', '$Apellido1Usuario', '$Apellido2Usuario', '$rol', '$TagRFID', '$Rut')";
        mysqli_query($conexion, $consulta);

        header('Location: ../views/adminUser.php');
    }
}
?>
