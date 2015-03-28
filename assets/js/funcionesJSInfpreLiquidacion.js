$(document).ready(function () 
{
  carga_proyecto_subpry_preliq();
  //cargar_proyectos();

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
          var cadena_observacion = traeObservaciones();
          
          $( "input[name='articulo[]']:checked").each(function()
            {
              //var id = $(this).attr("id");
              var cadena = '<tr style="height:25px;">'
                              
                              +'<td class="columna" id="codigo">'
                                +$(this).attr('id')
                              +'</td>'
                              +'<td class="columna descripcion" id="descripcion">'
                                +$(this).attr('value')
                              +'</td>'
                              +'<td class="columna" id="unidad">'
                                +$(this).attr('data-unidad')
                              +'</td>'
                              +'<td class="columna" id="descripcion">'
                                +0
                              +'</td>'
                              +'<td class="columna" id="descripcion">'
                               + 0
                              +'</td>'
                              +'<td class="columna" id="descripcion">'
                               + 0
                              +'</td>'
                              +'<td class="columna" id="descripcion">'
                               + 0
                              +'</td>'
                              +'<td class="columna" id="descripcion">'
                                +0
                              +'</td>'
                              +'<td class="columna descripcion" id="descripcion">'
                                +cadena_observacion//+'<select><option></option><option>INCOMPLETO</option><option>FALTA COPLETAR LA UNIDAD</option><option>COLOCO UN ELEMENTO USADO</option></select>'
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
//-----------------------------------------------------------------
$(document).on('click','#btn_busca_articulos',function(){
    $("#tabla_articulos").empty();
    $("#busqueda").val('');

    if ($(this).attr('data-pry').length > 0) {

      $( "#buscaArticulos" ).dialog( "open" );
      var consulta;
      
      $("#busqueda").focus();
      $("#busqueda").keyup(function(e)
      {
        var i = 0
        if(e.which == 13)
        {
          i++;
          var obj = new Object();
          var url = "buscaElementosProy";
          consulta = $("#busqueda").val();
          var subpry = $('#btn_busca_articulos').attr('data-pry');
          obj.consulta = consulta;
          obj.subpry = subpry;
          
          var newObj = JSON.stringify(obj);
          
          //hace la búsqueda
          $.ajax({
              url: url,
              data: {data: newObj},
              type: "POST",
              dataType: "html",
              error: function()
              {
                  $("#tabla_articulos").empty();
                  $("#tabla_articulos").html('no hay resultados');
              },
              success: function(response)
              {
                //alert(response);
                $("#tabla_articulos").find("tbody").empty();
                $('#tabla_articulos').html(response);
              }
          });

        }
      });
    }
    else{
      alert('Seleccion un SubProyecto!');
    }
  
});
//---- Trae Observaciones ----
function traeObservaciones(){
   var result = null;
    $.ajax({
        async: false,
        cache: false,
        url: 'traeObservaciones',
        type: "POST",
        dataType: "html",
        error: function()
        {
            alert('Error al traer las Observaciones');
        },
        success: function(response)
        {
            result = response;
        }
    });
    return result;
}
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
  var arch_presu_mano = $('#presu_mano_obra').text();
  var arch_presu_mate = $('#presu_materiales').text();

  $("#cuerpo_tabla_proySubproy tbody tr").each(function(){
    var proySubproy = new Object();

    proySubproy.codigo_proyecto = codigo_proyecto;
    proySubproy.codigo_subproyecto = codigo_subproyecto;
    proySubproy.codigo_unidad = $(this).find('#codigo').text();
    proySubproy.arch_presu_mano = arch_presu_mano;
    proySubproy.arch_presu_mate = arch_presu_mate;

    //proySubproy.descripcion = $(this).find('#descripcion').text();
    
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
          $('#presu_mano_obra').text('');
          $('#presu_materiales').text('');
          
          $('#cuerpo_tabla_proySubproy tbody').empty();
          carga_proyecto_subpry_preliq();
        }
    });
});
//-----------------------------------
var carga_proyecto_subpry_preliq = function(){

  $.ajax({
          url: 'carga_proyecto_subpry_preliq',
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
              //$('#codigo_subproyecto').val('');
              $('#codigo_subproyecto').html('<option></option>');
              $('#cuerpo_tabla_proySubproy tbody').empty();
              $('#codigo_subproyecto').append(response);
              
            }
    });
  }
});

$(document).on('click', '#proysubproy', function(){
  //$('#cuerpo_tabla_proySubproy caption').append('<img src="../imagenes/plus.ico" data-pry="" class="plus_icon" id="btn_busca_articulos">');
   tmp = $(this).text();
   //$('#btn_busca_articulos').attr('data-pry', tmp);
  //------ Trae las unidades asociadas ----//
  $.ajax({
      url: 'trae_proysubproy_inf_preliq',
            data: {dato: tmp},
            type: "POST",
            dataType: "html",
            error: function()
            {
                alert('Error al traer Elementos!');
            },
            success: function(response)
            {
              $("#cuerpo_tabla_proySubproy tbody").html(response);
            }
    });

});

