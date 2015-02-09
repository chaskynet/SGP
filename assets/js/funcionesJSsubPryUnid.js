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
                              +'<td class="columna acciones">'
                              //+'<input type="hidden" id="id_fila" >'
                              +'<a href="#" id="elimina_prod" >Eliminar</a>'
                              +'</td>'
                              +'<td class="columna descripcion" id="codigo">'
                                +$(this).attr('id')
                              +'</td>'
                              +'<td class="columna descripcion" id="descripcion">'
                                +$(this).attr('value')
                              +'</td>'
                             
                              +'<td class="columna cantidad_cif">'
                                +'<input type="text" id="cantidad" class="cantidad_cif cantidad">'
                              +'</td>'
                              
                            +'</tr>';
              $("#cuerpo_tabla_proySubproy tbody").append(cadena);

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

//---- Guardar Unidad -------
$(document).on('click', '#guardar', function(){
  //var cabecera = [];
  
  var lista_proySubproy = new Array();
  
  var codigo_proyecto = $('#codigo_proyecto').val();
  var codigo_subproyecto = $('#codigo_subproyecto').val();

  $("#cuerpo_tabla_proySubproy tbody tr").each(function(){
    var proySubproy = new Object();

    proySubproy.codigo_proyecto = codigo_proyecto;
    proySubproy.codigo_subproyecto = codigo_subproyecto;
    proySubproy.codigo_unidad = $(this).find('#codigo').text();
    proySubproy.descripcion = $(this).find('#descripcion').text();
    
    lista_proySubproy.push(proySubproy);
  });
  
  var newObj2 = JSON.stringify(lista_proySubproy);
  
  $.ajax({
        url: 'guarga_proyecto_subproyecto',
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
          alert('El Proyecto-SubProyecto se guardo correctamente!');
          $('#codigo_proyecto').val('');
          $('#codigo_subproyecto').val('');
          
          $('#cuerpo_tabla_proySubproy tbody').empty();
          carga_proyecto_subproyecto();
        }
    });
  
});
//-----------------------------------
// var carga_proyecto_subproyecto = function(){

//   $.ajax({
//           url: 'carga_proyecto_subproyecto',
//           //data: {data: newObj},
//           type: "POST",
//           dataType: "html",
//           error: function()
//           {
//               alert('Error al cargar Proyectos!');
//           },
//           success: function(response)
//           {
//             $('#cuerpo_tabla tbody').html(response);
            
//           }
//       });
// }

var cargar_proyectos = function(){
  $.ajax({
    url: 'carga_cod_proyectos',
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
      url: 'calcula_sub_proyectos',
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
  var proySubproy = new Object();
  proySubproy.proyecto = $("#codigo_proyecto").val();
  proySubproy.subproyecto = $(this).val();
  proySubproy = JSON.stringify(proySubproy);
  $.ajax({
      url: 'trae_unidades_por_subproyecto',
            data: {data: proySubproy},
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
  var unidad = $(this).val();
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
  $.ajax({
      url: 'trae_elementos_por_unidad',
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
              
              $('#cuerpo_tabla tbody').empty();
              $('#cuerpo_tabla tbody').append(response);
              
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