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
  function debug(){
    $data = array([0,0,0.0909091,0],[0.0842349,0.147541,0.454545,0.117647],[0.115147,0.163934,0.0909091,0.147059],[0.183153,0.245902,0.181818,0.205882],[0.357032,0.311475,0.454545,0.294118],[0.454405,0.42623,0.727273,0.470588],[0.51391,0.52459,0.909091,0.470588],[0.526275,0.278689,0.0909091,0.558824],[0.608964,0.622951,0.636364,0.558824],[0.62983,0.672131,0.636364,0.676471],[0.632921,0.557377,0.545455,0.588235],[0.656878,0.655738,0.636364,0.617647],[0.66847,0.540984,0.818182,0.735294],[0.688563,0.754098,0.636364,0.647059],[0.693972,0.57377,0.727273,0.735294],[0.698609,0.672131,0.545455,0.647059],[0.7017,0.704918,0.636364,0.676471],[0.724111,0.672131,0.727273,0.735294],[0.727975,0.721311,0.545455,0.676471],[0.77357,0.770492,1,0.705882],[0.782071,0.704918,0,0.735294],[0.800618,1,0.727273,0.823529],[0.802164,0.786885,0.818182,0.764706],[0.804482,0.918033,0.727273,0.823529],[0.812983,0.754098,0.818182,0.794118],[0.822257,0.967213,0.454545,0.911765],[0.867852,0.606557,0.454545,0.823529],[0.925039,0.918033,0.454545,0.882353],[0.938176,1,0.636364,0.882353],[1,0.967213,0.636364,1]);
    $this->m_kmeans->init($data,3,'rata-rata');
    $this->m_kmeans->execute();
    echo "<pre>";
    print_r($this->m_kmeans->getprocess());
    echo "</pre>";
  }
}