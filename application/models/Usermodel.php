<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usermodel extends CI_Model {

	public function email_exists() {	
		$query = $this->db->get_where('authors', ['email' => $this->input->post('email')]);
		return $query->num_rows() > 0;
	}

	public function get_num_rows() {
		$query = $this->db->get('authors');
		return $query->num_rows(); 
	}

	public function register_user($enc_password, $active, $is_admin) {
		// User data
		$data = [
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email' => $this->input->post('email'),
			'password' => $enc_password,
			'register_date' => date('Y-m-d H:i:s'),
			'active' => $active,
			'is_admin' => $is_admin
		];
		return $this->db->insert('authors', $data);
	}

	public function user_login($email, $password)
	{
		$query = $this->db->get_where('authors', ['email' => $email, 'password' => md5($password)]);
		return $query->row();
	}
	
}

