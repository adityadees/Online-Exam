<?php 
$uri4 = $this->uri->segment(4);
?>

<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title mb-0">Data Soal</h3>
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url()?>">Home</a>
          </li>
          <li class="breadcrumb-item active">Data Soal
          </li>
        </ol>
      </div>
    </div>
  </div>
  <div class="content-header-right col-md-6 col-12">
    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
      <a class="btn btn-outline-primary" href="<?php echo base_url(); ?>adm/soal_ujian/edit/0"><i class="ft-plus"></i></a>
      <a class="btn btn-outline-primary" href="<?php echo base_url(); ?>upload/format_soal_download.xlsx"><i class="ft-download"></i></a>
      <a class="btn btn-outline-primary" href="<?php echo base_url(); ?>adm/soal_ujian/import"><i class="ft-upload"></i></a>
      <a class="btn btn-outline-primary" href="<?php echo base_url(); ?>adm/soal_ujian/cetak/<?php echo $uri4; ?>"><i class="ft-printer"></i></a>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-xl-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Data Soal</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            <li><a data-action="close"><i class="ft-x"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-content">
        <div class="card-body">
          <?php echo $this->session->flashdata('k'); ?>
          <table class="table table-bordered" id="datatabel">
            <thead>
              <tr>
                <td width="5%">No</td>
                <td width="50%">Soal</td>
                <td width="15%">Mata Pelajaran / Guru</td>
                <td width="15%">Analisa</td>
                <td width="15%">Aksi</td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

