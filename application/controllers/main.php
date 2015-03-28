<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->database();

		$this->load->library('grocery_CRUD');
		//$this->load->library('excel');
	}

	public function _principal_output($output = null)
	{
		$this->load->view('principal.php',$output);
	}
/********* Funciones GroceryCrud para Modulo Proyectos *********/
//----------- Creacion de Proyectos Version hecha a mano -------/
	public function iframeRegProyectos(){
		$this->load->view('proyectos/iframeRegProyectos');
	}

	public function registro_proyectos(){
		
		echo $this->load->view('proyectos/regProyectos');
	}

	public function carga_tipo_proy(){
		$query = $this->db->query("select desc_tipo_proy as tipo_proyecto from tipo_proyecto");
		foreach ($query->result() as $row) 
		{ 
			echo '<option value="'.$row->tipo_proyecto.'" >';
	 	 }
	}

	public function carga_naturaleza_proy(){
		$query = $this->db->query("select distinct(desc_naturaleza) as naturaleza_proyecto from naturaleza_proy");
		foreach ($query->result() as $row) 
		{ 
			echo '<option value="'.$row->naturaleza_proyecto.'" >';
	 	 }
	}

	public function carga_prioridad_proy(){
		$query = $this->db->query("select desc_prioridad as prioridad_proyecto from prioridad_proy");
		foreach ($query->result() as $row) 
		{ 
			echo '<option value="'.$row->prioridad_proyecto.'" >';
	 	 }
	}

	public function dias_por_tipo(){
		$tempo = json_decode($_POST['data']);
		$query_localizacion = $this->db->query('SELECT localizacion FROM localizacion WHERE id_localizacion = '.$tempo->localiza);
		foreach ($query_localizacion->result() as $key) {
			$localiza = $key->localizacion;
		}
		//echo $localiza.'--'.$tempo->tipo;
		if ($localiza === 'URBANO'){
			$query = $this->db->query("select urbano as dias from tipo_proyecto where id_tipo_proy = '".$tempo->tipo."'");
		}else if ($localiza === 'RURAL'){
			$query = $this->db->query("select rural as dias from tipo_proyecto where id_tipo_proy = '".$tempo->tipo."'");
		}else if ($localiza === 'TROPICO'){
			$query = $this->db->query("select tropico as dias from tipo_proyecto where id_tipo_proy = '".$tempo->tipo."'");
		}
		
		$date = DateTime::createFromFormat('d/m/Y', $tempo->fecha_ini);
		$fecha= $date->format('Y-m-d');
		
		foreach ($query->result() as $row) 
		{ 
			$fecha = strtotime($fecha);//$tempo->fecha_ini);
			$nueva_fecha = date('d/m/Y',strtotime('+'.$row->dias.' days', $fecha));
			echo $nueva_fecha;
			//return('1');
	 	 }
	}

	public function guarda_proyecto(){
		$tempo = json_decode($_POST['data']);
		//$tmp = $this->codigo_orden_servicio();
		//$this->new_code_osrv = $tmp;
		$query = $this->db->query("insert into proyecto (id_proyecto, num_sub_proyectos, tipo_proyecto, localizacion, prioridad, responsable, naturaleza, fecha_inicio, fecha_fin) values('".$tempo->codigo."', '".$tempo->numsubproy."', '".$tempo->tipo."', '".$tempo->localizacion."', '".$tempo->prioridad."', '".$tempo->responsable."', '".$tempo->naturaleza."', STR_TO_DATE(REPLACE('".$tempo->fecha_ini."','-','.') ,GET_FORMAT(date,'EUR')), STR_TO_DATE(REPLACE('".$tempo->fecha_fin."','-','.') ,GET_FORMAT(date,'EUR')))");
	}

	public function lista_proyectos(){
		$query = $this->db->query("select * from proyecto");
		foreach ($query->result() as $row) 
		{ 
			echo "<tr><td class='proyecto'>".$row->id_proyecto."</td><td class='tipo_proyecto'>".$row->tipo_proyecto."</td><td class='prioridad_proyecto'>".$row->prioridad."</td><td>".$row->fecha_inicio."</td><td>".$row->fecha_fin."</td><tr>";
	 	 }
	}

	//---------- Registro de Proyectos Version GROSERY CRUD -------//
	public function prueba(){
		echo "holaa";
	}
	public function iframeRegProyectos2(){
		$this->load->view('proyectos/iframeRegProyectos2');
	}

	public function registro_proyectos2(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Proyecto');
		$crud->set_table('proyecto');

		$crud->required_fields('id_proyecto', 'num_sub_proyectos', 'tipo_proyecto', 'localizacion', 'prioridad', 'responsable', 'naturaleza', 'fecha_inicio', 'fecha_fin', 'fecha_entrega_asbuilt', 'distancia');

		$crud->set_relation("tipo_proyecto", "tipo_proyecto", "desc_tipo_proy");
		$crud->set_relation("prioridad", "prioridad_proy", "desc_prioridad");
		$crud->set_relation("tipo_proyecto", "tipo_proyecto", "desc_tipo_proy");
		$crud->set_relation("localizacion", "localizacion", "localizacion");
		$crud->set_relation("responsable", "responsable", "nombre_responsable");
		$crud->set_relation("naturaleza", "naturaleza_proy", "desc_naturaleza");

		$crud->display_as('fecha_entrega_asbuilt', 'Fecha entrega de As Built');

		$crud->unset_columns('fecha_asbuilt_1', 'fecha_asbuilt_2');

		$crud->unique_fields('id_proyecto');

		$usuario = $this->session->userdata('usuario');
		$rol = $this->db->query('SELECT rol FROM usuarios where uname = "'.$usuario.'"');
		foreach ($rol->result() as $key) {
			$rol = $key->rol;
		}
		if ($rol != 4){
			$crud->unset_edit();
			$crud->unset_delete();
		}

		$crud->add_action('Actualizar Proyecto', '', 'main/iframeRegSubPryUnid', 'ico_update');

		$crud->callback_column('fecha_fin', array($this,'modifica_color'));
		//$crud->callback_column('id_proyecto', array($this, 'muestra_postergacion'));

		$crud->set_field_upload("asbuilt", "assets/uploads/files");

		$crud->callback_before_delete(array($this,'borra_subproyectos_unidades'));

		$output = $crud->render();

		echo $this->load->view('proyectos/regProyectos2', $output, true);
		//echo $this->load->view('proyectos/regProyectos2');
	}
	function modifica_color($value, $row){
		$value1 = $row->id_proyecto;
		 $query_postergado = $this->db->query("SELECT fecha, motivo FROM posterga_proyecto where id_proyecto= '".$value1."'");
		 $cadena = '';
		if($query_postergado->num_rows()>0){
			foreach ($query_postergado->result() as $key) {
				$fecha = $key->fecha;
				$motivo = $key->motivo;
			}
		}

		$query_avance = $this->db->query('SELECT avance FROM avance_subproyecto WHERE id_proyecto = '.$value1);
		if($query_avance->num_rows()>0){
			foreach ($query_avance->result() as $key) {
				$avance = $key->avance;
			}
		}
		else{
			$avance = 0;
		}

		$hoy = date('Y-m-j');
		$operacion = strtotime($value) - strtotime($hoy);
		$operacion = $operacion/60/60/24;
		$operacion = $operacion +0;

		if ($operacion === 3)
			return "<script>$('#flex1 tbody tr td:contains(".$value.")').css('background-color','#fffe9e');</script>".$value;
		elseif ($operacion < 3){
			return "<script>$('#flex1 tbody tr td:contains(".$value.")').css({'background-color': '#db090a', 'color': '#ffffff'});</script><a href='' onclick=alert('".$avance."%&nbsp;de&nbsp;Avance&nbsp;\\n".$operacion."&nbsp;dias&nbsp;de&nbsp;Retrazo&nbsp\\nPenalizacion:&nbsp;0.00');>".$value."</a>";
		}
		elseif ($operacion > 3)
			return "<script>$('#flex1 tbody tr td:contains(".$value.")').css('background-color','#8bff9c');	</script>".$value;
	}
	function muestra_postergacion($value, $row){
		$value1 = $value;
		$query_postergado = $this->db->query("SELECT fecha, motivo FROM posterga_proyecto where id_proyecto= '".$value."'");
		if($query_postergado->num_rows()>0){
			foreach ($query_postergado->result() as $key) {
				$fecha = $key->fecha;
				$motivo = $key->motivo;
			}
			//return("<a href='#' onclick=alert('Fecha&nbsp;de&nbsp;Postergacion:&nbsp;".$fecha."&nbsp;Motivo&nbsp;de&nbsp;Postergacion:&nbsp;".$motivo."');>".$value."</a>");
			//return "<script>$('#flex1 tbody tr td:contains(".$value1.")').css({'background-color': '#db090a', 'color': '#fffff'});</script>".$value;
			$aa = 'aa';
			return ("<a href= onclick=alert();>".$value."</a>");
		}	
		else{
			return $value;
		}
	}

	public function borra_subproyectos_unidades($primary_key){
		// $this->db->where('id_proyecto',$primary_key);
  //   	$user = $this->db->get('proyecto')->row();

    	$this->db->query('DELETE FROM pry_subpry_unid WHERE id_proyecto='.$primary_key);
    	$this->db->query('DELETE FROM avance_subproyecto WHERE id_proyecto='.$primary_key);
    	$this->db->query('DELETE FROM presup_mano_obra WHERE id_proyecto='.$primary_key);
    	$this->db->query('DELETE FROM presup_materiales WHERE id_proyecto='.$primary_key);
	}
	//---------- Registro de Proyectos-SubProyecto Version GROSERY CRUD -------//
	public function iframeRegPrySubPry(){
		$this->load->view('proyectos/iframeRegPrySubPry');
	}

	public function registro_proyecto_subproyecto(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Creacion de Proyectos-SubProyectos');
		$crud->set_table('pry_subpry_unid');

		$output = $crud->render();

		echo $this->load->view('proyectos/regPrySubPry', $output, true);
		//echo $this->load->view('proyectos/regProyectos2');
	}

	public function buscaUnidades(){
		//echo ("SELECT distinct(cod_unidad) as cod_unidad, descripcion from unidades where descripcion like '%".$_POST["data"]."%'");
		$query = $this->db->query("SELECT distinct(cod_unidad) as cod_unidad, descripcion from unidades where cod_unidad like '%".$_POST["data"]."%' or descripcion like '%".$_POST["data"]."%'");
		foreach ($query->result() as $key) 
		{ 
			echo '<div class="fila_cuerpo">'.
                   '<div class="columna procedencia">'.
                   '<input type="checkbox" name="articulo[]" value="'.
                    $key->descripcion.
                   ' " id="'.
                    $key->cod_unidad.
                   ' ">'.
                   $key->cod_unidad.
                   '</div><div class="columna descripcion">'.
                   $key->descripcion.
                   '</div>'.
           '</div>';
	 	 }
	}

	public function buscadorDeUnidades(){
		//echo ("SELECT distinct(cod_unidad) as cod_unidad, descripcion from unidades where descripcion like '%".$_POST["data"]."%'");
		$query = $this->db->query("SELECT distinct(cod_unidad) as cod_unidad, descripcion from unidades where cod_unidad like '%".$_POST["data"]."%' or descripcion like '%".$_POST["data"]."%'");
		foreach ($query->result() as $row) 
		{ 
			echo "<tr id='unidad'><td style='height: 25px;' id='codigo_elemento_unidad'>".$row->cod_unidad."</td><td class='tipo_proyecto' id='descripcion'>".$row->descripcion."</td><tr>";
	 	 }
	}

	public function carga_proyecto_subproyecto(){
		$query = $this->db->query("SELECT distinct(CONCAT(id_proyecto, '-', id_sub_proy)) as proySubproy, cod_unidad FROM `pry_subpry_unid` order by CONCAT(id_proyecto, '-', id_sub_proy) asc");
		foreach ($query->result() as $row) 
		{ 
			echo "<tr><td style='height: 25px;' id='proysubproy'>".$row->proySubproy."</td><td class='tipo_proyecto'>".$row->cod_unidad."</td><tr>";
	 	 }
	}

	public function carga_cod_proyectos(){
		$query = $this->db->query("SELECT id_proyecto FROM `proyecto` ");
		foreach ($query->result() as $row) 
		{ 
			echo "<option>".$row->id_proyecto."</option>";
	 	 }
	}

	public function calcula_sub_proyectos(){
		$query = $this->db->query("SELECT num_sub_proyectos FROM `proyecto` where id_proyecto = ".$_POST['data']);
		foreach ($query->result() as $row) 
		{ 
			$numero = $row->num_sub_proyectos;
	 	 }
		for ($i = 1; $i<= $numero; $i++){
			echo "<option>".$i."</option>";
		}
	}
	//---------------- Guarda Cabecera de Unidad y Articulos Asociados a la unidad-----------------------------------//
	public function guarga_proyecto_subproyecto(){

		$tempo = json_decode($_POST['data2']);
		$tempo1 = json_decode($_POST['data2'], true);
		//echo $query = "delete from pry_subpry_unid where id_proyecto=".$tempo1[0]['codigo_proyecto']." and id_sub_proy = ".$tempo1[0]['codigo_subproyecto'];
		$query1 = $this->db->query("delete from pry_subpry_unid where id_proyecto=".$tempo1[0]['codigo_proyecto']." and id_sub_proy = ".$tempo1[0]['codigo_subproyecto']);
		
		foreach ($tempo as $key) 
		{
			$query = $this->db->query("insert into pry_subpry_unid (id_proyecto, id_sub_proy, cod_unidad, desc_unidad, cantidad, cuenta, propiedad, codigo_fab, desc_item, unidad, arch_presu_mano, arch_presu_mate) SELECT '".$key->codigo_proyecto."', '".$key->codigo_subproyecto."', u.cod_unidad, u.descripcion, u.cantidad,'".$key->cuenta."', '".$key->propietario."', codigo_fab, descripcion_item, unidad, '".$key->arch_presu_mano."', '".$key->arch_presu_mate."' from unidades u where u.cod_unidad = '".$key->codigo_unidad."'");
		}
	}
	//----------------- Trae datos de presupuesto mano de Obra -------------------//
	public function carga_datos_presu_mano_obra(){
		$tempo = json_decode($_POST['data']);
		$cadena = 'SELECT * FROM presup_mano_obra WHERE id_proyecto = '.$tempo->proyecto.' AND id_subproyecto='.$tempo->subproyecto;
		$resultado = $this->db->query($cadena);
		foreach ($resultado->result() as $key) {
			echo '<div class="fila_cuerpo">'.
					'<div class="columna">'.
						$key->nro.
					'</div><div class="columna descripcion">'.
						$key->id_proyecto.
					'</div><div class="columna descripcion">'.
						$key->id_subproyecto.
					'</div><div class="columna descripcion">'.
						$key->id_produc.
					'</div><div class="columna descripcion">'.
						$key->codigo.
					'</div><div class="columna descripcion">'.
						$key->descripcion.
					'</div><div class="columna descripcion">'.
						$key->presup.
					'</div><div class="columna descripcion">'.
						$key->incremento.
					'</div><div class="columna descripcion">'.
						$key->decremento.
					'</div><div class="columna descripcion">'.
						$key->cantidad.
					'</div><div class="columna descripcion">'.
						$key->precio.
					'</div><div class="columna descripcion">'.
						$key->total.
					'</div>'.
				'</div>';
		}
	}
	//----------------- Trae datos de presupuesto materiales -------------------//
	public function carga_datos_presu_materiales(){
		$tempo = json_decode($_POST['data']);
		$cadena = 'SELECT * FROM presup_materiales WHERE id_proyecto = '.$tempo->proyecto.' AND id_subproyecto='.$tempo->subproyecto;
		$resultado = $this->db->query($cadena);
		foreach ($resultado->result() as $key) {
			echo '<div class="fila_cuerpo">'.
					'<div class="columna">'.
						$key->nro.
					'</div><div class="columna descripcion">'.
						$key->id_proyecto.
					'</div><div class="columna descripcion">'.
						$key->id_subproyecto.
					'</div><div class="columna descripcion">'.
						$key->id_produc.
					'</div><div class="columna descripcion">'.
						$key->tipo.
					'</div><div class="columna descripcion">'.
						$key->codigo.
					'</div><div class="columna descripcion">'.
						$key->producto.
					'</div><div class="columna descripcion">'.
						$key->descripcion.
					'</div><div class="columna descripcion">'.
						$key->unidad.
					'</div><div class="columna descripcion">'.
						$key->cantidad.
					'</div><div class="columna descripcion">'.
						$key->estado.
					'</div>'.
				'</div>';
		}
	}
	//----------------- Para editar proyecto sub Proyecto ------------------------//
	public function trae_proysubproy(){
		$resultado = $this->db->query("SELECT distinct(id_proyecto) as id_proyecto, id_sub_proy, cuenta, propiedad, arch_presu_mano, arch_presu_mate FROM `pry_subpry_unid` where concat(id_proyecto,'-', id_sub_proy)='".$_POST['dato']."'");
		$i = 0;
		foreach ($resultado->result() as $row) 
			{ 
				$jsondata[$i]['id_proyecto'] = $row->id_proyecto;
    			$jsondata[$i]['id_sub_proy'] = $row->id_sub_proy;
    			$jsondata[$i]['cuenta'] = $row->cuenta;
    			$jsondata[$i]['propiedad'] = $row->propiedad;
    			$jsondata[$i]['arch_presu_mano'] = $row->arch_presu_mano;
    			$jsondata[$i]['arch_presu_mate'] = $row->arch_presu_mate;
    			$i++;
		 	 }
		 echo json_encode($jsondata);
	}
	public function trae_unidades_asociadas(){
		$resultado = $this->db->query("SELECT distinct(cod_unidad) as cod_unidad, desc_unidad FROM `pry_subpry_unid` where concat(id_proyecto,'-', id_sub_proy)='".$_POST['dato']."'");

		foreach ($resultado->result() as $row) 
			{ 
				echo "<tr style='height:25px;'><td class='columna acciones'><a href='#' id='elimina_prod' >Eliminar</a></td><td class='columna descripcion' id='codigo'>".$row->cod_unidad."</td><td class='columna descripcion' id='descripcion'>".$row->desc_unidad."</td>";
		 	}
	}
//------------------ Postergacion de Proyectos ---------------/
	public function iframeRegPostergaPry(){
		$this->load->view('proyectos/iframeRegPostergaPry');
	}
	public function registro_posterga_proyecto(){
		$crud = new grocery_CRUD();
		$crud->set_table('posterga_proyecto');
		//$crud->set_subject('Postergacion de proeyectos');

		$crud->set_relation('id_proyecto', 'proyecto', 'id_proyecto');

		$crud->required_fields('id_proyecto', 'fecha', 'dias', 'motivo');

		$output = $crud->render();
		echo $this->load->view('proyectos/regPostergaPry', $output, true);
	}
/*************************************************************/
/******* Funciones GroceryCrud para Modulo Configuraciones ********/
	//------- Para registro de Usuarios ------------//
	public function iframeUsr(){
		$this->load->view('backend/iframeRegUsr');
	}
	public function regusr(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Creacion de Usuarios');
		$crud->set_table('usuarios');

		$crud->change_field_type('password', 'password');

		$crud->display_as('uname', 'Nombre de Usuario');
		$crud->display_as('apaterno', 'Apellido Paterno');
		$crud->display_as('amaterno', 'Apellido Materno');

		$crud->set_relation('estado_usuario', 'catalogo', 'valor', array('nombre' => 'estado_usuario'));
		$crud->set_relation('rol', 'catalogo', 'valor', array('nombre' => 'rol_usuario'));

		$crud->required_fields('uname', 'password', 'nombre', 'apaterno', 'ci', 'rol', 'estado_usuario');

		$crud->unique_fields('uname', 'ci');

		$crud->callback_before_insert(array($this,'encripta_password'));
		$crud->callback_before_update(array($this,'encripta_password'));

		$output = $crud->render();
		echo $this->load->view('backend/regusuarios', $output, true);
	}
	public function encripta_password($post_array){
		$cadena = $post_array['password'];
		$encriptado = do_hash($cadena, 'md5');
		$post_array['password'] = $encriptado;
		return $post_array;
	}
 //------- Para Registro de Responsable ------------
	public function iframeRegResponsable(){
		$this->load->view('responsables/iframeRegResponsable');
	}
	public function registro_responsable(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Responsables');
		$crud->set_table('responsable');

		$crud->display_as('nombre_responsable', 'Responsable');

		$crud->required_fields('nombre_responsable');

		$output = $crud->render();
		echo $this->load->view('responsables/regResponsable', $output, true);
	}

 //------- Para registro de Tipo de Proyecto --------
	public function iframeTipoProyecto(){
		$this->load->view('backend/iframeTipoProyecto');
	}
	public function regTipoProyecto(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Tiempos por Tipo de Proyecto');
		$crud->set_table('tipo_proyecto');

		$crud->display_as('desc_tipo_proy', 'Descripcion del Proyecto');

		$crud->required_fields('desc_tipo_proy', 'urbano', 'rural', 'tropico');

		$output = $crud->render();
		echo $this->load->view('backend/regTipoProyecto', $output, true);
	}
//------------------ Obseraciones del Supervisor ---------------/
	public function iframeRegObseraciones(){
		$this->load->view('backend/iframeRegObservaciones');
	}
	public function regObservaciones(){
		$crud = new grocery_CRUD();
		$crud->set_table('observaciones_sup');
		//$crud->set_subject('Postergacion de proeyectos');

		$output = $crud->render();
		echo $this->load->view('backend/regObservaciones', $output, true);
	}
//-------------------------------------------------------------------------------/
	public function iframeNaturaProyecto(){
		$this->load->view('backend/iframeNaturaProyecto');
	}
	public function regNaturaProyecto(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Naturaleza de Proyecto');
		$crud->set_table('naturaleza_proy');

		$crud->display_as('desc_naturaleza', 'Naturaleza del Proyecto');

		$output = $crud->render();
		echo $this->load->view('backend/regNaturaProyecto', $output, true);
	}
//-------------------------------------------------------------------------------/
	public function iframePrioridadProyecto(){
		$this->load->view('backend/iframePrioridadProyecto');
	}
	public function regPrioridadProyecto(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Prioridad de Proyecto');
		$crud->set_table('prioridad_proy');

		$crud->display_as('desc_prioridad', 'Descripcion Prioridad');

		$output = $crud->render();
		echo $this->load->view('backend/regPrioridadProyecto', $output, true);
	}
//-------------------- Adjuntar Documentos a Proyecto ----------------------------------------------------/

	public function selProySubProy(){
		$this->load->view('ImportarDatos/selProySubProy');
	}
	public function selTipoArch(){
		$this->load->library('javascript');
		$crud = new grocery_CRUD();
		//$crud->set_theme("datatables");
		$crud->set_table('importa_datos');
		$crud->set_relation("proyecto", "proyecto", "id_proyecto");
		$crud->set_subject('Documentos');
		
		$crud->callback_add_field('sub_proyecto', function ($this) {
		$cadena = '';
			// $query = $this->db->query("SELECT num_sub_proyectos FROM `proyecto` where id_proyecto = ".$_POST['data']);
			// foreach ($query->result() as $row) 
			// { 
			// 	$numero = $row->num_sub_proyectos;
		 // 	 }
			// for ($i = 1; $i<= $numero; $i++){
			// 	$cadena .= "<option>".$i."</option>";
			// }
        	return $cadena.'-'.$this['proyecto'];
    	});

		$crud->set_field_upload("archivo", "assets/uploads/files");

		$output = $crud->render();
		echo $this->load->view('ImportarDatos/selTipoArch', $output, true);
	}

//-------------------------------------------------------------------------------/
	public function iframeRegUbiSat(){
		$this->load->view('backend/iframeUbiSat');
	}
	public function regUbiSat(){
	$this->load->library('googlemaps');

	//$config['center'] = '37.4419, -122.1419';
	$config['zoom'] = 'auto';
	$config['map_height'] = '100%';
	$config['onboundschanged'] = 'if (!centreGot) {
	var mapCentre = map.getCenter();
	marker_0.setOptions({
		position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) 
	});
	}
	centreGot = true;';
	$this->googlemaps->initialize($config);

	$marker = array();
	$marker['position'] = '-17.392719, -66.158779'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A1 - Sub proyecto #232';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.392566, -66.157803'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A2 - Sub proyecto #232!';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.394357, -66.157449';//'37.449, -122.1419';
	$marker['onclick'] = 'alert("Poste A7 - Sub proyecto 123 (Pendiente de conciliacion!!")';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.394552, -66.158415';//'37.409, -122.1319';
	$marker['infowindow_content'] = 'Poste A8 - Pendiente de Asignacion!';
	$marker['draggable'] = TRUE;
	$marker['animation'] = 'DROP';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.394757, -66.158329';//'37.409, -122.1319';
	$marker['infowindow_content'] = 'Poste A9 - OK!';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
	$marker['draggable'] = TRUE;
	$marker['animation'] = 'DROP';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.392428, -66.158979'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A16 - ';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|99FFFF|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.391650, -66.159215'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A17 - Reponiendoce';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|99999F|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.391773, -66.159987'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A18 - Pendiente de Reparación';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|99999F|000000';
	$this->googlemaps->add_marker($marker);

	$data['map'] = $this->googlemaps->create_map();

		echo $this->load->view('backend/regUbiSat', $data);
	}
//------------------------------------------------------------//
	public function iframeRegMateriales(){
		$this->load->view('materiales/iframeRegMateriales');
	}
	public function registro_materiales(){
		$crud = new grocery_CRUD();
		

		$crud->set_table('materiales');
		//$crud->set_relation("proyecto", "proyecto", "id_proyecto");
		$crud->set_subject('Registro de materiales');
		$crud->required_fields('codigo_fab', 'descripcion', 'unidad', 'costo');

		//$crud->set_field_upload("archivo", "assets/uploads/files");

		$output = $crud->render();
		echo $this->load->view('materiales/regMateriales', $output, true);
	}
	
	//------- Importacion de Materiales desde Excel ------//
	public function upload_file()
	{
		$status = "";
		$msg = "";
		$file_element_name = 'userfile';
		 
		 
		if ($status != "error")
		{
		    $config['upload_path'] = './assets/uploads/files/';
		    $config['allowed_types'] = 'xlsx|xls';
		    $config['max_size'] = 1024 * 8;
		    $config['encrypt_name'] = FALSE;

		    $this->load->library('upload', $config);

		    if (!$this->upload->do_upload($file_element_name))
		    {
		        $status = 'error';
		        $msg = $this->upload->display_errors('', '');
		    }
		    else
		    {
		        $data = $this->upload->data();

		             $msg = "Archivo subido correctamente!";
		    }
		    @unlink($_FILES[$file_element_name]);
		}
		echo json_encode(array('status' => $status, 'msg' => $msg, 'archivo' => $data['file_name']));
	}

	public function importarMateriales(){
		$file = './assets/uploads/files/'.$_POST['data'];//'./files/test.xlsx';
		//load the excel library
		$this->load->library('excel');
		$nombreArchivo = $file; //'../Archivos/'.$_FILES['archivoArticulos']['name'];
		$columnas=PHPepeExcel::xls2array($nombreArchivo);
		$options = array ('start' => 1, 'limit'=>20000);
		$query = PHPepeExcel::xls2sql ( $nombreArchivo, array ("codigo_fab", "descripcion", "unidad", "costo",), "materiales", $options );
		$this->db->query($query);
	}

	public function importarManoObra(){
		$file = './assets/uploads/files/'.$_POST['data'];
		//load the excel library
		$this->load->library('excel');
		$nombreArchivo = $file; //'../Archivos/'.$_FILES['archivoArticulos']['name'];
		$columnas=PHPepeExcel::xls2array($nombreArchivo);
		$options = array ('start' => 1, 'limit'=>20000);
		$query = PHPepeExcel::xls2sql ( $nombreArchivo, array ("codigo_fab", "descripcion", "unidad", "costo",), "mano_de_obra", $options );

		$this->db->query($query);
		
	}

public function importarUnidades(){
		$file = './assets/uploads/files/'.$_POST['data'];//'./files/test.xlsx';
		//load the excel library
		$this->load->library('excel');
		$nombreArchivo = $file; //'../Archivos/'.$_FILES['archivoArticulos']['name'];
		$columnas=PHPepeExcel::xls2array($nombreArchivo);
		$options = array ('start' => 1, 'limit'=>20000);
		$query = PHPepeExcel::xls2sql ( $nombreArchivo, array ("cod_unidad", "idproducto", "descripcion", "cantidad", "codigo_fab", "idproducto_fab", "descripcion_item", "unidad",), "unidades", $options );

		$this->db->query($query);
		
	}

public function importarPresuManoObra(){
	$tempo = json_decode($_POST['data']);	
	$file = './assets/uploads/files/'.$tempo->archivo;//'./files/test.xlsx';
	//$file = './assets/uploads/files/Presupuesto Mano de Obra.xls';
	//load the excel library
	$this->load->library('excel2');
	$nombreArchivo = $file; //'../Archivos/'.$_FILES['archivoArticulos']['name'];
	
	$objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
	$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

	foreach ($cell_collection as $cell) {
	    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
	    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
	    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
	    //header will/should be in row 1 only. of course this can be modified to suit your need.
	    if ($row == 1) {

	        $header[$row][$column] = $data_value;
		    }
		elseif ($data_value == 'Importe a Facturar:'){
			break;
		}
		else {
		        $arr_data[$row][$column] = $data_value;
		    }
	}
	
	$cuenta = $arr_data[5]['M'];
	array_splice($arr_data, '0', 8);

	//$cadena = '';
	foreach ($arr_data as $key => $value) {
		$cadena ='insert into presup_mano_obra (id_presup, id_proyecto, id_subproyecto, nro, id_produc, codigo, descripcion, presup, incremento, decremento, cantidad, precio, total) values("","'.$tempo->id_proyecto.'","'.$tempo->id_sub_proy.'"';
		foreach ($value as $key1 => $value1) {
			 $cadena .=",'".$value1."'";
		}
		$cadena .=');';
		$query = $this->db->query($cadena);
		//echo $cadena;
	}
	
	// print_r($arr_data);
	//$data['header'] = $header;
	//$data['values'] = $arr_data;
	echo $cuenta;
}

public function importarPresuMateriales(){
	$tempo = json_decode($_POST['data']);	
	$file = './assets/uploads/files/'.$tempo->archivo;//'./files/test.xlsx';
	//$file = './assets/uploads/files/Presupuesto Materiales.xls';
	//load the excel library
	$this->load->library('excel2');
	$nombreArchivo = $file; //'../Archivos/'.$_FILES['archivoArticulos']['name'];
	
	$objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
	$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

	foreach ($cell_collection as $cell) {
	    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
	    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
	    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
	    //header will/should be in row 1 only. of course this can be modified to suit your need.
	    if ($row == 1) {
	        $header[$row][$column] = $data_value;
		    }
		elseif ($data_value == 'GERENCIA que autoriza'){
			break;
		}
		else {
		        $arr_data[$row][$column] = $data_value;
		    }
	}
	array_splice($arr_data, '0', 11);

	foreach ($arr_data as $key => $value) {
		$cadena ='insert into presup_materiales (id_presup, id_proyecto, id_subproyecto, nro, tipo, codigo, producto, descripcion, unidad, cantidad, estado) values("","'.$tempo->id_proyecto.'","'.$tempo->id_sub_proy.'"';
		foreach ($value as $key1 => $value1) {
			 $cadena .=",'".$value1."'";
		}
		$cadena .=');';
		$query = $this->db->query($cadena);
		//echo $cadena;
	}
	 //print_r($arr_data);
	//$data['header'] = $header;
	//$data['values'] = $arr_data;
}
//------------------------------------------------------------//
	public function iframeRegManoObra(){
		$this->load->view('mano_de_obra/iframeRegManoObra');
	}
	public function registro_mano_de_obra(){
		$crud = new grocery_CRUD();

		$crud->set_table('mano_de_obra');
		//$crud->set_relation("proyecto", "proyecto", "id_proyecto");
		$crud->set_subject('Registro de Mano de Obra');
		$crud->required_fields('codigo_fab', 'descripcion', 'unidad', 'costo');

		//$crud->set_field_upload("archivo", "assets/uploads/files");

		$output = $crud->render();
		echo $this->load->view('mano_de_obra/regManoObra', $output, true);
	}
//---------------- Registro de Unidades version GroceryCrud ---//
	public function iframeRegUnidades2(){
		$this->load->view('unidades/iframeRegUnidades2');
	}
	public function registro_unidades2(){
		$crud = new grocery_CRUD();

		$crud->set_table('unidades');
		//$crud->set_relation("proyecto", "proyecto", "id_proyecto");
		$crud->set_subject('Registro de Unidades');

		$crud->display_as('cod_unidad', 'Unidad Cons.');
		$crud->display_as('idproducto', 'Id Producto');
		$crud->display_as('codigo_fab', 'Código Fab.');
		$crud->display_as('idproducto_fab', 'Id Producto Fab.');
		$crud->display_as('descripcion_item', 'Descripcion de Item');

		$crud->unset_columns('fecha_inicio_vigen');

		$crud->required_fields('cod_unidad', 'idproducto', 'descripcion', 'cantidad', 'codigo_fab', 'idproducto_fab', 'descripcion_item', 'unidad');

		$crud->display_as('archivo', 'Imagen de Referencia');
		
		$crud->set_field_upload("archivo", "assets/uploads/files");

		$output = $crud->render();
		echo $this->load->view('unidades/regUnidades2', $output, true);
	}
//------------------------------------------------------------//
	public function iframeRegUnidades(){
		$this->load->view('unidades/iframeRegUnidades');
	}
	public function registro_unidades(){
		
		echo $this->load->view('unidades/regUnidades');
	}

	public function buscaMateriales(){
		//$tempo = json_decode($_POST['data']);
		// $query = $this->db->like("descripcion",$_POST['data']);
		// $query = $this->db->get("materiales");
		$query = $this->db->query("select * from materiales where codigo_fab like '%".$_POST['data']."%' or descripcion like '%".$_POST['data']."%'");
		foreach ($query->result() as $key) 
		{ 
			echo '<div class="fila_cuerpo">'.
                   '<div class="columna procedencia">'.
                   '<input type="checkbox" name="articulo[]" value="'.
                    $key->descripcion.
                   ' " id="'.
                    $key->codigo_fab.
                   ' ">'.
                   $key->codigo_fab.
                   '</div><div class="columna descripcion">'.
                   $key->descripcion.
                   '</div>'.
           '</div>';
	 	 }
	}
	public function buscaManoObra(){
		// $query = $this->db->like("descripcion",$_POST['data']);
		// $query = $this->db->get("mano_de_obra");
		$query = $this->db->query("select * from mano_de_obra where codigo_fab like '%".$_POST['data']."%' or descripcion like '%".$_POST['data']."%'");
		foreach ($query->result() as $key) 
		{ 
			echo '<div class="fila_cuerpo">'.
                   '<div class="columna procedencia">'.
                   '<input type="checkbox" name="articulo[]" value="'.
                    $key->descripcion.
                   ' " id="'.
                    $key->codigo_fab.
                   ' ">'.
                   $key->codigo_fab.
                   '</div><div class="columna descripcion">'.
                   $key->descripcion.
                   '</div>'.
           '</div>';
	 	 }
	}
//---------------- Guarda Cabecera de Unidad y Articulos Asociados a la unidad-----------------------------------//
	public function guarga_unidad(){
		//$tempo = json_decode($_POST['data2']);
		$tempo = json_decode($_POST['data2']);
		$tempo1 = json_decode($_POST['data2'], true);
		
		$query1 = $this->db->query("delete from unidades where cod_unidad='".$tempo1[0]['cod_unidad']."'");
		foreach ($tempo as $key) 
		{
			//echo ("insert into producto_ordsrv (COD_OSRV, COD_PRO, DES_PRO, CANT_PRO, PRECIO) values('".$tmp."', '".$key->codigo."', '".$key->descripcion."', '".$key->cantidad."', '0.00')");
			$query = $this->db->query("insert into unidades (cod_unidad, descripcion, codigo_fab, descripcion_item, cantidad, fecha_inicio_vigen) values('".$key->cod_unidad."', '".$key->desc_unidad."', '".$key->codigo."', '".$key->descripcion."', '".$key->cantidad."',STR_TO_DATE(REPLACE('".$key->fecha_inicio_vigencia."','-','.') ,GET_FORMAT(date,'EUR')))");
		}
		//echo $tempo1[0]['fecha_inicio_vigencia'];
	}

//-------------------------------------------------------------//	
	public function carga_unidades(){
		$query = $this->db->query("SELECT distinct(cod_unidad) as cod_unidad, descripcion FROM `unidades` order by cod_unidad asc");
		foreach ($query->result() as $row) 
		{ 
			echo "<tr id='unidad'><td style='height: 25px;' id='codigo_elemento_unidad'>".$row->cod_unidad."</td><td class='tipo_proyecto' id='descripcion'>".$row->descripcion."</td><tr>";
	 	 }
	}
	//----------------- Para editar Unidades y sus elementos ------------------------//
	
	public function trae_elementos_de_unidad(){

		$resultado = $this->db->query("SELECT codigo_fab, descripcion_item, cantidad FROM `unidades` where cod_unidad='".$_POST['dato']."'");

		foreach ($resultado->result() as $row) 
			{ 
				echo "<tr style='height:25px;'><td class='columna acciones'><a href='#' id='elimina_prod' >Eliminar</a></td><td class='columna descripcion' id='codigo'>".$row->codigo_fab."</td><td class='columna descripcion' id='descripcion'>".$row->descripcion_item."</td><td class='columna cantidad_cif'><input type='text' id='cantidad' value='".$row->cantidad."' size='5'></td>";
		 	}
	}

	public function trea_fecha_inicio_vigencia(){
		$resultado = $this->db->query('SELECT DISTINCT(DATE_FORMAT(fecha_inicio_vigen, "%d-%m-%Y")) as fecha_inicio_vigen FROM unidades WHERE cod_unidad = "'.$_POST["codigo"].'"');
		foreach ($resultado->result() as $key) {
			echo $key->fecha_inicio_vigen;
		}
	}

/******************* Actualizacion de SubProyectos por Unidad**********/
	public function iframeRegSubPryUnid(){
		
		$this->load->view('proyectos/iframeRegSubPryUnid');
	}
	public function registro_subproy_unidad(){
		echo $this->load->view('proyectos/regSubPryUnid');
	}
	public function trae_unidades_por_subproyecto(){
		$tempo = json_decode($_POST['data'], true);
		$consulta = 'SELECT distinct(cod_unidad) as cod_unidad from pry_subpry_unid where id_proyecto="'.$tempo['proyecto'].'" AND id_sub_proy="'.$tempo['subproyecto'].'"';
		//echo $consulta;
		$query = $this->db->query($consulta);
		foreach ($query->result() as $key) 
		{
			echo "<option>".$key->cod_unidad."</option>"; 
		}
	}

	public function carga_cod_proyectos_unid(){
		$query = $this->db->query("SELECT distinct(id_proyecto) as id_proyecto FROM `pry_subpry_unid` ");
		foreach ($query->result() as $row) 
		{ 
			echo "<option>".$row->id_proyecto."</option>";
		}
	}

	public function trae_avance_motivo(){
		$query = $this->db->query("SELECT  avance, motivo FROM avance_subproyecto WHERE id_proyecto=".$_POST['data']." order by id_avance desc limit 1");
		if($query->num_rows()>0){
			$i=0;
			foreach ($query->result() as $key) {
			//	echo $key->avance;
				$data_send[$i]['avance'] = $key->avance;
				$data_send[$i]['motivo'] = $key->motivo;
				$i++;
			}
			echo json_encode($data_send);
		}
		else{
			echo "No hay avance registrado!";
		}
	}

	public function calcula_sub_proyectos_unid(){
		$query = $this->db->query("SELECT distinct(id_sub_proy) as id_sub_proy FROM `pry_subpry_unid` where id_proyecto = '".$_POST['data']."' order by id_sub_proy asc ");
		foreach ($query->result() as $row) 
		{ 
			echo "<option>".$row->id_sub_proy."</option>";
	 	}
	}

	public function trae_unidad_de_medida(){
		$tempo = json_decode($_POST['data'], true);

		$query = $this->db->query("SELECT unidad FROM ".$tempo['fuente']." WHERE codigo_fab ='".$tempo['codigo']."'");
		foreach ($query->result() as $key) {
			echo $key->unidad;
		}
	}

	public function trae_elementos_por_subproy(){
		$tempo = json_decode($_POST['data'], true);
		
		$consulta = $this->db->query("SELECT id, cod_unidad, desc_unidad, codigo_fab, desc_item, unidad, cantidad, (select po.presup from presup_mano_obra po where po.codigo = p.codigo_fab union select pm.cantidad from presup_materiales pm where pm.codigo = p.codigo_fab ) as presup, retirado, usado, nuevo FROM pry_subpry_unid p where id_proyecto ='".$tempo['proyecto']."' AND id_sub_proy='".$tempo['subproyecto']."' ");
		foreach ($consulta->result() as $key) {
			if(empty($key->presup))
				{ $presupuesto = 0; } 
			else
				{ $presupuesto = $key->presup; };
			echo "<tr id = '".$key->id."' data-unidad = '".$key->cod_unidad."' data-descunidad = '".$key->desc_unidad."'><td id='codigo_unidad' style='text-align: center;'>".$key->cod_unidad."</td><td id='codigo_fab' style='text-align: center;'>".$key->codigo_fab."</td><td id='desc_item' style='text-align:center;'>".$key->desc_item."</td><td id='unidad' style='text-align:center;'>".$key->unidad."</td><td id='cantidad' style='text-align:center;'>".$key->cantidad."</td><td id='presupuestado' style='text-align:center;'>".$presupuesto."</td><td style='text-align:center;'><input type='text' id='retirado' size='5' value=".$key->retirado."></td><td style='text-align:center;'><input type='text' id='usado' size='5' value=".$key->usado."></td><td style='text-align:center;'><input type='text' id='nuevo' size='5' value=".$key->nuevo."></td></tr>";
		}
	}

	public function trae_elementos_por_unidad(){
		$tempo = json_decode($_POST['data'], true);
		$consulta = $this->db->query("SELECT codigo_fab, cod_unidad, desc_item, unidad, cantidad, (select po.presup from presup_mano_obra po where po.codigo = p.codigo_fab union select pm.cantidad from presup_materiales pm where pm.codigo = p.codigo_fab ) as presup,retirado, usado, nuevo FROM pry_subpry_unid p where cod_unidad ='".$tempo['unidad']."' AND id_proyecto ='".$tempo['proyecto']."' AND id_sub_proy='".$tempo['subproyecto']."' ");
		foreach ($consulta->result() as $key) {
			if(empty($key->presup))
				{ $presupuesto = 0; } 
			else
				{ $presupuesto = $key->presup; };
			echo "<tr><td id='codigo_unidad' style='text-align: center;'>".$key->cod_unidad."</td><td id='codigo_fab' style='text-align: center;'>".$key->codigo_fab."</td><td id='desc_item' style='text-align:center;'>".$key->desc_item."</td><td id='unidad' style='text-align:center;'>".$key->unidad."</td><td id='cantidad' style='text-align:center;'>".$key->cantidad."</td><td id='presupuestado' style='text-align:center;'>".$presupuesto."</td><td style='text-align:center;'><input type='text' id='retirado' size='5' value=".$key->retirado."></td><td style='text-align:center;'><input type='text' id='usado' size='5' value=".$key->usado."></td><td style='text-align:center;'><input type='text' id='nuevo' size='5' value=".$key->nuevo."></td></tr>";
		}
	}
	public function trae_imagen_de_unidad(){
		//echo "SELECT distinct(u.archivo)as archivo from unidades u where u.cod_unidad ='".$_POST['data']."' order by archivo DESC limit 1";
		$consulta = $this->db->query("SELECT distinct(u.archivo)as archivo from unidades u where u.cod_unidad ='".$_POST['data']."' order by archivo DESC limit 1");
		foreach ($consulta->result() as $key) {
			echo "<img src='".base_url()."assets/uploads/files/".$key->archivo."' class='imagen_unidad'><div><input type='button' value='Guardar/Actualizar' id='actualizar'><input type='button' value='Guardar y Salir' id='actualizar_salir'></div>";
		}
	}
	public function trae_titulo_tipo_unidad(){
		$consulta = $this->db->query("select distinct(descripcion) as descripcion from unidades where cod_unidad='".$_POST['data']."'");
		foreach ($consulta->result() as $key) {
			echo $key->descripcion;
		}
	}

	public function actualiza_proyecto_subproyecto(){
		$tempo = json_decode($_POST['data2']);
		$tempo1 = json_decode($_POST['data2'], true);
		//echo($tempo[0]['codigo_proyecto']);
		$query1 = $this->db->query("delete from pry_subpry_unid where id_proyecto=".$tempo1[0]['codigo_proyecto']." and id_sub_proy = ".$tempo1[0]['codigo_subproyecto']." AND cod_unidad='".$tempo1[0]['codigo_unidad']."'");
		
		$query2 = $this->db->query("insert into avance_subproyecto (id_proyecto, id_subproyecto, avance, motivo, fecha) values ('".$tempo1[0]['codigo_proyecto']."','".$tempo1[0]['codigo_subproyecto']."','".$tempo1[0]['avance']."', '".$tempo1[0]['motivo']."', curdate())");
		foreach ($tempo as $key) 
		{
			$query = $this->db->query("insert into pry_subpry_unid (id_proyecto, id_sub_proy, cod_unidad, desc_unidad, cantidad, codigo_fab, desc_item, unidad, retirado, usado, nuevo) values ('".$key->codigo_proyecto."', '".$key->codigo_subproyecto."', '".$key->codigo_unidad."', '".$key->dec_unidad."', '".$key->cantidad."', '".$key->codigo_fab."', '".$key->descripcion."', '".$key->unidad."', '".$key->retirado."', '".$key->usado."', '".$key->nuevo."')");
		}
	}
	
	public function actualiza_proyecto_subproyecto_global(){
		$tempo = json_decode($_POST['data2']);
		$tempo1 = json_decode($_POST['data2'], true);
		
		 $query1 = $this->db->query("delete from pry_subpry_unid where id_proyecto=".$tempo1[0]['codigo_proyecto']." and id_sub_proy = ".$tempo1[0]['codigo_subproyecto']);
		
		 $query2 = $this->db->query("insert into avance_subproyecto (id_proyecto, id_subproyecto, avance, motivo, fecha) values ('".$tempo1[0]['codigo_proyecto']."','".$tempo1[0]['codigo_subproyecto']."','".$tempo1[0]['avance']."', '".$tempo1[0]['motivo']."', curdate())");
		foreach ($tempo as $key) 
		{
			$query = $this->db->query("insert into pry_subpry_unid (id_proyecto, id_sub_proy, cod_unidad, desc_unidad, cantidad, codigo_fab, desc_item, unidad, presupuestado, retirado, usado, nuevo) values ('".$key->codigo_proyecto."', '".$key->codigo_subproyecto."', '".$key->codigo_unidad."', '".$key->dec_unidad."', '".$key->cantidad."', '".$key->codigo_fab."', '".$key->descripcion."', '".$key->unidad."', '".$key->presupuestado."', '".$key->retirado."', '".$key->usado."', '".$key->nuevo."');");
			//$query = $this->db->query("update pry_subpry_unid set cantidad=".$key->cantidad.", presupuestado = ".$key->presupuestado.", retirado=".$key->retirado.", usado = ".$key->nuevo." where id=".$key->idelem);
		}
	}
/*************************************************************/
//**************** Preliquidacion ****************************/

	public function iframeRegPreliquidacion(){
		$this->load->view('proyectos/iframeRegPreliquidacion');
	}
	public function registro_preliquidacion(){
		echo $this->load->view('proyectos/regPreLiquidacion');
	}

	public function carga_proyecto_subpry_preliq(){
		$query = $this->db->query("SELECT distinct(id_proyecto), a.* FROM `avance_subproyecto` a WHERE avance = 100 group by id_proyecto ORDER BY id_avance desc ");
		foreach ($query->result() as $row) 
		{ 
			echo "<tr><td style='height: 25px;' id='proysubproy'>".$row->id_proyecto."-".$row->id_subproyecto."</td><td>".$row->avance."</td><tr>";
	 	 }
	}

	public function trae_proysubproy_preliq(){

		$resultado = $this->db->query("SELECT codigo_fab, desc_item, unidad, retirado, usado, nuevo FROM `pry_subpry_unid` where concat(id_proyecto,'-', id_sub_proy)='".$_POST['dato']."'");

		foreach ($resultado->result() as $row) 
			{ 
				echo "<tr style='height:25px;'><td class='columna' id='codigo'>".$row->codigo_fab."</td><td class='columna' id='descripcion' style='width: 300px;'>".$row->desc_item."</td><td id='unidad'>".$row->unidad."</td><td>0</td><td>0</td><td>".$row->retirado."</td><td>".$row->usado."</td><td>".$row->nuevo."</td><td class='columna' style='width: 100px;'><select><option></option><option>INCOMPLETO</option><option>NO ESTA BIEN</option></select></td>";
		 	}
	}

	public function buscaElementosProy(){
		$tempo = json_decode($_POST['data']);
		$cadena = "SELECT codigo_fab, desc_item, unidad from `pry_subpry_unid` where concat(id_proyecto,'-', id_sub_proy)='".$tempo->subpry."' and (codigo_fab like '%".$tempo->consulta."%' or desc_item like '%".$tempo->consulta."%')";
		
		$query = $this->db->query($cadena);
		foreach ($query->result() as $key) 
		{ 
			echo '<div class="fila_cuerpo">'.
                   '<div class="columna procedencia">'.
                   '<input type="checkbox" name="articulo[]" data-unidad="'.$key->unidad.'" value="'.
                    $key->desc_item.
                   ' " id="'.
                    $key->codigo_fab.
                   ' ">'.
                   $key->codigo_fab.
                   '</div><div class="columna descripcion">'.
                   $key->desc_item.
                   '</div>'.
           '</div>';
	 	 }
	}

	public function traeObservaciones(){
		$query = $this->db->query('SELECT descripcion FROM observaciones_sup');
		$cadena = '<select><option></option>';
		foreach ($query->result() as $key) {
			$cadena .= '<option>'.$key->descripcion.'</option>';
		}
		$cadena .= '</select>';
		echo $cadena;
	}

//---------- Informe PreLiquidacion --------//
	public function iframeRegInfPreliquidacion(){
		$this->load->view('proyectos/iframeRegInfPreliquidacion');
	}

	public function registro_infpreliquidacion(){
		echo $this->load->view('proyectos/regInfPreLiquidacion');
	}

	public function trae_proysubproy_inf_preliq(){

		$resultado = $this->db->query("SELECT cod_unidad, codigo_fab, cantidad, presupuestado, retirado, usado, nuevo FROM `pry_subpry_unid` where concat(id_proyecto,'-', id_sub_proy)='".$_POST['dato']."'");

		foreach ($resultado->result() as $row) 
			{ 
				echo "<tr><td>".$row->cod_unidad."</td><td>".$row->codigo_fab."</td><td id='referencia'>".$row->cantidad."</td><td id='descripcion'>".$row->presupuestado."</td><td>".$row->retirado."</td><td>".$row->usado."</td><td>".$row->nuevo."</td><td>0</td><td>0</td></tr>";
		 	}
	}
/*************************************************************/
	public function index(){
		$this->login();
	}

	public function login(){
		$this->load->view('login');
	}

	public function principal(){
		if ($this->session->userdata('is_logged_in')){
			$this->load->view('principal');
		} else{
			redirect('main/restringido');
		}
	}

	public function restringido(){
		$this->load->view('restringido');
	}

	public function login_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('usuario', 'Usuario', 'required|trim|xss_clean|callback_validar_credenciales');
		$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');

		if($this->form_validation->run()){
			$data = array('usuario' => $this->input->post('usuario'),
					'is_logged_in' => 1
					);
			$this->session->set_userdata($data);
			redirect('main/principal');
		} else{
			$this->load->view('login');
		}
	}

	public function validar_credenciales(){
		$this->load->model('model_usuarios');

		if($this->model_usuarios->puede_entrar() == 1 ){

			return true;
		} elseif($this->model_usuarios->puede_entrar() == 2 ){
			$this->form_validation->set_message('validar_credenciales', 'Usuario Bloqueado!');
			return false;
		} elseif ($this->model_usuarios->puede_entrar() == 3 ) {
			$this->form_validation->set_message('validar_credenciales', 'Usuario Inactivo');
			return false;
		}
		else{
			$this->form_validation->set_message('validar_credenciales', 'Usuario/Password incorrectos!');
			return false;
		}
	}

//--------- Fin Registra Usuario -----
	public function logout(){
		$this->session->sess_destroy();
		redirect('main/login');
	}
}