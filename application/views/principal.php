<?php
  echo "<pre>";
  // print_r($this->session->all_userdata());
  echo "</pre>"
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Principal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Le styles -->
    <link href="<?php echo base_url();?>css/bootstrap/css/bootstrap.css" rel="stylesheet">
    

    <link rel="shortcut icon" href="<?php echo base_url();?>imagenes/favicon.ico">
    <link href="<?php echo base_url();?>css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/estilos.css" rel="stylesheet">

  </head>
  <body>
    
    <?php include_once "assets/menu/m_principal.php"; ?>
    <DIV align="center" class='container'>
        <div id="data">
            
            <h1 class="text-info">Bienvenido <?php echo $this->session->userdata('usuario'); ?></h1>
        </div>
        
    </DIV>
    
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-transition.js"></script>
    <!--script src="<?php echo base_url();?>assets/js/bootstrap-alert.js"></script-->
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
    <script src="<?php echo base_url();?>assets/js/funcionesJS.js"></script>
  </body>
</html>
