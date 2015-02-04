<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#" style="color:#FFF">Gestion de Proyectos</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href='<?php echo site_url('main/principal')?>'>Principal</a></li>
               <?php //if($_SESSION['tipo_user']=='a'){   ?>
              <li class="dropdown">
              	<a href="#" style="color:#FFF" class="dropdown-toggle" data-toggle="dropdown">Proyectos<b class="caret"></b></a>
                <ul class="dropdown-menu">
                	  <li><a href="#" id="regProyectos">Crear Proyectos</a></li>
                    <li><a href="#" id="actualizaProyecto">Actualizar Proyectos</a></li>
                    <li><a href="#" id="postergaProyecto">Postergar Proyectos</a></li>
                </ul>
              </li>
             
              <li class="dropdown">
                <a href="#" style="color:#FFF" class="dropdown-toggle" data-toggle="dropdown" id="importdatos">Importar Datos<b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a href="#" id="regImportar">Importar datos a Proyecto</a></li>
                <li><a href="#" id="regAdjuntar">Adjunatar docs a Proyecto</a></li>
                <!-- Importar -->
                <li><a href="#" id="importplanilla">Importar planilla de asignacion de proyecto</a></li>
                </ul>
              </li>
              
              <li class="dropdown">
                <a href="#" style="color:#FFF" class="dropdown-toggle" data-toggle="dropdown" id="regconciliacion">Conciliación/Preliquidacion<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#" id="regConciliar">Preliquidacion Proyectos</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" style="color:#FFF" class="dropdown-toggle" data-toggle="dropdown" id="regReportes">Reportes<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#" id="regReporte1">Reporte #1</a></li>
                  <li><a href="#" id="regReporte2">Reporte #2</a></li>
                </ul>
              </li>
              <?php // } ?>
            </ul>
            <ul class="nav pull-right">
                <li class="dropdown">
              		<a href="#" style="color:#FFF" class="dropdown-toggle" data-toggle="dropdown">
                    	Configuraciones  <b class="caret"></b>
                    </a>
                	<ul class="dropdown-menu">
                      <li><a href="#" id="regUSR">Registro de Usuarios</a></li>
                      <li class="divider"></li>
                      <li><a href="#" id="regTipoProy">Registro de Tipo Proyecto</a></li>
                      <li><a href="#" id="regNaturaleza">Registro de Naturaleza Proyecto</a></li>
                      <li><a href="#" id="regPrioridadProy">Registro de Prioridad Proyecto</a></li>
                      <li class="divider"></li>
                      <li><a href="#" id="regMateriales">Registro de Materiales</a></li>
                      <li><a href="#" id="regManoObra">Registro de Mano de Obra</a></li>
                      <li class="divider"></li>
                      <li><a href="#" id="regUnidades2">Registro de Unidades</a></li>
                      <li><a href="#" id="regUnidades">Registro de Unidades Manual</a></li>
                      <li class="divider"></li>
                      <li><a href="#" id="regUbicacionPostes">Registro de Ubicacion Postes</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                  <a href="#" style="color:#FFF" class="dropdown-toggle" data-toggle="dropdown">
                      Hola!  <b class="caret"></b>
                    </a>
                  <ul class="dropdown-menu">
                      <li><a href="perfil.php"> Mi Perfil</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url().'main/logout';?>"> Salir</a></li>
                    </ul>
                </li>
          	</ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<!-- /container -->