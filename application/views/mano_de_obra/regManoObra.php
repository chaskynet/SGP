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
	<script src="../assets/js/funcionesJSimportaManoObra.js"></script>
	<script src="../assets/js/AjaxFileUploader/ajaxfileupload.js"></script>
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
<div><h1>Registro de Mano de Obra</h1><a href="#" id="fimportar">Importar desde archivo Excel</a></div></div>
<div>
		<?php echo $output; ?>
</div>
</body>
</html>