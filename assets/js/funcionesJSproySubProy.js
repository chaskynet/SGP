$(document).ready(function () 
{
  carga_proyecto_subproyecto();
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
              var cadena = '<tr style="height:25px;">'
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
//-------- Importa Mano de Obra -----//
var dialog;
dialog = $( "#form_importar_mano_obra" ).dialog(
  {
     autoOpen: false,
     height: 250,
     width: 350,
     modal: true,
     buttons:
      {
        "Importar Presupuesto a la Base de Datos": function(){
          var objFile = new Object();
          objFile.archivo = $("#archivo_subido_presu_mano_obra").text();
          objFile.id_proyecto = $('#codigo_proyecto').val();
          objFile.id_sub_proy = $('#codigo_subproyecto').val();
          newObjFile = JSON.stringify(objFile);
          // if ($(archivo).length < 1){
          //  alert("Debe seleccionar un archivo!");
          // }
          // else{
            $.ajax({
              url: 'importarPresuManoObra',
              data: {data: newObjFile},
              type: "POST",
              dataType: "html",
              error: function()
              {
                  alert('Error al procesar el archivo!');
              },
              success: function(response)
              {
                 alert('Presupuesto de Mano de Obra cargado correctamente');
                $('#cuenta').text(response);
                dialog.dialog( "close" );
                //location.reload('iframeRegMateriales');
              }
          });
          //}
        }
       }
   });
//-------- Importa Materiales -----//
var dialog;
dialog = $( "#form_importar_materiales" ).dialog(
  {
     autoOpen: false,
     height: 250,
     width: 350,
     modal: true,
     buttons:
      {
        "Importar Presupuesto a la Base de Datos": function(){
          // var archivo = $("#archivo_subido_presu_materiales").text();

          var objFile = new Object();
          objFile.archivo = $("#archivo_subido_presu_materiales").text();
          objFile.id_proyecto = $('#codigo_proyecto').val();
          objFile.id_sub_proy = $('#codigo_subproyecto').val();
          newObjFile = JSON.stringify(objFile);
          // if ($(archivo).length < 1){
          //  alert("Debe seleccionar un archivo!");
          // }
          // else{
            $.ajax({
              url: 'importarPresuMateriales',
              data: {data: newObjFile},
              type: "POST",
              dataType: "html",
              error: function()
              {
                  alert('Error al procesar el archivo!');
              },
              success: function(response)
              {
                alert('Presupuesto de Materiales cargado correctamente');
                dialog.dialog( "close" );
              }
          });
          //}
        }
       }
   });

var dialog;
dialog = $( "#datos_presu_mano_obra" ).dialog(
  {
     autoOpen: false,
     height: 250,
     width: 850,
     modal: true,
     buttons:
      {
        "Cerrar": function(){
          dialog.dialog( "close" );
          //}
        }
       }
   });
var dialog;
dialog = $( "#datos_presu_materiales" ).dialog(
  {
     autoOpen: false,
     height: 250,
     width: 850,
     modal: true,
     buttons:
      {
        "Cerrar": function(){
          dialog.dialog( "close" );
          //}
        }
       }
   });
});


//------ Abra pop up para importar presupuesto de mano de obra ----
$(document).on('click', '#imp_presu_mano_obra', function(){
  $( "#form_importar_mano_obra" ).dialog( "open" ); 
});
$(function() {
  $('#upload_file_mano_obra').submit(function(e) {
    e.preventDefault();
    $.ajaxFileUpload({
      url       :'upload_file', 
      secureuri   :false,
      fileElementId :'userfile',
      dataType    : 'json',
      // data      : {
      //         'title' : $('#title').val()
      //         },
      success : function (data, status)
      {
        if(data.status != 'error')
        {
          alert(data.msg);
          $("#archivo_subido_presu_mano_obra").text(data.archivo);
          $("#presu_mano_obra").html('<a id="lnk_presu_mano_obra">'+data.archivo+'</a>');
        }
        else{
          alert("error al subir el archivo");
        }
      }
    });
    return false;
  });
});
//------ Abre pop up para importar presupuesto de Materiales ----
$(document).on('click', '#imp_presu_materiales', function(){
  $( "#form_importar_materiales" ).dialog( "open" ); 
});
$(function() {
  $('#upload_file_materiales').submit(function(e) {
    e.preventDefault();
    $.ajaxFileUpload({
      url       :'upload_file', 
      secureuri   :false,
      fileElementId :'userfiles',
      dataType    : 'json',
      // data      : {
      //         'title' : $('#title').val()
      //         },
      success : function (data, status)
      {

        if(data.status != 'error')
        {
          alert(data.msg);
          $("#archivo_subido_presu_materiales").text(data.archivo);
          $("#presu_materiales").html('<a id="lnk_presu_materiales">'+data.archivo+'</a>');
        }
        else{
          alert("error al subir el archivo");
        }
        
      }
    });
    return false;
  });
});

//----------- Funciones que muestran los datos cargados de los archivos presupuestos -----//
// -------- Presupuesto Mano de Obra ------- //
$(document).on('click', '#lnk_presu_mano_obra', function(){
  $( "#datos_presu_mano_obra" ).dialog( "open" ); 

  var obj = new Object();
  obj.proyecto = $('#codigo_proyecto').val();
  obj.subproyecto = $('#codigo_subproyecto').val();
  newObj = JSON.stringify(obj);
  $.ajax({
        url: 'carga_datos_presu_mano_obra',
        data: {data: newObj},
        type: "POST",
        dataType: "html",
        error: function()
        {
            alert('Error al traer datos de Presupuesto Mano de Obra');
        },
        success: function(response)
        {
          $('#tabla_ele_presu_mate').html(response);
        }
    });
});
// -------- Presupuesto Materiales ------- //
$(document).on('click', '#lnk_presu_materiales', function(){
  $( "#datos_presu_materiales" ).dialog( "open" ); 

  var obj = new Object();
  obj.proyecto = $('#codigo_proyecto').val();
  obj.subproyecto = $('#codigo_subproyecto').val();
  newObj = JSON.stringify(obj);
  $.ajax({
        url: 'carga_datos_presu_materiales',
        data: {data: newObj},
        type: "POST",
        dataType: "html",
        error: function()
        {
            alert('Error al traer datos de Presupuesto Mano de Obra');
        },
        success: function(response)
        {
          $('#tabla_ele_presu_mate').html(response);
        }
    });
});
//-----------------------------------------------------------------
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
  var cuenta = $('#cuenta').text();
  var propietario = $('#propietario').val();
  var arch_presu_mano = $('#presu_mano_obra').text();
  var arch_presu_mate = $('#presu_materiales').text();

  $("#cuerpo_tabla_proySubproy tbody tr").each(function(){
    var proySubproy = new Object();

    proySubproy.codigo_proyecto = codigo_proyecto;
    proySubproy.codigo_subproyecto = codigo_subproyecto;
    proySubproy.codigo_unidad = $(this).find('#codigo').text();
    proySubproy.cuenta = cuenta;
    proySubproy.propietario = propietario;
    proySubproy.arch_presu_mano = arch_presu_mano;
    proySubproy.arch_presu_mate = arch_presu_mate;
    
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
          $('#presu_mano_obra').text('');
          $('#cuenta').text('');
          $('#propietario').val('');
          $('#presu_materiales').text('');
          
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
              //$('#codigo_subproyecto').val('');
              $('#codigo_subproyecto').html('<option></option>');
              $('#cuerpo_tabla_proySubproy tbody').empty();
              $('#codigo_subproyecto').append(response); 
            }
    });
  }
});

$(document).on('click', '#proysubproy', function(){
  
  tmp = $(this).text();
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
                   $("#codigo_subproyecto").html('<option>'+valor.id_sub_proy+'</option>');
                   $("#cuenta").text(valor.cuenta);
                   $("#propietario").html('<option>'+valor.propiedad+'</option>');
                   $("#presu_mano_obra").html('<a id="lnk_presu_mano_obra">'+valor.arch_presu_mano+'</a>');
                   $("#presu_materiales").html('<a id="lnk_presu_materiales">'+valor.arch_presu_mate+'</a>');
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