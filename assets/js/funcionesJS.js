$(document).ready(function () {
//---- Abre Modulo Proyectos ----	
	abreRegProyectos();

	abreRegUbiSat();
	
//---- Abre Modulo Configuraciones ----
	abreRegUsr();
  abreTipoProyecto();
  abreNaturalezaProyecto();
  abrePrioridadProyecto();
});

//-------------Registro Vehiculos ---------
var abreRegProyectos = function(){
	$('#regProyectos').click(function(){
		iframeProyectos();
	});
}

var iframeProyectos = function(){
	$.ajax({
       url: 'iframeRegProyectos2',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
       	 $('#data').html(response);
       }
    });
}

//-------------Registro de Materiales ---------
$(document).on('click', '#regMateriales', function(){
    iframeMateriales();
});

var iframeMateriales = function(){
  $.ajax({
       url: 'iframeRegMateriales',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
};

//-------------Registro de Mano de Obra ---------
$(document).on('click', '#regManoObra', function(){
    iframeManoObra();
});

var iframeManoObra = function(){
  $.ajax({
       url: 'iframeRegManoObra',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
};

//-------------Registro de Unidades ---------
$(document).on('click', '#regUnidades', function(){
    iframeUnidades();
});

var iframeUnidades = function(){
  $.ajax({
       url: 'iframeRegUnidades2',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
};
//-------------Ubicacion Satelital De camiones ---------
var abreRegUbiSat = function(){
	$('#regUbicacionPostes').click(function(){
		iframeUbiSat();
	});
}
var iframeUbiSat = function(){
	$.ajax({
       url: 'iframeRegUbiSat',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
       	 $('#data').html(response);
       }
    });
}
//---------------- Configuraciones ---------
var abreRegUsr = function(){
	$('#regUSR').click(function(){
		iframeUsuarios();
	});
}

var iframeUsuarios = function(){
	$.ajax({
       url: 'iframeUsr',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
       	 $('#data').html(response);
       }
    });
}

var abreTipoProyecto = function(){
  $('#regTipoProy').click(function(){
    iframeTipoProyecto();
  });
}

var iframeTipoProyecto = function(){
  $.ajax({
       url: 'iframeTipoProyecto',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
}

var abreNaturalezaProyecto = function(){
  $('#regNaturaleza').click(function(){
    iframeNaturaProyecto();
  });
}

var iframeNaturaProyecto = function(){
  $.ajax({
       url: 'iframeNaturaProyecto',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
}

var abrePrioridadProyecto = function(){
  $('#regPrioridadProy').click(function(){
    iframePrioridadProyecto();
  });
}

var iframePrioridadProyecto = function(){
  $.ajax({
       url: 'iframePrioridadProyecto',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
}

//------- Importacion de Datos desde Archivo ------------
$(document).on("click", "#regAdjuntar", function(){
  $.ajax({
       url: 'selProySubProy',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
});