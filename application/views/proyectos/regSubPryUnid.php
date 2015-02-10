<!DOCTYPE html>
<html lang="es">
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/estilos.css" />
	<link rel="stylesheet" type="text/css" href="../css/calendario.css" />
	<link rel="stylesheet" type="text/css" href="../css/estilo_tablas.css" />
	<link rel="stylesheet" type="text/css" href="../assets/js/jquery-ui/jquery-ui.min.css" />

	<!--script src="../assets/js/calendar.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-es.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-setup.js" type="text/javascript"></script-->

	<script src="../assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="../assets/js/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/funcionesJSsubPryUnid.js" type="text/javascript"></script>
<body>
<!-- Ventana para busqueda de articulos-->
	<div class="buscaArticulos" id="buscaArticulos">
		Ingrese el Elemento a buscar: <input type="text" id="busqueda"/>
		<div>
		<input type="radio" name="fuente" value="materiales" checked> Materiales
		<input type="radio" name="fuente" value="manoObra"> Mano de Obra
		</div>
		<div class="tabla-cabecera">
			<div class="fila_cabecera">
				<!--div class="columna chk"><input type="checkbox" id="checkAll" onclick="elijeTodosChk();"></div-->
				<div class="columna descripcion">Codigo Fab.</div>
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
			<h1>Actualizar Avance de Sub-Proyecto</h1>
		</center>
	</div>
	<div id="cabecera_actualizar_subproy">
		<table>
		
			<tr>
				<td style="width: 110px;">Codigo de Proyecto *: </td>
				<td style="width: 100px;">
					<select id="codigo_proyecto">
						<option></option>
					</select>
				</td>
			
				<td style="width: 90px;">Sub Proyecto *: </td>
				<td>
					<!--input type="text" id="codigo_subproyecto" list="list_codigo_subproyecto"-->
					<select id="codigo_subproyecto">
						<option></option>
					</select>
				</td>
				<td style="width: 50px; ">Unidades: </td>
				<td>
					<!--input type="text" id="codigo_subproyecto" list="list_codigo_subproyecto"-->
					<select id="unidades">
						<option></option>
					</select>
				</td>
				<td style="width: 90px; ">Codigo Poste #1: </td>
				<td>
					<input type="text" id="codigo_poste_1" size='5'>
				</td>
				<td style="width: 90px; ">Codigo Poste #2: </td>
				<td>
					<input type="text" id="codigo_poste_2" size='5'>
				</td>
			</tr>
		</table>
	</div>
	<div class="clearfloat"></div>
	<center><h3 id="tipo_unidad"></h3></center>
	<div id="lista_elementos">
		
		<div id="imagen_unidad">
		</div>
		
		<div id= "cabecera_elementos">
			<table class="cabecera_tabla_elementos">
				<thead>
					<tr>
						<th>Código</th>
						<th>Descripción</th>
						<th>Unidad</th>
						<th>Presupuest</th>
						<th>Retirado</th>
						<th>Usado</th>
						<th>Nuevo</th>
					</tr>
				</thead>
			</table>
		</div>
		<div id="cuerpo_unidad">
			<table id="cuerpo_tabla_unid" class="cuerpo_tabla_unid">
				<tbody>
					
				</tbody>
			</table>
			<input type="button" id="btn_busca_articulos" value="Añadir Elementos">
		</div>
		<div class="clearfloat"></div>
	<div style="float: left;">
			<input type="button" value="Guardar" id="actualizar">
		</div>
	</div>
</body>
</html>