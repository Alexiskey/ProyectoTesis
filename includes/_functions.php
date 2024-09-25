<?php
require_once ("_db.php");

if (isset($_POST['accion'])){ 
    switch ($_POST['accion']){
        //casos de registros
        case 'editar_registro':
            editar_registro();
            break; 

        case 'eliminar_registro';
            eliminar_registro();
            break;

        case 'editar_Area':
            editar_Area();
            break; 

        case 'agregar_area':
            agregar_area();
            break; 

        case 'eliminar_area';
            eliminar_area();
            break;
        case 'acceso_user';
            acceso_user();
            break;
		}

	}

function editar_registro() {
    $conexion=mysqli_connect("localhost","root","","ingresos_rfid");
    extract($_POST);
    $consulta="UPDATE usuario SET NombreUsuario = '$NombreUsuario', Apellido1Usuario = '$Apellido1Usuario', Apellido2Usuario = '$Apellido2Usuario' , 
    rut = '$rut' , idRol = '$idRol' , tagNFC = '$tagNFC'  WHERE idUsuario = '$idUsuario' ";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/user.php');
}

function eliminar_registro() {
    $conexion=mysqli_connect("localhost","root","","ingresos_rfid");
    extract($_POST);
    $idUsuario= $_POST['idUsuario'];
    $consulta= "DELETE FROM usuario WHERE idUsuario = $idUsuario";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/user.php');

}

function editar_Area() {
    $conexion=mysqli_connect("localhost","root","","ingresos_rfid");
    extract($_POST);
    $consulta="UPDATE areas SET nombreArea = '$nombreArea'WHERE idAreas = '$idAreas' ";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/adminAreas.php');
}

function agregar_area() {
    $conexion=mysqli_connect("localhost","root","","ingresos_rfid");
    extract($_POST);
    $consulta="INSERT INTO areas (idAreas, nombreArea) VALUES (NULL, '$nombreArea');";
    mysqli_query($conexion, $consulta);
    mysqli_close($conexion);
    header('Location: ../views/adminAreas.php'); 
}

function eliminar_area() {
    $conexion=mysqli_connect("localhost","root","","ingresos_rfid");
    extract($_POST);
    $idAreas= $_POST['idAreas'];
    $consulta= "DELETE FROM areas WHERE idAreas = $idAreas";
    mysqli_query($conexion, $consulta);
    header('Location: ../views/adminAreas.php');
}

function acceso_user() {
    $nombre=$_POST['nombre'];
    $password=$_POST['password'];
    session_start();
    $_SESSION['nombre']=$nombre;

    $conexion=mysqli_connect("localhost","root","","r_user");
    $consulta= "SELECT * FROM user WHERE nombre='$nombre' AND password='$password'";
    $resultado=mysqli_query($conexion, $consulta);
    $filas=mysqli_num_rows($resultado);

    if($filas){

        header('Location: ../views/user.php');

    }else{

        header('Location: ../views/login.php');
        session_destroy();

    }

  
}
?>





