<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends CI_Controller {
	function __construct() {
        parent::__construct();

    }
	public function login(){
        $data = array(
            "user_name"=>$this->input->post("user_name"),
            "user_password"=>$this->input->post("user_password")
        );
				if($data['user_name']=="admin"&&$data['user_password']=="1234"){
					$data['login'] = true;
					$this->session->set_userdata('login', $data);
					redirect("C_kmeans");
				}
        redirect("home");
    }
		public function logout(){
			$this->session->sess_destroy();
			redirect("home");
		}
}
