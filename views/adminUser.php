<!DOCTYPE html>
<html lang="en">    
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  <link rel="stylesheet" href="../css/fontawesome-all.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <title></title>
</head>

  <div class="container is-fluid">
    <br>
      <div class="container is-fluid">
        <br>
          <!-- Contenedor para los botones de navegación -->
          <div class="nav-buttons">
              <button onclick="window.location.href='informe.php'" class="btn btn-success">Informes</button>
              <button onclick="window.location.href='adminAreas.php'" class="btn btn-success">Administrar Areas</button>
          </div>
          <div class="col-xs-12">
          <h1>Administar usuarios</h1>
        <br>
          <div>
            <a class="btn btn-success" href="./subView/registrarUser.php">Nuevo usuario 
            </a>
          </div>
    <br>
    <br>
      </form>
        <table class="table table-striped table-dark " id= "table_id">
          <thead>    
            <tr>
              <th>idUsuario</th>
              <th>Nombre</th>
              <th>Apellido1</th>
              <th>Apellido2</th>
              <th>Rut</th>
              <th>TagRFID</th>
              <th>idRol</th>
              <th>status</th>
              <th>acciones</th>
            </tr>
          </thead>
        <tbody>
        
        <?php
          require_once("../includes/_db.php"); 
          global $conexion;               
          $SQL="SELECT usuario.idUsuario, usuario.NombreUsuario, usuario.Apellido1Usuario, usuario.rut, usuario.Apellido2Usuario, usuario.TagRFID, usuario.status, roles.nombreRol 
                FROM usuario
                LEFT JOIN roles ON usuario.idRol = roles.idRol";
          $dato = mysqli_query($conexion, $SQL);

          if($dato -> num_rows >0){
            while($fila=mysqli_fetch_array($dato)){   
              ?>
              <tr>
              <td><?php echo $fila['idUsuario']; ?></td>
              <td><?php echo $fila['NombreUsuario']; ?></td>
              <td><?php echo $fila['Apellido1Usuario']; ?></td>
              <td><?php echo $fila['Apellido2Usuario']; ?></td>
              <td><?php echo $fila['rut']; ?></td>
              <td><?php echo $fila['TagRFID']; ?></td>
              <td><?php echo $fila['nombreRol']; ?></td>
              <td><?php echo $fila['status']; ?></td>				
              <td>
                <a class="btn btn-warning" href="./subView/editar_user.php?idUsuario=<?php echo $fila['idUsuario']?> ">
                Editar </a>

                <a class="btn btn-danger" href="./subView/eliminar_user.php?idUsuario=<?php echo $fila['idUsuario']?>">
                Eliminar</a>  
              </td>
              </tr>
          <?php
              }
          }else{
            ?>
            <tr class="text-center">
            <td colspan="16">No existen registros</td>
            </tr>
            <?php 
          }
        ?>
    </body>
  </table>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
  <script src="../js/user.js"></script>
</html>