<?php
$idAreas = $_GET['idAreas'];
$conexion = mysqli_connect("localhost", "root", "", "ingresos_rfid");
$consulta = "SELECT * FROM areas WHERE idAreas = $idAreas ";
$resultado = mysqli_query($conexion, $consulta);
$area = mysqli_fetch_assoc($resultado);
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
                        <h3 class="text-center">Editar Area</h3>

                        <div class="form-group">
                            <label for="nombreArea" class="form-label">Nombre Area*</label>
                            <input type="text" id="nombreArea" name="nombreArea" class="form-control" value="<?php echo $area['nombreArea']; ?>" required>
                            <input type="hidden" name="accion" value="editar_Area">
                            <input type="hidden" name="idAreas" value="<?php echo $idAreas ;?>">
                        </div>

                        <br>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Editar</button>
                            <a href="./adminArea.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>
</html>
