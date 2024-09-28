
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Area</title>
    <link rel="stylesheet" href="../../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../css/styles.css">
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
            <form action="../../includes/_functions.php" method="POST">
                <input type="hidden" name="accion" value="eliminar_area">
                <input type="hidden" name="idAreas" value="<?php echo $_GET['idAreas']; ?>">
                <input type="submit" name="" value="Eliminar" class= "btn btn-danger">
                <a href="../adminAreas.php" class="btn btn-success">Cancelar</a>      
            </form>               
        </div>
    </div>



</body>
</html>