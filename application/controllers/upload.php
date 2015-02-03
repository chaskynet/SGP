<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends CI_Controller {
	
	function Upload()
	{
		//parent::Controller();
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
	
	function index()
	{	
		$this->load->view('ImportarDatos/formulario_carga', array('error' => ' ' ));
	}
	function do_upload()
	{
		$config['upload_path'] = './assets/uploads/files/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size']	= '100';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
		
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload())
		{
			echo $error = array('error' => $this->upload->display_errors());
			
			//$this->load->view('ImportarDatos/formulario_carga', $error);
		}	
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
			$this->load->view('ImportarDatos/upload_success', $data);
		}
	}

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
		    $config['encrypt_name'] = TRUE;

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
		             $msg = "File successfully uploaded";
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
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}	
}
?>