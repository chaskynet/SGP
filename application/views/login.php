<!doctype html>
<html>
<head>
	<meta charset = "utf-8">
	<title>
		Login Sistema de Gestion de Proyectos
	</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/estilos.css">
	<link rel="shortcut icon" href="<?php echo base_url();?>imagenes/favicon.ico">

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
	
</head>
<body>
	<div id="loginBox">
	
			<!--img src="<?php echo base_url();?>imagenes/logoriente.jpg" class="cabeceraDePagina_login"-->
	<?php 
		echo form_open('main/login_validation');
	?>
	<table id="loginTable">
		<tbody>
			<tr>
				<td colspan="3" style="text-align: center;padding-top:6px;"><?php echo validation_errors();?></td>
			</tr>
			<tr>
				<td rowspan="2"><img src="<?php echo base_url();?>imagenes/llaves.png" class="llaves"></td>
				<td>Usuario: </td>
				<td><?php echo form_input('usuario',NULL, 'autofocus'); ?></td>
			</tr>
			<tr>
				<td>Contrase&ntilde;a: </td>
				<td><?php echo form_password('password'); ?></td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center;padding-top:6px;"><?php echo form_submit('login_submit', 'Ingresar')?></td>
			</tr>
		</tbody>
		</table>
	<?php
		echo form_close();
	?>
	</div>
</body>
</html>