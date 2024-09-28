<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Areas</title>
    <link rel="stylesheet" href="../../css/es.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body id="page-top">

<form action="../../includes/_functions.php" method="POST">

<div class="container is-fluid">
        <br> 

        <div id="login">
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <br>
                            <br>
                            <h3 class="text-center">Registro de Areas</h3>
                            <div class="form-group">
                                <label for="nombreArea" class="form-label">Nombre Area*</label>
                                <input type="text" id="nombreArea" name="nombreArea" class="form-control" value="" required>
                                <input type="hidden" name="accion" value="agregar_area">
                                <input type="hidden" name="idAreas" value="">
                            </div>

                            <br>

                            <div class="mb-3">
                                <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                                <a href="../adminAreas.php" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>
</html>
