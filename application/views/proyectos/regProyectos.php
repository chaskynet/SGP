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
	<script src="../assets/js/funcionesJSpry.js" type="text/javascript"></script>
<body>
	<div>
		<center>
			<h1>Creacion de Proyectos</h1>
		</center>
	</div>
	<div id="cabecera">
		<table>
		<tfoot>
			<tr>
				<td colspan="5">
					<center><input type="button" id="guardar" value="Guardar" disabled="true"></center>
				</td>
			</tr>
		</tfoot>
			<tr>
				<td>Codigo de Proyecto *: </td>
				<td>
					<input type="text" id="codigo_proyecto">
				</td>
			</tr>
			<tr>
				<td>Num. Sub Proyectos *: </td>
				<td>
					<input type="text" id="numsubproy" list="lista_numsubproy">
					<datalist id="lista_numsubproy">
						<option value="1">
						<option value="2">
						<option value="3">
						<option value="4">
						<option value="5">
					</datalist>
				</td>
			</tr>

			<tr>
				<td>Tipo de Proyecto *: </td>
				<td>
					<input type="text" id="tipo_proyecto" list="lista_tipoproy">
					<datalist id="lista_tipoproy">
					</datalist>
				</td>
			</tr>
			<tr>
				<td>Localizacion de Proyecto *: </td>
				<td>
					<input type="text" id="localizacion_proyecto" list="lista_localizaproy">
					<datalist id="lista_localizaproy">
						<option value="URBANO">
						<option value="RURAL">
						<option value="TROPICO">
					</datalist>
				</td>
			</tr>
			<tr>
				<td>Naturaleza de Proyecto *: </td>
				<td>
					<input type="text" id="naturaleza_proyecto" list="lista_naturaproy">
					<datalist id="lista_naturaproy">
					</datalist>
				</td>
			</tr>
			<tr>
				<td>Prioridad de Proyecto *: </td>
				<td>
					<input type="text" id="prioridad_proyecto" list="lista_prioridadproy">
					<datalist id="lista_prioridadproy">
					</datalist>
				</td>
			</tr>
			<tr>
				<td>
					Responsable
				</td>
				<td>
					<input type="text" id="responsable_proyecto">
				</td>
			</tr>
			<tr>
				<td>Fecha Inicio: </td>
				<td>
					<input type="text" id="fecha_ini" name="fecha_ini" class="innerimg" value= "<?php echo date ("d-m-Y", time()); ?>"  /><input type="button" id="calcular" value="Calcular">
					<script type="text/javascript"> 
					   Calendar.setup({ 
					   	inputField:    "fecha_ini",
					    ifFormat:     "%d-%m-%Y",
					    selection     : new Date(),
					    button:    "fecha_ini"
					});
					</script>
				</td>
			</tr>
			<tr>
				<td>Fecha Inicio: </td>
				<td>
					<input type="text" id="fecha_fin" name="fecha_fin" class="innerimg" disabled />
					<script type="text/javascript"> 
					   Calendar.setup({ 
					   	inputField:    "fecha_fin",
					    ifFormat:     "%d-%m-%Y",
					    selection: new Date(),
					    button:    "fecha_fin"
					});
					</script>
				</td>
			</tr>
		</table>
	</div>

	<div id="lista_proyectos">
		
		<div id="cabecera_tabla">
			
			<table>
			<caption>
			Lista de Proyectos
			</caption>
				<thead>
					<tr>
						<th class="proyecto">Proyecto</th>
						
						<th class="tipo_proyecto">Tipo</th>
						<th class="prioridad_proyecto">Prioridad</th>
						<th>Fecha Inicio</th>
						<th>Fecha Fin</th>
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