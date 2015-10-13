<!DOCTYPE html>
<html lang="ES">
<head>
	<meta charset="utf-8">
    <title>Denuncias</title>
  <link rel="stylesheet" type="text/css" href="../../../public_html/css/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../../../public_html/css/visualizerut.css"/>
  <link href="../../../resources/jquery.confirm/jquery.confirm/jquery.confirm.css" rel="stylesheet" />
</head>
<body>
<div class="principal">
<!--<img class='imgsuperior' src='../../../public_html/imagenes/search.png'/>-->
<!--<section class='container'>-->
    
    <h3>RESULTADOS DE LA BUSQUEDA</h3><br>
    <article class='personaldata'>
        <span>Cédula: <?=$cedula?></span>
        <span>Nombre: <?=$nombre." ".$apellido?></span>
    </article>
    <h4>Denuncias Registradas</h4>
    <form name='details' id='details' action='Controller.Denuncia.php' method='post'>
    <input type="hidden" name="id" value="" id="id" />
    <input type="hidden" name="option" value="" id="option" />
    <table class='table table-bordered table-hover'>
      <thead>
        <tr>
          <th class="text-center">NÚMERO DENUNCIA</th>
          <th class="text-center">FECHA</th>
          <th class="text-center">ESTATUS</th>
          <th colspan="3"  class="text-center">OPCIONES</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($den as $key){?>
           <tr>
              <td><?=$key->__GET('id_denuncia')?></td>
              <td><?=$key->__GET('fecha_denuncia')?></td>
              <td><?=$sts[$key->__GET('estatus_denuncia')]?></td>
              <td><input type="submit" id="<?=$key->__GET('id_denuncia')?>" value="Detalles" class='submit detailsden' /></td>
              <td><input type="submit" id="<?=$key->__GET('id_denuncia')?>" value="Editar" class='submit updateden' /></td>
              <td><input type="button" id="<?=$key->__GET('id_denuncia')?>" value="Eliminar" class='submit eliminar'/></td>
           </tr>
      <?Php }?>
      </tbody>
   </table>
   </form>
   <input type='button' class='boton' value='Aceptar' onClick='regresar();'>
   <script type="text/jscript" src="../../../public_html/js/jquery-2.1.4.min.js"></script>
   <script type="text/javascript" src="../../../public_html/js/enviar.js"></script>
   <script type="text/javascript" src="../../../resources/jquery.confirm/jquery.confirm/jquery.confirm.js"></script>
  <script type="text/javascript" src="../../../resources/jquery.confirm/js/script.js"></script>
   <script type='text/javascript'>
      function regresar()
      {
          var pagina = 'mod_denuncias/denuncias.php';
          location.href=pagina
      }
  </script>
   </section>
 </div>
 </body>
 </html>
  
  