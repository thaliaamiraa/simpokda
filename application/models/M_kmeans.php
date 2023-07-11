<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kmeans extends CI_Model {
  var $data = array();
  var $cluster = [];
  var $maxloop = 10;
  var $jmlcentroid = 0;
  var $dimensi = 0;
  var $centroid = 0;
  var $centroid_allof;
  var $data_cluster = [];
  var $distance = [];
  function __construct() {
      parent::__construct();
  }
  public function init($data = NULL,$jmlcentroid = 0,$centroid = NULL,$maxloop = 30){
    $this->data = $data;
    $this->cluster = [];
    $this->maxloop = $maxloop;
    $this->jmlcentroid = $jmlcentroid;
    $this->dimensi = sizeof($this->data[0]);
    if($centroid == 'random'){
      $this->centroid = $this->centroid_random();
    }else{
      if(is_array($centroid)){
        $this->centroid = $centroid;
      }else{
        throw new Exception('Exception : Centroid Tidak Valid.');
      }
    }
    $this->data_cluster = [];
    $this->distance = [];
  }

  public function getprocess(){
    return array("centroid"=>$this->centroid_allof,"distance"=>$this->distance,"cluster"=>$this->cluster);
  }

  public function execute(){
    for($i=0;;$i++){
    		$this->cluster[$i] = array();
    		if($i==0){
    			$this->data_cluster[$i] = $this->centroid;
          $this->centroid_allof[$i]=$this->centroid;
        }else{
    			$this->data_cluster[$i] = $this->data_cluster[$i-1];
          $this->centroid_allof[$i]=$this->data_cluster[$i];
    		}
        //Cari Jarak Euclidean Distance
    		foreach ($this->data as $c) {
    			$distance_data = array();
    			foreach ($this->data_cluster[$i] as $d) {
    				$cluster_data = array();
    				for ($x=0;$x<$this->dimensi;$x++) {
    					$cluster_data[$x]=pow(abs($c[$x]-$d[$x]),2);
    				}
    				$distance_data[] = sqrt(array_sum($cluster_data));
    			}
    			$this->distance[$i][]=$distance_data;
    		}
    		//cluster
    		$x=0;
    		foreach ($this->distance[$i] as $key) {
          $min=min($key);
          $c = array_search($min,$key);
          $this->cluster[$i][$x] = $c;
    			$x++;
    		}
    		//repoint
    		$this->data_cluster[$i] =  array();
    		foreach ($this->cluster[$i] as $key => $value) {
    			$this->data_cluster[$i][$value][] = $this->data[$key];
    		}
    		$this->data_cluster_temp = $this->data_cluster[$i];
    		$this->data_cluster[$i] = array();
        //---
        foreach ($this->data_cluster_temp as $key => $value) {
          $temp=array();
          foreach ($value as $keys => $values) {
            foreach ($values as $keyx => $valuem) {
              $temp[$keyx][]=$this->data_cluster_temp[$key][$keys][$keyx];
            }
          }
          for($x1=0;$x1<sizeof($temp);$x1++){
            $this->data_cluster[$i][$key][$x1]=array_sum($temp[$x1])/count($temp[$x1]);
    			}
        }
        
        $temp2[$i] = array();
        $max_temp2 = array_keys($this->data_cluster[$i]);
        $max_temp2 = max($max_temp2);

        for($u=0;$u<=$max_temp2;$u++){
          if(isset($this->data_cluster[$i][$u])){
            $temp2[$i][$u] = $this->data_cluster[$i][$u];
          }
        }
        $this->data_cluster[$i]=$temp2[$i];

        if($i>0){
    			if($this->stoploop($i)){break;}
    		}
    }
  }

  private function stoploop($i){
    if($i<($this->maxloop-1)){
    	if(sizeof($this->cluster)>1){
    		$last_index_cluster = sizeof($this->cluster)-1;
    		for($x=0;$x<sizeof($this->cluster[$last_index_cluster]);$x++){
    			if($this->cluster[$last_index_cluster][$x] != $this->cluster[($last_index_cluster-1)][$x]){
    				return false;
    			}
    		}
    		return true;
    	}else{return false;}
    }else{
      return true;
    }
  }

  private function centroid_random(){
      $central = round(sizeof($this->data)/$this->jmlcentroid,0);
      $step = $central;
      $cek=0;$c=0;
      for($z=0;$z<sizeof($this->data);$z++){
        $temp=[];
        for($d=0;$d<$this->dimensi;$d++){
          $temp[]=$this->data[$z][$d];
        }
        if((($z % $central) < $central && $z % $central != 0) || $z==0){
            $temp_centroid_awal[$c][$z]=$temp;
        }else{
          if($c+1 < $this->jmlcentroid){
            $c++;
          }
            $temp_centroid_awal[$c][$z]=$temp;
        }
      }
      foreach ($temp_centroid_awal as $key => $value) {
        $temp=[];
        foreach ($value as $keys => $values) {
          for($d=0;$d<$this->dimensi;$d++){
            $temp[$d][]=$temp_centroid_awal[$key][$keys][$d];
          }
        }
        $temps[$key]=$temp;
      }
      foreach ($temp_centroid_awal as $key => $value) {
        $arr_rand = array();
        foreach ($value as $keys => $values) {
          array_push($arr_rand,$keys);
        }

        $inde = rand(min($arr_rand),max($arr_rand));
        $centroid_awal[$key] = $value[$inde];
      }
      return $centroid_awal;
  }

}
