<!DOCTYPE html>
<html lang="es">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php 
endforeach;
 foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<body>
<div><h1>Registro de Naturaleza de Proyecto</h1></div>
<div>
		<?php echo $output; ?>
</div>
</body>
</html>