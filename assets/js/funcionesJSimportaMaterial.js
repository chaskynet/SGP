$(document).ready(function () 
{

$( "#form_importar" ).dialog(
  {
     autoOpen: false,
     height: 250,
     width: 350,
     modal: true,
     buttons:
      {
        "Cargar Articulos": function(){
        	var archivo = $("#archivo_subido").text();
        	// if ($(archivo).length < 1){
        	// 	alert("Debe seleccionar un archivo!");
        	// }
        	// else{
	        	$.ajax({
			        url: 'importarMateriales',
			        data: {data: archivo},
			        type: "POST",
			        dataType: "html",
			        error: function()
			        {
			            alert('Error al procesar el archivo!');
			        },
			        success: function(response)
			        {
			          //dialog.dialog( "close" );
			          location.reload('iframeRegMateriales');
			        }
			    });
        	//}

        }
       }
   });
});

$(document).on('click', '#fimportar', function(){
	$( "#form_importar" ).dialog( "open" );	
});

$(function() {
	$('#upload_file').submit(function(e) {
		e.preventDefault();
		$.ajaxFileUpload({
			url 			:'upload_file', 
			secureuri		:false,
			fileElementId	:'userfile',
			dataType		: 'json',
			data			: {
				'title'				: $('#title').val()
			},
			success	: function (data, status)
			{
				if(data.status != 'error')
				{
					alert(data.msg);
					$("#archivo_subido").text(data.archivo);
				}
				else{
					alert("error al subir el archivo");
				}
				
			}
		});
		return false;
	});
});