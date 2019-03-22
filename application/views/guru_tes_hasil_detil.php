<?php 
$uri4 = $this->uri->segment(4);
?>

<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title mb-0">Data Guru</h3>
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url()?>">Home</a>
          </li>
          <li class="breadcrumb-item active">Data Guru
          </li>
        </ol>
      </div>
    </div>
  </div>
  <div class="content-header-right col-md-6 col-12">
    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
      <a class="btn btn-outline-primary" href="<?php echo base_url(); ?>adm/hasil_ujian_cetak/<?php echo $uri4; ?>" target="_blank"><i class="ft-printer"></i></a>
    </div>
  </div>
</div>



<div class="row">

  <div class="col-xl-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Daftar Hasil Tes</h4>
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

          <div class="col-lg-12 alert alert-warning" style="margin-bottom: 20px">
            <div class="col-md-6">
              <table class="table table-bordered" style="margin-bottom: 0px">
                <tr><td>Mata Kuliah</td><td><?php echo $detil_tes->namaMapel; ?></td></tr>
                <tr><td>Nama Guru</td><td><?php echo $detil_tes->nama_guru; ?></td></tr>
                <tr><td width="30%">Nama Ujian</td><td width="70%"><?php echo $detil_tes->nama_ujian; ?></td></tr>
                <tr><td>Waktu</td><td><?php echo $detil_tes->waktu; ?> menit</td></tr>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-bordered" style="margin-bottom: 0px">
                <tr><td width="30%">Jumlah Soal</td><td><?php echo $detil_tes->jumlah_soal; ?></td></tr>
                <tr><td>Tertinggi</td><td><?php echo $statistik->max_; ?></td></tr>
                <tr><td>Terendah</td><td><?php echo $statistik->min_; ?></td></tr>
                <tr><td>Rata-rata</td><td><?php echo number_format($statistik->avg_); ?></td></tr>
              </table>
            </div>
          </div>

          <table class="table table-bordered" id="datatabel">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th width="40%">Nama Peserta</th>
                <th width="15%">Jumlah Benar</th>
                <th width="15%">Nilai</th>
                <th width="15%">Nilai Bobot</th>
                <th width="10%">Aksi</th>
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


