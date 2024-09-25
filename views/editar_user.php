<?php

$idUsuario = $_GET['idUsuario'];
$conexion = mysqli_connect("localhost", "root", "", "ingresos_rfid");
$consulta = "SELECT * FROM usuario WHERE idUsuario = $idUsuario ";
$resultado = mysqli_query($conexion, $consulta);
$usuario = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body id="page-top">

<form action="../includes/_functions.php" method="POST">
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <br>
                        <br>
                        <h3 class="text-center">Editar usuario</h3>

                        <div class="form-group">
                            <label for="NombreUsuario" class="form-label">Nombre *</label>
                            <input type="text" id="NombreUsuario" name="NombreUsuario" class="form-control" value="<?php echo $usuario['NombreUsuario']; ?>" required>
                        </div>	
                        <div class="form-group">
                            <label for="Apellido1Usuario" class="form-label">Apellido Paterno *</label>
                            <input type="text" id="Apellido1Usuario" name="Apellido1Usuario" class="form-control" value="<?php echo $usuario['Apellido1Usuario']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="Apellido2Usuario" class="form-label">Apellido Materno *</label>
                            <input type="text" id="Apellido2Usuario" name="Apellido2Usuario" class="form-control" value="<?php echo $usuario['Apellido2Usuario']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="rut" class="form-label">Rut *</label>
                            <input type="text" id="rut" name="rut" class="form-control" maxlength="11" oninput="formatRut(this)" value="<?php echo $usuario['rut']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="idRol" class="form-label">idRol*</label>
                            <input type="text" id="idRol" name="idRol" class="form-control" value="<?php echo $usuario['idRol']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="tagNFC" class="form-label">TagNFC *</label>
                            <input type="text" id="tagNFC" name="tagNFC" class="form-control" value="<?php echo $usuario['tagNFC']; ?>" required>
                            <input type="hidden" name="accion" value="editar_registro">
                            <input type="hidden" name="idUsuario" value="<?php echo $idUsuario ;?>">
                        </div>
                        
                        <br>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Editar</button>
                            <a href="./user.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function formatRut(input) {
        // Remove all non-digit characters
        let value = input.value.replace(/\D/g, '');
        
        // Apply the RUT format (xx.xxx.xxx-x)
        if (value.length > 1) {
            // Insert dots every 3 digits, except the last 2 digits
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        }
        
        // Insert the dash before the last digit
        if (value.length > 1) {
            value = value.replace(/(\d+)(\d{1})$/, '$1-$2');
        }
        
        // Set the formatted value to the input
        input.value = value;
    }
</script>

</body>
</html>
