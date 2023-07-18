<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_kmeans extends CI_Controller {
    var $footer = [];
    var $menu = [];
	function __construct() {
    parent::__construct();
    if($this->session->userdata('login')===NULL){
      redirect('home');
    }
    $this->footer = array(
                            "copyright"=>"2023",
                        );
    $this->menu = array(
                    "navbar"=>array(
                            "menu"=>array(
                                            array(
                                            "name"=>"Dashboard",
                                            "icon"=>"remixicon-home-4-line",
                                            "link"=>base_url()."C_kmeans"
                                        ),
                                        array(
                                            "name"=>"K-Means Clustering",
                                            "icon"=>"remixicon-file-chart-line",
                                            "link"=>base_url()."C_kmeans/process"
                                        ),
                                        array(
                                            "name"=>"Logout",
                                            "icon"=>"remixicon-logout-circle-line",
                                            "link"=>base_url()."C_login/logout"
                                        )
                            )
                        )
                    );
	}
	public function index()
	{
        $var['menu'] = $this->menu;
        $var['admin'] = "view/dashboard";
        $var['var_admin'] = array();
        $var['content_title'] = "Dashboard";
        $var['breadcrumb'] = array(
                "Home"=>"",
                "Dashboard"=>"active"
        );
        $var['footer'] = $this->footer;
        $this->load->view('main',$var);
  }
public function process($page="dataset")
    {
        $var['menu'] = $this->menu;
        $var['admin'] = "view/process";
        $var['var_admin'] = array("page"=>$page);
        $var['content_title'] = "Metode K-Means Clustering";
        $var['breadcrumb'] = array(
                "Home"=>"",
                "K-Means"=>"active"
        );
        $var['footer'] = $this->footer;
        $this->load->view('main',$var);
    }
}
