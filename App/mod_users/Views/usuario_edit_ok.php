<?/*?>
<!doctype html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../../public_html/css/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../../../public_html/css/mensajes.css"/>
    <title></title>
</head>
<body>
    <div class='principal'>
        <article id='contenedor_mensajes'>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <img src='../../../public_html/imagenes/Info_Icon.png' class="img-responsive">
                    </div>
                    <div class="col-md9">
                        <span>
                            <p>Usuario editado correctamente!.</p>
                        </span>
                        <input type='button' class='boton' value='Aceptar' onClick="window.location='../users.php?listuser=1'";>
                    </div>
                </div>
            </div>     
        </article>
    </div>
</body>
</html>
<?*/?>
<?php header('Location: ../users.php?editOk=Usuario editado satisfactoriamente!') ?>