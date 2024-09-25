<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Administrar Áreas</title>
</head>

<div class="container is-fluid">
    <br>
    <!-- Contenedor para los botones de navegación -->
    <div class="nav-buttons">
        <button onclick="window.location.href='informe.php'" class="btn btn-success">Informes</button>
        <button onclick="window.location.href='user.php'" class="btn btn-success">Usuarios</button>
        <button onclick="window.location.href='ingresoArea.php'" class="btn btn-success">Ingresos Area</button>
        <button onclick="window.location.href='registro.php'" class="btn btn-success">Registrar</button>
    </div>
    <br>
    <h1>Lista de Áreas</h1>
    <br>
    <div>
        <a class="btn btn-success" href="./registrarArea.php">Nueva Área</a>
    </div>
    <br>
    <div class="table-container">
        <table class="table table-striped table-dark" id="table_id">
            <thead>    
                <tr>
                    <th>idÁrea</th>
                    <th>Nombre del Área</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conexion = mysqli_connect("localhost", "root", "", "ingresos_rfid");
                $SQL = "SELECT * FROM areas";
                $dato = mysqli_query($conexion, $SQL);

                if ($dato->num_rows > 0) {
                    while ($fila = mysqli_fetch_array($dato)) {
                ?>
                    <tr>
                        <td><?php echo $fila['idAreas']; ?></td>
                        <td><?php echo $fila['nombreArea']; ?></td>
                        <td>
                        <a class="btn btn-warning" href="../includes/editar_area.php?idAreas=<?php echo $fila['idAreas']?> "> Editar </a>
                        <a class="btn btn-danger" href="../includes/eliminar_area.php?idAreas=<?php echo $fila['idAreas']; ?>">Eliminar</a>
                        </td>  
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr class="text-center">
                        <td colspan="4">No existen registros</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="../js/areas.js"></script>
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        });
    </script>
</div>

</html>
