<!DOCTYPE html>
<html lang="es">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/estilos.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/calendario.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/estilo_tablas.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/jquery-ui/jquery-ui.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/popup.css" />
	<!--script src="../assets/js/calendar.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-es.js" type="text/javascript"></script>
	<script src="../assets/js/calendar-setup.js" type="text/javascript"></script-->
	<script src="../assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="../assets/js/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/AjaxFileUploader/ajaxfileupload.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/funcionesJSpreLiquidacion.js" type="text/javascript"></script>
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
			<h1>Preliquidacion</h1>
		</center>
	</div>
	<div id="cabecera_preliquidacion" class="cabecera_preliquidacion">
		<div id="cuerpo_unidades">
			<table id="cuerpo_tabla_proySubproy" class="cuerpo_tabla_unid">
				<tfoot>
					<tr>
						<td>
							<input type="button" id="guardar" value="Guardar" class="btn" />
						</td>
					</tr>
				</tfoot>
				<caption>
					Detalle de SubProyecto
					<!-- <img src="../imagenes/plus.ico" data-pry="" class="plus_icon" id="btn_busca_articulos"> -->
				</caption>

				<thead>
					<tr>
						<th>Código</th>
						<th>Descripción</th>
						<th>Unidad</th>
						<th>Ref.</th>
						<th>Pres.</th>
						<th>Retirado</th>
						<th>ReUsado</th>
						<th>Nuevo</th>
						<th>Observacion</th>
					</tr>
				</thead>
				
				<tbody>
					
				</tbody>
				
			</table>
	</div>

	</div>
	<div id="lista_proyectos_preliquidacion">
		<div id="cabecera_tabla">
			
			<table>
			<caption>
			Lista de Proyectos a PreLiquidar
			</caption>
				<thead>
					<tr>
						<th class="proyecto">Proyecto SubProyecto</th>
						
						<th class="tipo_proyecto">Avance</th>
						
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