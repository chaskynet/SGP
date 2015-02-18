<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="../css/estilos.css" />
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php 
endforeach;
 foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<script type="text/javascript">
	

	$(document).on('change', '#field-fecha_inicio', function(){
		// $.get('prueba', {dato:tipo_proyecto}, function(data, status){
		// 	alert("Data: " + data + "\nStatus: " + status);
		// });
		var objeto = new Object();
		objeto.tipo = $('#field-tipo_proyecto').val();
		objeto.localiza = $('#field-localizacion').val();
		objeto.fecha_ini = $(this).val();
		var newobjeto = JSON.stringify(objeto);
		$.ajax({
			url: '<?php echo base_url()?>main/dias_por_tipo',
			   data: {data:newobjeto},
			   type: "POST",
			   //dataType: "html",
			   //global: false,
			   success: function(response)
			   {
			     //alert(response);
			     $('#field-fecha_fin').val(response);
			   }
		});
	});
</script>
</head>
<body>
<div>
	<h1>Creacion/Actualizacion de Proyectos</h1>
	<?php echo $output; ?>
</div>
</body>
</html>