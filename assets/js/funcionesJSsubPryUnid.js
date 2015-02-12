$(document).ready(function () 
{
 // carga_proyecto_subproyecto();
  cargar_proyectos();

  //---- carga Articulos ---
  $( "#buscaArticulos" ).dialog(
  {
     autoOpen: false,
     height: 490,
     width: 430,
     modal: true,
     buttons:
      {
        "Cargar Articulos": function()
        {
          var tamcheck = $( "input:checkbox:checked" ).length;
          $( "input[name='articulo[]']:checked").each(function()
            {
              //var id = $(this).attr("id");
              var cadena = '<tr>'
                              +'<td id="codigo_fab">'
                                +$(this).attr('id')
                              +'</td>'
                              +'<td id="desc_item">'
                                +$(this).attr('value')
                              +'</td>'
                             
                              +'<td id="unidad">'
                                +'-'
                              +'</td>'
                              +'<td id="cantidad">'
                              +'0'
                              +'</td><td>'
                              +'<input type="text" id="retirado" size="5" value="0">'
                              +'</td><td>'
                              +'<input type="text" id="usado" size="5" value="0">'
                              +'</td><td>'
                              +'<input type="text" id="nuevo" size="5" value="0">'
                              +'</td>'
                            +'</tr>';
              $("#cuerpo_tabla_unid tbody").append(cadena);

            });
          if (tamcheck>0){
              $( this ).dialog( "close" );
              $("#tabla_articulos").empty();
              $("#busqueda").val('');
          }
          else{
              alert('Debe seleccionar un articulo');
          }
        }
      }
  });
});

$(document).on('click','#btn_busca_articulos',function(){
    $("#tabla_articulos").empty();
    $("#busqueda").val('');
    $( "#buscaArticulos" ).dialog( "open" );
    var consulta;

    $("#busqueda").focus();
    $("#busqueda").keyup(function(e)
    {
      var i = 0
      if(e.which == 13)
      {
        i++;
        i++;
        var fuente = $('input:radio[name=fuente]:checked').val();
        
        consulta = $("#busqueda").val();
        if (fuente === 'materiales') {
          var url = "buscaMateriales";  
        }else{
          var url = "buscaManoObra";
        }
        //hace la búsqueda
        $.ajax({
            url: url,
            data: {data: consulta},
            type: "POST",
            dataType: "html",
            error: function()
            {
                $("#tabla_articulos").empty();
                $("#tabla_articulos").html('no hay resultados');
            },
            success: function(response)
            {
              $("#tabla_articulos").find("tbody").empty();
              $('#tabla_articulos').html(response);
            }
        });

      }
    });
  
});
//---- Elimina Elmentos --------  
$(document).on('click','#elimina_prod',function(){
  var objFila=$(this).parents().get(1);
  $(objFila).remove();

});

//---- Guardar Elementos de la Unidad para un Sub Proyecto-------
$(document).on('click', '#actualizar', function(){
  //var cabecera = [];
  
  var lista_proySubproy = new Array();
  
  var codigo_proyecto = $('#codigo_proyecto').val();
  var codigo_subproyecto = $('#codigo_subproyecto').val();
  var cod_unidad = $('#unidades').val();
  var desc_unidad = $('#tipo_unidad').text();
  var avance = $('#avg_avance').val();
  var motivo = $('#motivo').val();
  $("#cuerpo_tabla_unid tbody tr").each(function(){
    var proySubproy = new Object();

    proySubproy.codigo_proyecto = codigo_proyecto;
    proySubproy.codigo_subproyecto = codigo_subproyecto;
    proySubproy.codigo_unidad = cod_unidad;
    proySubproy.dec_unidad = desc_unidad;
    proySubproy.avance = avance;
    proySubproy.motivo = motivo;

    proySubproy.codigo_fab = $(this).find('#codigo_fab').text();
    proySubproy.descripcion = $(this).find('#desc_item').text();
    proySubproy.unidad = $(this).find('#unidad').text(); 
    proySubproy.cantidad = $(this).find('#cantidad').text();
    proySubproy.retirado = $(this).find('#retirado').val();
    proySubproy.usado = $(this).find('#usado').val();
    proySubproy.nuevo = $(this).find('#nuevo').val();
    
    lista_proySubproy.push(proySubproy);
  });
  
  var newObj2 = JSON.stringify(lista_proySubproy);
  
  $.ajax({
        url: 'actualiza_proyecto_subproyecto',
        data: {data2: newObj2},
        type: "POST",
        dataType: "html",
        error: function()
        {
            alert('Error al Guardar!');
        },
        success: function(response)
        {
          //alert(response);
          alert('El Proyecto-SubProyecto se Actualizo correctamente!');
          // $('#codigo_proyecto').val('');
          // $('#codigo_subproyecto').val('');
          // $('#unidades').val('');
          //$('#cuerpo_tabla_unid tbody').empty();
          
        }
    });
});
//-----------------------------------

var cargar_proyectos = function(){
  $.ajax({
    url: 'carga_cod_proyectos_unid',
          //data: {data: newObj},
          type: "POST",
          dataType: "html",
          error: function()
          {
              alert('Error al cargar Proyectos!');
          },
          success: function(response)
          {
            $('#codigo_proyecto').append(response);
            
          }
  });
}

$(document).on('change', '#codigo_proyecto', function(){
  var $tmp = $(this).val();
  //$('#codigo_subproyecto').html("<option></option>");
  //alert($(this).val().length+'--'+$tmp.length);
  if($tmp.length < 1 ){
    alert("Elija un proyecto");
    $('#list_codigo_subproyecto').empty();
  }
  else{
    $.ajax({
      url: 'calcula_sub_proyectos_unid',
            data: {data: $tmp},
            type: "POST",
            dataType: "html",
            error: function()
            {
                alert('Error al calcular Sub Proyectos!');
            },
            success: function(response)
            {
              $('#codigo_subproyecto').val('');
              $('#codigo_subproyecto').html('<option></option>');
              //$('#cuerpo_tabla_proySubproy tbody').empty();
              $('#codigo_subproyecto').append(response);
              
            }
    });
  }
});

$(document).on('change', '#codigo_subproyecto', function(){
  proyecto = $("#codigo_proyecto").val();
  subproyecto = $(this).val();
  
  proySubproy = new Object();
  proySubproy.proyecto = proyecto;
  proySubproy.subproyecto = subproyecto;
  proySubproy1 = JSON.stringify(proySubproy);
  $.ajax({
      url: 'trae_unidades_por_subproyecto',
            data: {data: proySubproy1},
            type: "POST",
            dataType: "html",
            error: function()
            {
                alert('Error al traer las Unidades!');
            },
            success: function(response)
            {
              //alert(response);
              $('#unidades').val('');
              $('#unidades').html('<option></option>');
              //$('#cuerpo_tabla_proySubproy tbody').empty();
              $('#unidades').append(response);
              
            }
    });
});

$(document).on('change', '#unidades', function(){
  unidad = $(this).val();
  $.ajax({
      url: 'trae_titulo_tipo_unidad',
            data: {data: unidad},
            type: "POST",
            dataType: "html",
            error: function()
            {
                alert('Error al traer las Unidades!');
            },
            success: function(response)
            {
              //alert(response);
              
              $('#tipo_unidad').empty();
              $('#tipo_unidad').append(response);
            }
    });
    proySubproy2 = new Object();
    proySubproy2.unidad = unidad;
    proySubproy2.proyecto = proyecto;
    proySubproy2.subproyecto = subproyecto;

    proySubproy2 = JSON.stringify(proySubproy2);
  $.ajax({
      
      url: 'trae_elementos_por_unidad',
            //data: {data: unidad},
            data: {data: proySubproy2},
            type: "POST",
            dataType: "html",
            error: function()
            {
                alert('Error al traer las Unidades!');
            },
            success: function(response)
            {
              //alert(response);
              $('#cuerpo_tabla_unid tbody').empty();
              $('#cuerpo_tabla_unid tbody').append(response);
              
            }
    });
  
  $.ajax({
      url: 'trae_imagen_de_unidad',
            data: {data: unidad},
            type: "POST",
            dataType: "html",
            error: function()
            {
                alert('Error al traer las Unidades!');
            },
            success: function(response)
            {
              //alert(response);
              $('#imagen_unidad').empty();
              $('#imagen_unidad').html(response);
            }
    });
});

$(document).on('click', '#proysubproy', function(){
  
  tmp = $(this).text();
  // $('#codigo_proyecto').empty();
  // $('#codigo_subproyecto').empty();
  $.ajax({
      url: 'trae_proysubproy',
            data: {dato: tmp},
            type: "POST",
            dataType: "html",
            error: function()
            {
                alert('Error al calcular Sub Proyectos!');
            },
            success: function(response)
            {
              var obj = $.parseJSON(response);
              $.each(obj, function(index,valor)
                {
                     $("#codigo_proyecto").val(valor.id_proyecto);
                     $("#codigo_subproyecto").val(valor.id_sub_proyecto);
                });
            }
    });

  //------ Trae las unidades asociadas ----//
  $.ajax({
      url: 'trae_unidades_asociadas',
            data: {dato: tmp},
            type: "POST",
            dataType: "html",
            error: function()
            {
                alert('Error al calcular Sub Proyectos!');
            },
            success: function(response)
            {
              $("#cuerpo_tabla_proySubproy tbody").html(response);
            }
    });
});

//------------ Para Calculos ----------------/
$(document).on('change', '#retirado', function(){
  var obj = $(this).parents().get(1);
  var cantidad = $(obj).find('#cantidad');
  var operacion = parseInt($(cantidad).text()) + parseInt($(this).val());
  $(cantidad).text(operacion);
});

$(document).on('change', '#usado', function(){
  var obj = $(this).parents().get(1);
  var cantidad = $(obj).find('#cantidad');
  var operacion = parseInt($(cantidad).text()) + parseInt($(this).val());
  $(cantidad).text(operacion);
});

$(document).on('change', '#nuevo', function(){
  var obj = $(this).parents().get(1);
  var cantidad = $(obj).find('#cantidad');
  var operacion = parseInt($(cantidad).text()) - parseInt($(this).val());
  $(cantidad).text(operacion);
});