<?php
	class Model_usuarios extends CI_Model{
		public function puede_entrar(){
			$this->db->where('uname', $this->input->post('usuario'));
			$this->db->where('password', md5($this->input->post('password')));
			//$this->db->where('estado_usuario', '1');
			$query = $this->db->get('usuarios');
			$estado = 0;
			if($query->num_rows() == 1){
				foreach ($query->result() as $key) {
					$estado = $key->estado_usuario;
				}
				return $estado;
			}else{
			return $estado;
			}
		} 
	}