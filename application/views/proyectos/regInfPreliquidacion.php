<!DOCTYPE html>
<html lang="es">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/estilos.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/calendario.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/estilo_tablas.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/popup.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap/css/bootstrap.css" />
	<!--script src="../assets/js/calendar.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-es.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-setup.js" type="text/javascript"></script-->
	<script src="../assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="../assets/js/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/AjaxFileUploader/ajaxfileupload.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/funcionesJSInfpreLiquidacion.js" type="text/javascript"></script>
<body>
<!-- Ventana para busqueda de articulos-->
	<div class="buscaArticulos" id="buscaArticulos">
		Ingrese el Elemento a buscar: <input type="text" id="busqueda"/>
		<div class="tabla-cabecera">
			<div class="fila_cabecera">
				<!--div class="columna chk"><input type="checkbox" id="checkAll" onclick="elijeTodosChk();"></div-->
				<div class="columna descripcion">Codigo Unidad</div>
				<div class="columna descripcion">Descripcion</div>
			</div>
		</div>
		<div class="cuerpo" id="cuerpo">
			<div class="tabla" id="tabla_articulos">
			</div>
		</div>
	</div>
<!-- Fin ventana Busqueda de Articulos -->
	<div>
		<center>
			<h1>Informe de Preliquidacion</h1>
		</center>
	</div>
	<div id="cabecera_preliquidacion" class="cabecera_preliquidacion well">
		<div id="cuerpo_unidades">
			<table id="cuerpo_tabla_proySubproy" class="table tabla_proyectos ">
				<caption>
					Detalle de Preliquidacion
				</caption>
				<thead>
					<tr>
						<th>Unidad</th>
						<th>Elemento</th>
						<th>Ref</th>
						<th>Presupuestado</th>
						<th>Retirado</th>
						<th>Re-Usado</th>
						<th>Nuevo</th>
						<th>Sobrante</th>
						
						<th>Faltante</th>

					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
	</div>

	</div>
	<div id="lista_proyectos_preliquidacion" class="well">
		
		<div id="cabecera_tabla">
			
			<table class="table">
			<caption>
			Lista de Proyectos a PreLiquidar
			</caption>
				<thead>
					<tr>
						<th>Proyecto SubProyecto</th>
						
						<th>Avance</th>
						
					</tr>
				</thead>
			</table>
		</div>
		<div id="cuerpo">
			<table id="cuerpo_tabla" class="tabla_proyectos">
				
				<tbody>
					
				</tbody>
			</table>
			
		</div>

	</div>
</body>
</html>