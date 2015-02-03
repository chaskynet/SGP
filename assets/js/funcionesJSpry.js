$(document).ready(function () 
{
  carga_tipo_proy();
  carga_naturaleza();
  carga_prioridad();
  lista_proyectos();
});

//---- Guardar Orden/Asignacion -------
$(document).on('click', '#guardar', function(){
  var cabecera = new Object();
  cabecera.codigo = $('#codigo_proyecto').val();
  cabecera.numsubproy = $('#numsubproy').val();
  cabecera.tipo = $('#tipo_proyecto').val();
  cabecera.localizacion = $('#localizacion_proyecto').val();
  cabecera.naturaleza = $('#naturaleza_proyecto').val();
  cabecera.responsable = $('#responsable_proyecto').val();
  cabecera.prioridad = $('#prioridad_proyecto').val();
  cabecera.fecha_ini = $('#fecha_ini').val();
  cabecera.fecha_fin = $('#fecha_fin').val();
  if($('#codigo_proyecto').val().length < 1){
    alert ('Codigo de Proyecto no puede estar vacio!');
  }
  else if ($('#numsubproy').val().length < 1){
    alert('Debe llenar los Sub Proyectos');
  }
  else if ($('#tipo_proyecto').val().length < 1){
    alert('Debe llenar Tipo de Proyecto');
  }
  else if ($('#localizacion_proyecto').val().length < 1){
    alert('Debe llenar la Localizacion del Proyecto');
  }
  else if ($('#naturaleza_proyecto').val().length < 1){
    alert('Debe llenar la Naturaleza del Proyecto');
  }
  else if ($('#prioridad_proyecto').val().length < 1){
    alert('Debe llenar la Prioridad del Proyecto');
  }
  else{
    var newObj = JSON.stringify(cabecera);
    $.ajax({
          url: 'guarda_proyecto',
          data: {data: newObj},
          type: "POST",
          dataType: "html",
          error: function()
          {
              alert('Error al Guardar!');
          },
          success: function(response)
          {
            alert('El proyecto se guardo correctamente!');
            $('#codigo_proyecto').val('');
            $('#numsubproy').val('');
            $('#tipo_proyecto').val('');
            $('#localizacion_proyecto').val('');
            $('#naturaleza_proyecto').val('');
            $('#responsable_proyecto').val('');
           // $('#fecha_ini').val('');
           // $('#fecha_fin').val('');
            $('#cuerpo_tabla tbody').empty();
          }
      });
      lista_proyectos();
    }
  
});

var lista_proyectos = function(){
  $.ajax({
          url: 'lista_proyectos',
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
//-----------------------------------
var carga_productos = function(){
  var id_orden = $('#orden_servicio').val();
  $.ajax({
       url: 'carga_productos',
       data: {ordsrv: id_orden},
       type: "POST",
       //dataType: "html",
       success: function(response)
       {
         $('#cuerpo_tabla tbody').html(response);
       }
    });
}
//-----------------------------------
var carga_tipo_proy = function(){
  $.ajax({
     url: 'carga_tipo_proy',
    // data: data,
     type: "GET",
     //dataType: "html",
     success: function(response)
     {
       $('#lista_tipoproy').append(response);
     }
  });
}

$(document).on('click', '#calcular', function(){
  var tipo = $('#tipo_proyecto');
  var localiza = $('#localizacion_proyecto');
  var fecha_ini = $('#fecha_ini');

  if ($(tipo).val().length < 1) {
    alert('Tipo de Proyecto esta vacio');
  }
  else if ($(localiza).val().length < 1) {
    alert('la Localizacion esta vacia');
  }
  else{
    var objeto = new Object();
    objeto.tipo = $(tipo).val();
    objeto.localiza = $(localiza).val();
    objeto.fecha_ini = $(fecha_ini).val();

    var newObj = JSON.stringify(objeto);
    $.ajax({
       url: 'dias_por_tipo',
       data: {data: newObj},
       type: "POST",
       //dataType: "html",
       success: function(response)
       {
         $('#fecha_fin').val(response);
         $('#guardar').attr('disabled',false);
       }
    });
  }
  
  
});

var carga_naturaleza = function(){
  $.ajax({
     url: 'carga_naturaleza_proy',
    // data: data,
     type: "GET",
     //dataType: "html",
     success: function(response)
     {
       $('#lista_naturaproy').append(response);
     }
  });
}

var carga_prioridad = function(){
  $.ajax({
     url: 'carga_prioridad_proy',
     //data: {data: dato},
     type: "POST",
     //dataType: "html",
     success: function(response)
     {
       $('#lista_prioridadproy').append(response);
     }
  });
}


$(document).on('change', '#vehiculo', function(){
  carga_capacidad();
});