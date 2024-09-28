<?php
require_once("../../includes/_db.php"); 
global $conexion; 
$idUsuario = $_GET['idUsuario'];
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
    <link rel="stylesheet" href="../../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .input-group {
            display: flex; /* Utiliza flexbox para alinear horizontalmente */
            align-items: center; /* Centra verticalmente los elementos */
        }
        .input-group input {
            flex: 1; /* Hace que el input ocupe el espacio disponible */
            margin-right: 10px; /* Espacio entre el input y el botón */
        }
    </style>
</head>

<body id="page-top">

<form action="../../includes/_functions.php" method="POST">
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <br>
                        <h3 class="text-center">Editar usuario</h3>
                        <div class="form-group">
                            <label for="idUsuario" class="form-label">id Usuario: <?php echo $idUsuario; ?></label>
                            <input type="hidden" name="accion" value="editar_registro"> 
                            <input type="hidden" id="idUsuario" name="idUsuario" class="form-control" readonly value="<?php echo $idUsuario; ?>">

                        </div>

                        <div class="form-group">
                            <label for="NombreUsuario" class="form-label">Nombre *</label>
                            <input type="text" id="NombreUsuario" name="NombreUsuario" class="form-control" value="<?php echo $usuario['NombreUsuario']; ?>" required>
                        </div>	
                        <div class="form-group">
                            <label for="Apellido1Usuario" class="form-label">Apellido Paterno *</label>
                            <input type="text" id="Apellido1Usuario" name="Apellido1Usuario" class="form-control" value="<?php echo $usuario['Apellido1Usuario']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="Apellido2Usuario" class="form-label">Apellido Materno</label>
                            <input type="text" id="Apellido2Usuario" name="Apellido2Usuario" class="form-control" value="<?php echo $usuario['Apellido2Usuario']; ?>" >
                        </div>

                        <div class="form-group">
                            <label for="rut" class="form-label">Rut *</label>
                            <input type="text" id="rut" name="rut" class="form-control" maxlength="11" oninput="formatRut(this)" value="<?php echo $usuario['rut']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="rol" class="form-label">Rol de Empleado *</label>
                            <select id="rol" name="rol" class="form-control" required>
                                <?php
                                    global $conexion;

                                    // Consulta para obtener los IDs y nombres de los roles
                                    $SQL = "SELECT roles.idRol, roles.nombreRol 
                                            FROM roles"; // Obtener id y nombre de los roles
                                    $roles = mysqli_query($conexion, $SQL);

                                    if ($roles->num_rows > 0) {
                                        while ($rolrow = mysqli_fetch_assoc($roles)) {
                                            $selected = ($rolrow['idRol'] == $usuario['idRol']) ? 'selected' : '';
                                            echo '<option value="' . $rolrow['idRol'] . '" ' . $selected . '>' . $rolrow['nombreRol'] . '</option>';
                                        
                                        }
                                    }
                                ?>
                            </select>

                        </div>  
                        <div class="form-group">
                            <label for="TagRFID" class="form-label">TagRFID *</label>
                            <div class="input-group">
                                <input type="text" id="TagRFID" name="TagRFID" class="form-control" readonly value="<?php echo $usuario['TagRFID']; ?>"> 
                                <button type="button" id="toggleReading" class="btn btn-info">Activar Lectura</button>
                            </div>
                        </div>

                        <br>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Editar</button>
                            <a href="../adminUser.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let lecturaActiva = false; // Flag para controlar el estado de la lectura
    let intervaloLectura; // Variable para almacenar el intervalo

    function formatRut(input) {
        let value = input.value.replace(/[^0-9kK]/g, ''); // Elimina caracteres no numéricos

        // Separa los primeros 8 dígitos y el dígito verificador
        const primerosNumeros = value.slice(0, 8); // Primeros 8 números
        const ultimoNumero = value.slice(8); // Último número
        
        // Aplica el formato xx.xxx.xxx
        const formattedRut = primerosNumeros.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'); // Agrega puntos cada 3 dígitos
        
        // Combina los números formateados con el dígito verificador
        input.value = `${formattedRut}${ultimoNumero ? '-' + ultimoNumero : ''}`; 
    }

    // Función para actualizar el TagRFID
    function actualizarTagRFID() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../../includes/lecturaTxt.php', true); // Cambia la ruta según sea necesario
        xhr.onload = function() {
            if (xhr.status === 200) {
                const primeraLinea = xhr.responseText.trim(); // Obtiene la primera línea
                document.getElementById('TagRFID').value = primeraLinea; // Actualiza el campo TagRFID
            } else {
                console.error("Error al leer el archivo: " + xhr.status);
            }
        };
        xhr.send();
    }

    // Función para activar/desactivar la lectura
    document.getElementById('toggleReading').onclick = function() {
        lecturaActiva = !lecturaActiva; // Cambia el estado de la lectura
        this.textContent = lecturaActiva ? 'Desactivar Lectura' : 'Activar Lectura'; // Cambia el texto del botón

        if (lecturaActiva) {
            // Iniciar la lectura
            intervaloLectura = setInterval(actualizarTagRFID, 2000); // Actualiza cada 2 segundos
        } else {
            // Detener la lectura
            clearInterval(intervaloLectura);
            // Enviar una solicitud POST para actualizar el contenido de lectura.txt
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../../includes/lecturaTxt.php", true); // Llama al archivo lecturaTxt.php
            xhr.send();
        }
    };
</script>

</body>
</html>
