$(document).ready(function () 
{
  carga_unidades();

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
                                +'<input type="text" id="cantidad" class="cantidad_cif cantidad" value="1">'
                              +'</td>'
                              
                            +'</tr>';
              $("#cuerpo_tabla_unidad tbody").append(cadena);

            });
          if (tamcheck>0){
              //$( this ).dialog( "close" );
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
    $("#buscaArticulos").dialog( "open" );
    var consulta;

    $("#busqueda").focus();
    $("#busqueda").keyup(function(e)
    {
      var i = 0
      if(e.which == 13)
      {
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
//---- Elimina --------  
$(document).on('click','#elimina_prod',function(){
  var objFila=$(this).parents().get(1);
  $(objFila).remove();

});

//---- Guardar Unidad -------
$(document).on('click', '#guardar', function(){
  //var cabecera = [];
  
  var lista_productos = new Array();
  
  var cod_unidad = $('#codigo_unidad').val();
  var desc_unidad = $('#desc_unidad').val();
  var fecha_inicio_vigencia = $('#fecha_inicio_vigencia').val();

  $("#cuerpo_tabla_unidad tbody tr").each(function(){
    var unidad = new Object();

    unidad.cod_unidad = cod_unidad;
    unidad.desc_unidad = desc_unidad;
    unidad.fecha_inicio_vigencia = fecha_inicio_vigencia;
    unidad.codigo = $(this).find('#codigo').text();
    unidad.descripcion = $(this).find('#descripcion').text();
    unidad.cantidad = $(this).find('#cantidad').val();
    lista_productos.push(unidad);
  });
  
  var newObj2 = JSON.stringify(lista_productos);
  
  $.ajax({
        url: 'guarga_unidad',
        data: {data2: newObj2},
        type: "POST",
        dataType: "html",
        error: function()
        {
            alert('Error al Guardar!');
        },
        success: function(response)
        {
          alert(response);
          // alert('La Unidad se guardo correctamente!');
          // $('#codigo_unidad').val('');
          // $('#desc_unidad').val('');
          // $('#fecha_inicio_vigencia').val('');
          // $('#cuerpo_tabla_unidad tbody').empty();
          // carga_unidades();
        }
    });
  
});
//-----------------------------------
var carga_unidades = function(){

  $.ajax({
      url: 'carga_unidades',
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
//para capturar el ENTER y realizar la busqueda de Unidades
$(function () {
  $("#buscaUnidades").keypress(function (e) 
  { 
    if (e.which == 13) 
    { 
      //btnBuscar();
      if ($("#buscaUnidades").val().length > 0 ){
        var dato = $(this).val();
        $.ajax({
            url: 'buscadorDeUnidades',
            data: {data: dato},
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
      else 
      {
        carga_unidades();
      }
    }
  });
});
//--------------- Para la Edicion ----
$(document).on('click', '#unidad', function(){
  
  tmp = $(this).find('#codigo_elemento_unidad').text();
  tmp2 = $(this).find('#descripcion').text();
  
  $("#codigo_unidad").val(tmp);
  $("#desc_unidad").val(tmp2);

  //------ Trae las unidades asociadas ----//
  $.ajax({
      url: 'trae_elementos_de_unidad',
      data: {dato: tmp},
      type: "POST",
      dataType: "html",
      error: function()
      {
          alert('Error al calcular Sub Proyectos!');
      },
      success: function(response)
      {
        $("#cuerpo_tabla_unidad tbody").html(response);
      }
    });
  //------ Trae la fecha de Inicio de Vigencia ---//
  $.ajax({
      url: 'trea_fecha_inicio_vigencia',
      data: {codigo:tmp},
      type: 'POST',
      dataType: 'html',
      error: function()
      {
        alert('Error al trear la fecha de Vigencia');
      },
      success: function(response){
          $('#fecha_inicio_vigencia').val(response);
      }
  });
});