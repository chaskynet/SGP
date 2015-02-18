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

<!-- Ventana para Importacion de Presupuesto de Mano de Obra-->
	<div id="form_importar_mano_obra" class="messagepop pop">
		<form method="post" action="" id="upload_file_mano_obra">
		    <label for="userfile">Archivo: </label>
		    <input type="file" name="userfile" id="userfile" size="20" />
			<br>
			<br>
		    <input type="submit" name="submit" id="submit" value="Subir Archivo" />
    	</form>
    	<label for="archivo_subido">Archivo Subido: </label>
		<span id="archivo_subido_presu_mano_obra"></span>
	</div>
<!-- Fin ventana Importacion de Presupuesto de Mano de Obra -->
<!-- Ventana para Importacion de Presupuesto de Materiales -->
	<div id="form_importar_materiales" class="messagepop pop">
		<form method="post" action="" id="upload_file_materiales">
		    <label for="userfile">Archivo: </label>
		    <input type="file" name="userfile" id="userfiles" size="20" />
			<br>
			<br>
		    <input type="submit" name="submit" id="submit" value="Subir Archivo" />
    	</form>
    	<label for="archivo_subido">Archivo Subido: </label>
		<span id="archivo_subido_presu_materiales"></span>
	</div>
<!-- Fin ventana Importacion de Presupuesto de Materiales -->
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
					
					<select id="codigo_subproyecto">
						<option></option>
					</select>
				</td>
			</tr>
			<tr>
				<td><a href='#' id='imp_presu_mano_obra'>Importar Presupuesto Mano de Obra:</a></td>
				<td id='presu_mano_obra'></td>
			</tr>
			<tr>
				<td><a href="#" id='imp_presu_materiales'>Importar Presupuesto de Materiales:</a></td>
				<td id='presu_materiales'></td>
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