<?php
function aasort (&$array, $key) {
    $sorter = array();
    $ret = array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii] = $va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii] = $array[$ii];
    }
    $array = $ret;
}
$process = array();
if($page == "cluster"){
  if(isset($_POST['simpan'])){
    //menyimpan fungsi kedalam session (jumlah centroid, maksimal looping, dan nilai centroid)
    $this->session->set_userdata('maxloop',$this->input->post('maxloop'));
    $this->session->set_userdata('centroid',$this->input->post('centroid'));
    $this->session->set_userdata('jmlcentroid',$this->input->post('jmlcentroid'));
    $this->session->set_userdata('c',$this->input->post('c'));
    $this->session->set_userdata('isimanual',$this->input->post('isimanual'));
  }
}
 //perintah clustering
if($page == "execute"){

  if($this->session->userdata('datatoprocess')!==NULL && $this->session->userdata('jmlcentroid')!==NULL && $this->session->userdata('centroid')!==NULL){
    
    //menginisialisasi data dulu pake fungsi init dan masukan kedalam parameter, fungsi2 nya ada di M_kmeans
    $this->m_kmeans->init($this->session->userdata('datatoprocess'),$this->session->userdata('jmlcentroid'),$this->session->userdata('centroid'),$this->session->userdata('maxloop'));
    $this->m_kmeans->execute();
    //mengambil hasil proses dari data kmeans yang diolah
    $process = $this->m_kmeans->getprocess();
  
  }
}
?>
<script type="text/javascript" src="<?=base_url()?>assets/js/plot.js"></script>
<div class="row">
    <!-- Right Sidebar -->
    <div class="col-12">
        <div class="card-box">
            <!-- Left sidebar -->
            <div class="inbox-leftbar">
                <div class="mail-list mt-4">
                  <!-- List menu -->
                    <a href="<?=base_url()?>C_kmeans/process/dataset" class="list-group-item border-0 <?=$page=='dataset'?'font-weight-bold':'';?>">1. Upload Dataset</a>
                    <a href="<?=base_url()?>C_kmeans/process/cluster" class="list-group-item border-0 <?=$page=='cluster'?'font-weight-bold':'';?>">2. Tentukan Jumlah Cluster</a>
                    <a href="<?=base_url()?>C_kmeans/process/execute" class="list-group-item border-0 <?=$page=='execute'?'font-weight-bold':'';?>">3. Proses K-Means</a>
                    <a href="<?=base_url()?>C_kmeans/process/result" class="list-group-item border-0 <?=$page=='result'?'font-weight-bold':'';?>">4. Clustering</a>
                </div>
            </div>
            <!-- End Left sidebar -->
            <div class="inbox-rightbar">
              <?php
                //jika memilih menu dataset kmeans
                if($page == 'dataset'){
                ?>

                <div class="col-md-12">
                    <div class="card-box">
                      <h4>Pilih Data Excel</h4>
                      <form enctype="multipart/form-data">
                          <input id="upload" type="file" name="files">
                          <button type="button" class="btn btn-primary btn-sm" id="upl" onclick="doupl()" style="display:none;">Upload</button>
                      </form>
                    </div>
                    <?php
                        //Ketika upload file data excel akan dikirim ke controller operation untuk dilakukan pengambilan data dan dimasukan
                        if($this->session->userdata('process_dataset')!==NULL && $this->session->userdata('process_datasetindex')!==NULL){
                          //ambil data session dari data yang di upload, dan dimasukan kedalam variabel biasa untuk dilakukan pengolahan
                            $index = $this->session->userdata('process_datasetindex');
                            $dataset = $this->session->userdata('process_dataset');
                    ?>
                    <div class="card-box table-responsive">
                      <h4>Dataset Desa dan Dampak Bencana</h4>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <?php
                                // menampilkan data dari session kedalam bentuk tabel
                                foreach ($index as $key) {
                                  ?>
                                   <th><?=$key?></th>
                                  <?php
                                }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            $datatoprocess = array();
                            $indexdata = array();
                            foreach ($dataset as $key) {
                                ?>
                                <tr>
                                    <?php
                                    $temp = array();
                                    $x = 0;
                                     foreach ($index as $keys) {
                                       if($x>0){
                                         array_push($temp,$key[$keys]);
                                       }else{
                                         array_push($indexdata,$key[$keys]);
                                       }
                                        ?>
                                            <td><?=$key[$keys]?></td>
                                        <?php
                                        $x++;
                                     }
                                    ?>
                                </tr>
                                <?php
                              array_push($datatoprocess,$temp);
                            }
                            $this->session->set_userdata("datatoprocess",$datatoprocess);
                            $this->session->set_userdata("indexdata",$indexdata);
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <?php } ?>
                  </div>
                <?php

                //Tentukan Cluster
              }else if($page == 'cluster'){ ?>
                  <h4>Tentukan Centroid & Cluster</h4>
                  <br />
                  <?=form_open("C_kmeans/process/cluster",array("class"=>"form-horizontal","role"=>"form"))?>
                  <form class="form-horizontal" role="form" method="POST">
                    <div id="clustermodal" class="modal fade">
                        <?php
                            if($this->session->userdata('process_dataset')!==NULL && $this->session->userdata('process_datasetindex')!==NULL){
                              $index = $this->session->userdata('process_datasetindex');
                              $dataset = $this->session->userdata('process_dataset');
                              }
                          ?>
                    </div>

                    <!-- halaman centroid & cluster-->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="simpleinput">Centroid</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="centroid" onchange="typecentroid(event)">
                              <option value="random" <?=$this->session->userdata('centroid')=='random'?'selected':'';?>>Centroid Acak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="example-email">Jumlah Cluster</label>
                        <div class="col-sm-10">
                            <input type="number" id="jmlcls" name="jmlcentroid" min="1" <?=$this->session->userdata('process_dataset')===NULL?'readonly':''?> max="<?=$this->session->userdata('process_dataset')!==NULL?sizeof($this->session->userdata('process_dataset')):1?>" required value="<?=$this->session->userdata('jmlcentroid')?>" class="form-control" placeholder="<?=$this->session->userdata('process_dataset')===NULL?'Masukan Dataset Dahulu':'Jumlah Cluster'?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="example-email">Max Perulangan</label>
                        <div class="col-sm-10">
                            <input type="number" name="maxloop" value="<?=$this->session->userdata('maxloop')!==NULL?$this->session->userdata('maxloop'):30?>" class="form-control" placeholder="Maksimal Perulangan" required>
                        </div>
                    </div>
                    <div class="form-group float-right">
                      <?php
                        if($this->session->userdata('process_dataset')!==NULL){
                          ?>
                            <button class="btn btn-dark" type="submit" name="simpan">Simpan</button>
                          <?php
                        }
                      ?>
                    </div>
                </form>
                <?php }else if($page == 'execute'){ ?>
                  <?php
                  if(sizeof($process)>0){
                    if($this->session->userdata('centroid') != NULL){
                      $loopresult = sizeof($process['cluster']);
                      $indexdata = $this->session->userdata('indexdata');
                      for($n=0;$n<$loopresult;$n++) {
                      ?>
                      <button class="btn btn-dark btn-block"><strong>Iterasi Ke - <?=$n+1?></strong></button>
                      <br />
                      <h4>Iterasi <?=$n+1?> - Nilai Centroid</h4>
                      <div class="table-responsive">
                        <table class="table table-border">
                          <?php
                          $x=0;
                          foreach ($process['centroid'][$n] as $key) {
                            $x++;
                            ?>
                            <tr>
                              <td>Centroid <?=$x?></td>
                              <?php
                              foreach ($key as $keys) {
                                ?>
                                <td align="center"><?=$keys?></td>
                                <?php
                              }
                              ?>
                            </tr>
                            <?php
                          }
                          ?>
                        </table>
                      </div>
                      <hr />
                      <h4>Iterasi <?=$n+1?> - Hitung Euclidean Distance</h4>
                      <div class="table-responsive">
                        <table class="table table-border">
                          <?php
                          $x=0;
                          foreach ($process['distance'][$n] as $key) {
                            $x++;
                            ?>
                            <tr>
                              <td><?=$indexdata[$x-1]?></td>
                              <?php
                              foreach ($key as $keys) {
                                ?>
                                <td align="center"><?=$keys?></td>
                                <?php
                              }
                              ?>
                            </tr>
                            <?php
                          }
                          ?>
                        </table>
                      </div>
                      <hr />
                      <h4>Iterasi <?=$n+1?> - Hasil Cluster</h4>
                      <div class="table-responsive">
                        <table class="table table-border">
                          <?php
                          $x=0;
                          $kmeans_result=array();
                          foreach ($process['cluster'][$n] as $key) {
                            $x++;
                            ?>
                            <tr>
                              <td><?=$indexdata[$x-1]?></td>
                              <td><?=($key+1)?></td>
                            </tr>
                            <?php
                            $kmeans_result[]=array($indexdata[$x-1],($key+1));
                          }
                          $this->session->set_userdata("kmeans_result",$kmeans_result);
                          ?>
                        </table>
                        </div>
                    <?php } ?>
                    <h3><strong>Jumlah Iterasi = <?=$n?> </strong></h3>
                      <?php
                    }
                    
                  }
                  
                  ?>
                  
              <?php }else if($page == "result"){
                $obj = "";
                ?>
                <h4>Hasil Clustering</h4>
                <div class="table-responsive" id="export">
                  <table class="table table-border">
                    <thead>
                      <?php
                        foreach ($this->session->userdata("process_datasetindex") as $n => $v) {
                          if($n==0){
                            $obj = $v;
                          }
                          ?>
                          <th><?=$v?></th>
                          <?php
                        }
                      ?>
                      <th>Cluster</th>
                    </thead>
                    <?php
                    if($this->session->userdata("kmeans_result")!==NULL){
                      $resk = $this->session->userdata("kmeans_result");
                      aasort($resk,1);
                      foreach ($resk as $key) {
                        ?>
                        <tr>
                          <td><?=$key[0]?></td>
                          <?php
                           foreach ($this->session->userdata("process_datasetindex") as $n => $v) {
                             if($n>0){
                               $attr = array_column($this->session->userdata("process_dataset"),$v,$obj);
                               ?>
                               <td><?=$attr[$key[0]]?></td>
                               <?php
                             }

                           }
                          ?>
                          <td><?=$key[1]?></td>
                        </tr>
                        <?php
                      }
                    }
                    ?>
                  </table>
                  <h4>Hasil Clustering</h4>
                  <table class="table table-border">
                    <thead>
                      <th>Cluster</th>
                      <th>Jumlah Anggota</th>
                    </thead>
                    <?php
                    if($this->session->userdata("kmeans_result")!==NULL){
                      $res = array();
                      foreach ($this->session->userdata("kmeans_result") as $key) {
                        if(!isset($res[$key[1]])){
                          $res[$key[1]]=1;
                        }else{
                          $res[$key[1]]++;
                        }
                      }
                      foreach ($res as $key => $val) {
                        ?>
                        <tr>
                          <td><?=$key?></td>
                          <td><?=$val?></td>
                      </tr>
                        <?php
                      }
                    }
                    ?>
                  </table>
                </div>
                <button class="btn btn-purple" onclick="Export2Word('export','export.docx')">Export</button>
                <?php
              } ?>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end card-box -->
    </div> <!-- end Col -->
</div>
<script>

function Export2Word(element, filename = ''){
    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
    var postHtml = "</body></html>";
    var html = preHtml+document.getElementById(element).innerHTML+postHtml;

    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });

    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);

    // Specify file name
    filename = filename?filename+'.doc':'document.doc';

    // Create download link element
    var downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }

    document.body.removeChild(downloadLink);
}
</script>
