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
<script type="text/javascript"> 
// $(document).on('change','#field-fecha_inicio', function(){
// 	var tipo = $('#field-tipo_proyecto');
//   var localiza = $('#field-localizacion');
//   var fecha_ini = $('#field-fecha_inicio');

//   if ($(tipo).val().length < 1) {
//     alert('Tipo de Proyecto esta vacio');
//   }
//   else if ($(localiza).val().length < 1) {
//     alert('la Localizacion esta vacia');
//   }
//   else{
//     var objeto = new Object();
//     objeto.tipo = $(tipo).val();
//     objeto.localiza = $(localiza).val();
//     objeto.fecha_ini = $(fecha_ini).val();

//     var newObj = JSON.stringify(objeto);
//     $.ajax({
//        url: 'dias_por_tipo',
//        data: {data: newObj},
//        type: "POST",
//        //dataType: "html",
//        success: function(data)
//        {
//        		alert(data);
//          //$('#field-fecha_fin').val(response);
//          //$('#guardar').attr('disabled',false);
//        }
//     });
//   }

// })
</script>
<body>
<div>
	<?php echo $output; ?>
</div>
</body>
</html>