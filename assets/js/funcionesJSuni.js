$(document).ready(function () 
{
  carga_unidades();

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
              var id = $(this).attr("id");
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
              $("#cuerpo_tabla_unidad tbody").append(cadena);

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
//---- Elimina Gastos --------  
$(document).on('click','#elimina_prod',function(){
  var objFila=$(this).parents().get(1);
  $(objFila).remove();

});
//---- Guardar Orden/Servicio -------
$(document).on('click', '#guardar', function(){
  //var cabecera = [];
  
  var lista_productos = new Array();

  
  var cod_unidad = $('#codigo_unidad').val();
  var desc_unidad = $('#desc_unidad').val();

  $("#cuerpo_tabla_unidad tbody tr").each(function(){
    var unidad = new Object();
    unidad.cod_unidad = cod_unidad;
    unidad.desc_unidad = desc_unidad;
    unidad.codigo = $(this).find('#codigo').text();
    unidad.descripcion = $(this).find('#descripcion').text();
    unidad.cantidad = $(this).find('#cantidad').val();
    lista_productos.push(unidad);
  });
  var newObj2 = JSON.stringify(lista_productos);
  alert(newObj2);
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
          alert('La Unidad se guardo correctamente!');
          $('#codigo_unidad').val('');
          $('#desc_unidad').val('');
          
          $('#cuerpo_tabla_unidad tbody').empty();
          carga_unidades();
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