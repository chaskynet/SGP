<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->database();

		$this->load->library('grocery_CRUD');
	}

	public function _principal_output($output = null)
	{
		$this->load->view('principal.php',$output);
	}
/***** Funciones GroceryCrud para Modulo Proyectos *******/
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

		if ($tempo->localiza === 'URBANO'){
			$query = $this->db->query("select urbano as dias from tipo_proyecto where desc_tipo_proy = '".$tempo->tipo."'");
		}else if ($tempo->localiza === 'RURAL'){
			$query = $this->db->query("select rural as dias from tipo_proyecto where desc_tipo_proy = '".$tempo->tipo."'");
		}else if ($tempo->localiza === 'TROPICO'){
			$query = $this->db->query("select tropico as dias from tipo_proyecto where desc_tipo_proy = '".$tempo->tipo."'");
		}

		foreach ($query->result() as $row) 
		{ 
			$fecha = strtotime($tempo->fecha_ini);
			$nueva_fecha = date('d-m-Y',strtotime('+'.$row->dias.' days', $fecha));
			echo $nueva_fecha;
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
/*************************************************************/
/******* Funciones GroceryCrud para Modulo Configuraciones ********/
//------- Para registro de Usuarios
	public function iframeUsr(){
		$this->load->view('backend/iframeRegUsr');
	}
	public function regusr(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Creacion de Usuarios');
		$crud->set_table('usuarios');

		$crud->change_field_type('password', 'password');

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

 //------- Para registro de Tipo de Proyecto --------
	public function iframeTipoProyecto(){
		$this->load->view('backend/iframeTipoProyecto');
	}
	public function regTipoProyecto(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Tipempos por Tipo de Proyecto');
		$crud->set_table('tipo_proyecto');

		$crud->display_as('desc_tipo_proy', 'Descripcion del Proyecto');

		$crud->required_fields('desc_tipo_proy', 'rubano', 'rural', 'tropico');

		$output = $crud->render();
		echo $this->load->view('backend/regTipoProyecto', $output, true);
	}
//-------------------------------------------------------------------------------/
	public function iframeNaturaProyecto(){
		$this->load->view('backend/iframeNaturaProyecto');
	}
	public function regNaturaProyecto(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Tipo de Proyecto');
		$crud->set_table('naturaleza_proy');
		$output = $crud->render();
		echo $this->load->view('backend/regNaturaProyecto', $output, true);
	}
//-------------------------------------------------------------------------------/
	public function iframePrioridadProyecto(){
		$this->load->view('backend/iframePrioridadProyecto');
	}
	public function regPrioridadProyecto(){
		$crud = new grocery_CRUD();
		$crud->set_subject('Tipo de Proyecto');
		$crud->set_table('prioridad_proy');
		$output = $crud->render();
		echo $this->load->view('backend/regPrioridadProyecto', $output, true);
	}
//-------------------------------------------------------------------------------/

	public function selProySubProy(){
		$this->load->view('ImportarDatos/selProySubProy');
	}
	public function selTipoArch(){
		$crud = new grocery_CRUD();
		$crud->set_theme("datatables");

		$crud->set_table('importa_datos');
		$crud->set_relation("proyecto", "proyecto", "id_proyecto");
		$crud->set_subject('Importacion de Datos desde Archivo');

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
	$marker['position'] = '-17.393313, -66.157664'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A3 - OK!';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.393487, -66.158608';//'37.409, -122.1319';
	$marker['infowindow_content'] = 'Poste A4 - Pendiente de Asignacion!';
	$marker['draggable'] = TRUE;
	$marker['animation'] = 'DROP';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.393487, -66.158608';//'37.409, -122.1319';
	$marker['infowindow_content'] = 'Poste A5 - Pendiente de Asignacion!';
	$marker['draggable'] = TRUE;
	$marker['animation'] = 'DROP';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.393416, -66.157599';//'37.449, -122.1419';
	$marker['onclick'] = 'alert("Poste A6 - Sub proyecto 123 (Pendiente de conciliacion!!")';
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
	$marker['position'] = '-17.394593, -66.157470';//'37.409, -122.1319';
	$marker['infowindow_content'] = 'Poste A10 - OK!';
	$marker['draggable'] = TRUE;
	$marker['animation'] = 'DROP';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.395432, -66.157299'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A11 - Reclamo Odeco #2343';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.395637, -66.157191'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A12 - Reclamo Odeco #2343';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.395432, -66.156204'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A13 - ';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.395248, -66.155110'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A14 - ';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
	$this->googlemaps->add_marker($marker);

	$marker = array();
	$marker['position'] = '-17.395090, -66.154043'; //'37.429, -122.1519';
	$marker['infowindow_content'] = 'poste A15 - ';
	$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
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
		 
		// if (empty($_POST['title']))
		// {
		//     $status = "error";
		//     $msg = "Please enter a title";
		// }
		 
		if ($status != "error")
		{
		    $config['upload_path'] = './assets/uploads/files/';
		    $config['allowed_types'] = 'xls|xlsx';
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
		        // $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
		        // if($file_id)
		        // {
		        //     $status = "success";
		             $msg = "Archivo subido correctamente!";
		        // }
		        // else
		        // {
		        //     unlink($data['full_path']);
		        //     $status = "error";
		        //     $msg = "Something went wrong when saving the file, please try again.";
		        // }
		    }
		    @unlink($_FILES[$file_element_name]);
		}
		echo json_encode(array('status' => $status, 'msg' => $msg, 'archivo' => $data['file_name']));
	}


	public function importarMateriales(){
		$file = './assets/uploads/files/'.$_POST['data'];//'./files/test.xlsx';
		//load the excel library
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($row == 1) {
			    $header[$row][$column] = $data_value;
			} else {
			    $arr_data[$row][$column] = $data_value;
			}
		}
		//send the data in an array format
		//$data['header'] = $header;
		$data= $arr_data;
		//$data = json_encode($data);
		//echo $data;
		foreach ($data as $key) {
			
			$insertar = $this->db->query('insert into materiales (codigo_fab, descripcion, unidad, costo) values("'.$key["B"].'", "'.addslashes($key["C"]).'", "'.$key["D"].'", "'.$key["E"].'")');
			
		}
	}

	public function importarManoObra(){
		$file = './assets/uploads/files/'.$_POST['data'];//'./files/test.xlsx';
		//load the excel library
		$this->load->library('excel');
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($row == 1) {
			    $header[$row][$column] = $data_value;
			} else {
			    $arr_data[$row][$column] = $data_value;
			}
		}
		//send the data in an array format
		//$data['header'] = $header;
		$data= $arr_data;
		//$data = json_encode($data);
		//echo $data;
		foreach ($data as $key) {
			
			$insertar = $this->db->query('insert into mano_de_obra (codigo_fab, descripcion, unidad, costo) values("'.$key["B"].'", "'.addslashes($key["C"]).'", "'.$key["D"].'", "'.$key["E"].'")');
			
		}
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

//------------------------------------------------------------//
	public function iframeRegUnidades(){
		$this->load->view('unidades/iframeRegUnidades');
	}
	public function registro_unidades(){
		
		echo $this->load->view('unidades/regUnidades');
	}

	public function buscaMateriales(){
		//$tempo = json_decode($_POST['data']);
		$query = $this->db->like("descripcion",$_POST['data']);
		$query = $this->db->get("materiales");

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
		$query = $this->db->like("descripcion",$_POST['data']);
		$query = $this->db->get("mano_de_obra");

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
//-------------------------------------------------------------//
	public function guarga_unidad(){
		$tempo = json_decode($_POST['data2']);
		foreach ($tempo as $key) 
		{
			//echo ("insert into producto_ordsrv (COD_OSRV, COD_PRO, DES_PRO, CANT_PRO, PRECIO) values('".$tmp."', '".$key->codigo."', '".$key->descripcion."', '".$key->cantidad."', '0.00')");
			$query = $this->db->query("insert into unidades (cod_unidad, descripcion, codigo_fab, cantidad) values('".$key->cod_unidad."', '".$key->desc_unidad."', '".$key->codigo."', '".$key->cantidad."')");
		}
	}
//-------------------------------------------------------------//	
	public function carga_unidades(){
		$query = $this->db->query("select * from unidades");
		foreach ($query->result() as $row) 
		{ 
			echo "<tr><td>".$row->cod_unidad."</td><td class='tipo_proyecto'>".$row->descripcion."</td><tr>";
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

		if($this->model_usuarios->puede_entrar()){

			return true;
		} else{
			$this->form_validation->set_message('validar_credenciales', 'Usuario/Password Incorrectos!');
			return false;
		}
	}

//--------- Fin Registra Usuario -----
	public function logout(){
		$this->session->sess_destroy();
		redirect('main/login');
	}
}