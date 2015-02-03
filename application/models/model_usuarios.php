<?php
	class Model_usuarios extends CI_Model{
		public function puede_entrar(){
			$this->db->where('uname', $this->input->post('usuario'));
			$this->db->where('password', md5($this->input->post('password')));
			$query = $this->db->get('usuarios');

			if($query->num_rows() == 1){
				return true;
			}else{
			return false;
			}
		} 
	}