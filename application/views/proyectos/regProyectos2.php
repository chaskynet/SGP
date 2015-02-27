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
			     $('#field-fecha_fin').val(response);
			   }
		});
	});

	$(document).on('change', '#field-tipo_proyecto', function(){
		var objeto = new Object();
		objeto.tipo = $(this).val();
		objeto.localiza = $('#field-localizacion').val();
		objeto.fecha_ini = $('#field-fecha_inicio').val();
		var newobjeto = JSON.stringify(objeto);

		if ($('#field-fecha_fin').val().length > 0){
			$.ajax({
			url: '<?php echo base_url()?>main/dias_por_tipo',
			   data: {data:newobjeto},
			   type: "POST",
			   //dataType: "html",
			   //global: false,
			   success: function(response)
			   {
			     $('#field-fecha_fin').val(response);
			   }
			});
		}
	});

	$(document).on('change', '#field-localizacion', function(){
		var objeto = new Object();
		objeto.tipo = $('#field-tipo_proyecto').val();
		objeto.localiza = $(this).val();
		objeto.fecha_ini = $('#field-fecha_inicio').val();
		var newobjeto = JSON.stringify(objeto);

		if ($('#field-fecha_fin').val().length > 0){
			$.ajax({
			url: '<?php echo base_url()?>main/dias_por_tipo',
			   data: {data:newobjeto},
			   type: "POST",
			   //dataType: "html",
			   //global: false,
			   success: function(response)
			   {
			     $('#field-fecha_fin').val(response);
			   }
			});
		}
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