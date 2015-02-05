$(document).ready(function () 
{
  carga_proyecto_subproyecto();
  cargar_proyectos();

  //---- carga Articulos ---
  $( "#buscaArticulos" ).dialog(
  {
     autoOpen: false,
     height: 350,
     width: 400,
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
        var url = "buscaUnidades";
        consulta = $("#busqueda").val();
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
//---- Elimina Gastos --------  
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
          alert('El Proyecto-SubProyecto se guardo correctamente!');
          $('#codigo_proyecto').val('');
          $('#codigo_subproyecto').val('');
          
          $('#cuerpo_tabla_proySubproy tbody').empty();
          carga_proyecto_subproyecto();
        }
    });
  
});
//-----------------------------------
var carga_proyecto_subproyecto = function(){

  $.ajax({
          url: 'carga_proyecto_subproyecto',
          //data: {data: newObj},
          type: "POST",
          dataType: "html",
          error: function()
          {
              alert('Error al cargar Proyectos!');
          },
          success: function(response)
          {
            $('#cuerpo_tabla tbody').html(response);
            
          }
      });
}

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
    $('#codigo_subproyecto').empty();
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

              $('#codigo_subproyecto').html(response);
              
            }
    });
  }
});