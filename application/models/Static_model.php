<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Static_model extends CI_Model {

	public function get_static_data() {
		$data['site_title'] = "My Blog";
		$data['tagline'] = "A simple blog application made with Codeigniter 3";
		$data['company_name'] = "My Company";
		$data['company_email'] = "company@domain.com";
		$data['is_featured'] = false;
		$data['is_ckeditor'] = false;
		$data['is_cookieconsent'] = true;
		return $data;
	}

}