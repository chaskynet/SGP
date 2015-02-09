<!DOCTYPE html>
<html lang="es">
	
	<link rel="stylesheet" type="text/css" href="../css/estilos.css" />
	<link rel="stylesheet" type="text/css" href="../css/calendario.css" />
	<link rel="stylesheet" type="text/css" href="../css/estilo_tablas.css" />
	<link rel="stylesheet" type="text/css" href="../assets/js/jquery-ui/jquery-ui.min.css" />

	<!--script src="../assets/js/calendar.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-es.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-setup.js" type="text/javascript"></script-->

	<script src="../assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="../assets/js/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/funcionesJSproySubProy.js" type="text/javascript"></script>
<body>
<!-- Ventana para busqueda de articulos-->
	<div class="buscaArticulos" id="buscaArticulos">
		Ingrese el Unidad a buscar: <input type="text" id="busqueda"/>
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
			<h1>Adicion de Unidades a Proyecto - SubProyecto</h1>
		</center>
	</div>
	<div id="cabecera">
		<table>
		
			<tr>
				<td>Codigo de Proyecto *: </td>
				<td>
					<select id="codigo_proyecto">
						<option></option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Sub Proyecto *: </td>
				<td>
					<input type="text" id="codigo_subproyecto" list="list_codigo_subproyecto">
					<datalist id="list_codigo_subproyecto">
						<option></option>
					</datalist>
				</td>
			</tr>
		</table>
		<div id="cuerpo_unidades">
		<table id="cuerpo_tabla_proySubproy">
			<caption>
				<img src="../imagenes/plus.ico" class="plus_icon" id="btn_busca_articulos"> Añadir Unidades
			</caption>
			<tfoot>
				<tr>
					<td colspan="4">
						<center><input type="button" id="guardar" value="Guardar"></center>
					</td>
				</tr>
			</tfoot>
			<thead>
				<tr>
					<th>Acciones</th>
					<th>Unidad</th>
					<th>Descripcion</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
	</div>
	
	<div id="lista_proyectos">
		
		<div id="cabecera_tabla">
			
			<table>
			<caption>
			Lista de Unidades
			</caption>
				<thead>
					<tr>
						<th class="proyecto">Proyecto SubProyecto</th>
						
						<th class="tipo_proyecto">Unidad</th>
						
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