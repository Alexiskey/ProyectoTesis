
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-5">
    <div class="row">
    <div class="col-sm-6 offset-sm-3">
    <div class="alert alert-danger text-center">
    <p>¿Desea confirmar la eliminacion de esta area?</p>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <form action="../includes/_functions.php" method="POST">
                <input type="hidden" name="accion" value="eliminar_area">
                <input type="hidden" name="idAreas" value="<?php echo $_GET['idAreas']; ?>">
                <input type="submit" name="" value="Eliminar" class= "btn btn-danger">
                <a href="adminAreas.php" class="btn btn-success">Cancelar</a>                     
        </div>
    </div>



</body>
</html>