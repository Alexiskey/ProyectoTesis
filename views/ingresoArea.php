<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresos Usuarios</title>

    <link rel="stylesheet" href="../css/es.css">
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        .button-container {
            text-align: center;
            margin-bottom: 20px; /* Espacio entre los botones y la tabla */
        }

        .button-container button {
            margin: 0 10px; /* Espacio entre los botones */
        }
    </style>

</head>

<body id="page-top">

<div class="container is-fluid">
        <br>
        
        <!-- Contenedor para los botones de navegación -->
        <div class="nav-buttons">
            <button onclick="window.location.href='informe.php'" class="btn btn-success">Informes</button>
            <button onclick="window.location.href='adminUser.php'" class="btn btn-success">Usuarios</button>
            <button onclick="window.location.href='adminAreas.php'" class="btn btn-success">Administrar Areas</button>

        </div>

    <form action="../includes/valida_ingreso.php" method="POST">
        <div id="login">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <br>
                            <br>
                            <h3 class="text-center">Ingresos de los Usuarios</h3>
                            <label for="TagEmpleado" class="form-label">Tag Empleado *</label>
                            <input type="text" id="TagEmpleado" name="TagEmpleado" class="form-control" required>
                            <label for="Area" class="form-label">Area *</label>
                            <input type="number" id="Area" name="Area" class="form-control" required>
                            <br>

                            <div class="mb-3">
                                <input type="submit" value="Ingresar" class="btn btn-success" name="Ingresar">
                                <a href="#" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
