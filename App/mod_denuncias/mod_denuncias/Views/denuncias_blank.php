<?php 
 include("../../config/config.php");
 ?>
<!doctype html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?=$base_url;?>public_html/css/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?=$base_url;?>public_html/css/mensajes.css"/>
    <title></title>
</head>
<body>
    <div class='principal'>
        <article id='contenedor_mensajes'>
            <div class="container-fluid">
        	   <div class="row">
                    <div class="col-md-3">
    		          <img src='<?=$base_url;?>public_html/imagenes/Info_Icon.png' class="img-responsive">
                    </div>
                    <div class="col-md9">
                	   <span>
                    	   <span><P>Este Ciudadano no posee denuncias registradas.</P><br> </span>
                        </span>
    				    <input type='button' class='boton' value='Aceptar' onClick=regresar();>
                    </div>
                </div>
            </div>     
        </article>
    </div>
</body>
</html> 