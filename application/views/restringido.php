<?php
  echo "<pre>";
  //print_r($this->session->all_userdata());
  echo "</pre>"
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Restringido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url();?>css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo base_url();?>imagenes/favicon.ico">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="<?php echo base_url();?>css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    
  </head>
  <body>
  
    <DIV align="center">
    <h1>No tienes permisos para ingresar a la aplicacion</h1>
        
        <!--h1 class="text-info">Bienvenido al Sistema</h1--><br>
        <a href="<?php echo base_url();?>main/login">Regresar</a>
    </DIV>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-transition.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-alert.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-modal.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-tab.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-popover.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-button.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-collapse.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-carousel.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
