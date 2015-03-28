<!DOCTYPE html>
<html lang="es">
<head>

<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php 
endforeach;
 foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/popup.css" />
	<script src="<?php echo base_url(); ?>assets/js/AjaxFileUploader/ajaxfileupload.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/funcionesJSimportarUnidades.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	  	$('.tDiv3').append('<a id="fimportar" href="#">'+
	  							'<div class="fbutton">'+
	  								'<div>'+
	  									'<span>Importar desde Excel</span>'+
	  								'</div>'+
	  							'</div>'+
	  						'</a>'+
	  						'<div class="btnseparator"></div>'+
	  						'<a id="fplantilla_unidades" href="<?php echo base_url();?>assets/plantillas/plantilla_unidades.xls">'+
	  							'<div class="fbutton">'+
	  								'<div>'+
	  									'<span>Plantilla Excel</span>'+
	  								'</div>'+
	  							'</div>'+
	  						'</a>');
	});
	</script>
</head>
<body>
<div id="form_importar">
		<form method="post" action="" id="upload_file">

		    <label for="userfile">Archivo: </label>
		    <input type="file" name="userfile" id="userfile" size="20" />
			<br>
			<br>
		    <input type="submit" name="submit" id="submit" value="Subir Archivo" />
    	</form>
    	<label for="archivo_subido">Archivo Subido: </label>
		<span id="archivo_subido"></span>
	</div>
<h1>Registro de Unidades</h1><!--a href="#" id="fimportar">Importar desde archivo Excel</a-->
<div>
	<?php echo $output; ?>
</div>
</body>
</html>