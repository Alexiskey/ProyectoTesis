<?php
require_once("../../includes/_db.php"); 
global $conexion; 
$idAreas = $_GET['idAreas'];
$consulta = "SELECT * FROM areas WHERE idAreas = $idAreas";
$resultado = mysqli_query($conexion, $consulta);
$area = mysqli_fetch_assoc($resultado);

// Obtener los roles ya asignados (permisosRoles) y convertirlos en un array usando "/" como separador
$rolesAsignados = array_map('trim', explode("/", $area['permisosRoles']));

// Obtener todos los roles de la tabla 'roles'
$consulta_roles = "SELECT * FROM roles";
$resultado_roles = mysqli_query($conexion, $consulta_roles);
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Area</title>
    <link rel="stylesheet" href="../../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../css/styles.css">
</head>

<body id="page-top">

<form action="../../includes/_functions.php" method="POST">
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <br>
                        <br>
                        <h3 class="text-center">Editar Area</h3>

                        <div class="form-group">
                            <label for="nombreArea" class="form-label">Nombre Area*</label>
                            <input type="text" id="nombreArea" name="nombreArea" class="form-control" value="<?php echo $area['nombreArea']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="RolesPerm" class="form-label">Roles Permitidos*</label>
                            <input type="text" id="RolesPerm" name="RolesPerm" class="form-control" value="<?php echo implode("/", $rolesAsignados); ?>" readonly>
                        </div>

                        <!-- Botón para mostrar/ocultar lista de roles -->
                        <div class="form-group">
                            <label for="addRole" class="form-label">Añadir/Eliminar Roles</label>
                            <button type="button" class="btn btn-info" onclick="mostrarRoles()">Añadir/Eliminar Roles</button>
                        </div>

                        <!-- Lista de roles -->
                        <div id="listaRoles" style="display: none;">
                            <h5>Selecciona los roles que deseas agregar o eliminar:</h5>
                            <ul>
                                <?php while($row = mysqli_fetch_assoc($resultado_roles)): ?>
                                    <li>
                                        <input type="checkbox" name="roles[]" value="<?php echo $row['nombreRol']; ?>"
                                        <?php echo (in_array(trim($row['nombreRol']), $rolesAsignados)) ? 'checked' : ''; ?>
                                        onchange="actualizarRolesPerm()"> 
                                        <?php echo $row['nombreRol']; ?>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>

                        <br>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Editar</button>
                            <input type="hidden" name="accion" value="editar_Area">
                            <input type="hidden" name="idAreas" value="<?php echo $idAreas ;?>">
                            <a href="../adminAreas.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function mostrarRoles() {
    var listaRoles = document.getElementById('listaRoles');
    listaRoles.style.display = (listaRoles.style.display === 'none') ? 'block' : 'none';
}

function actualizarRolesPerm() {
    // Obtener todos los checkboxes de roles
    var checkboxes = document.querySelectorAll('input[name="roles[]"]:checked');
    var rolesSeleccionados = [];
    
    // Añadir los valores de los checkboxes seleccionados al array
    checkboxes.forEach(function(checkbox) {
        rolesSeleccionados.push(checkbox.value);
    });
    
    // Actualizar el campo RolesPerm con los roles seleccionados separados por "/"
    document.getElementById('RolesPerm').value = rolesSeleccionados.join('/');
}
</script>

</body>
</html>
