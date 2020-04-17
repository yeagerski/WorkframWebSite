<?php
	class User_model extends CI_Model{
		public function register($enc_password){
			$data = array(
				'username' => $this->input->post('username'),
				'fname' => $this->input->post('fname'),
				'lname' => $this->input->post('lname'),
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
			);
			return $this->db->insert("users", $data);
		}


		//check the if exits
		public function check_username_exists($username){
			$query = $this->db->get_where('users', array('username' => $username));
			if(empty($query->row_array())){´
				return TRUE;
			}else{
				return FALSE;
			}
		}
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));
			if(empty($query->row_array())){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}



