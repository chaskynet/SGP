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

//-------------Registro Proyectos ---------
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
//------------ Registro Proyecto-Subproeycto -------
$(document).on('click', '#regPrySubPry', function(){
  iframePrySubPry();
});

var iframePrySubPry = function(){
  $.ajax({
       url: 'iframeRegPrySubPry',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
}
//------------ Registro Actualizacion de Subproeycto -------
$(document).on('click', '#actualizaProyecto', function(){
  iframeSubPryUnid();
});

var iframeSubPryUnid = function(){
  $.ajax({
       url: 'iframeRegSubPryUnid',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
}

$(document).on('click', '#postergaProyecto', function(){
  iframePostergaPry();
});
var iframePostergaPry = function(){
  $.ajax({
       url: 'iframeRegPostergaPry',
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
$(document).on('click', '#regUnidades2', function(){
    iframeUnidades2();
});

var iframeUnidades2 = function(){
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

$(document).on('click', '#regUnidades', function(){
    iframeUnidades();
});

var iframeUnidades = function(){
  $.ajax({
       url: 'iframeRegUnidades',
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

$(document).on('click', '#regResp', function(){
    iframeResponsable();
});

var iframeResponsable = function(){
  $.ajax({
       url: 'iframeRegResponsable',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
};

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
//------- Pre-Liquidacion -------------------------------

$(document).on('click', '#regPreliquidacion', function(){
    iframePreliquidacion();
});

var iframePreliquidacion = function(){
  $.ajax({
       url: 'iframeRegPreliquidacion',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
};

$(document).on('click', '#regInformePreliq', function(){
    iframeInfPreliquidacion();
});

var iframeInfPreliquidacion = function(){
  $.ajax({
       url: 'iframeRegInfPreliquidacion',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
};

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

//------------ Registro Observaciones del SUpervisor -------
$(document).on('click', '#regObservaciones', function(){
  iframeObservaciones();
});

var iframeObservaciones = function(){
  $.ajax({
       url: 'iframeRegObseraciones',
      // data: data,
       type: "GET",
       //dataType: "html",
       success: function(response)
       {
         $('#data').html(response);
       }
    });
}