<!DOCTYPE html>
<html lang="es">
	<link rel="stylesheet" type="text/css" href="../css/estilos.css" />
	<link href="../css/calendario.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="../css/estilo_tablas.css" />

	<script src="../assets/js/calendar.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-es.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-setup.js" type="text/javascript"></script>

	<script src="../assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="../assets/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="../assets/js/funcionesJSuni.js" type="text/javascript"></script>
<body>
<!-- Ventana para busqueda de articulos-->
	<div class="buscaArticulos" id="buscaArticulos">
		Ingrese el Item a buscar: <input type="text" id="busqueda"/>
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
			<h1>Creacion de Unidades</h1>
		</center>
	</div>
	<div id="cabecera">
		<table>
		
			<tr>
				<td>Codigo de la Unidad *: </td>
				<td>
					<input type="text" id="codigo_unidad">
				</td>
			</tr>
			<tr>
				<td>Descripcion de la Unidad *: </td>
				<td>
					<input type="text" id="desc_unidad">
					
				</td>
			</tr>
		</table>
		<div id="cuerpo_unidades">
		<table id="cuerpo_tabla_unidad">
			<caption>
				<img src="../imagenes/plus.ico" class="plus_icon" id="btn_busca_articulos"> Añadir Articulos
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
					<th>Producto</th>
					<th>Descripcion</th>
					<th>Cantidad</th>
					
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
						<th class="proyecto">Unidad</th>
						
						<th class="tipo_proyecto">Descripcion</th>
						
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