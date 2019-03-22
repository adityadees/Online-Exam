<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title mb-0">Daftar Ujian</h3>
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url()?>">Home</a>
          </li>
          <li class="breadcrumb-item active">Daftar Ujian
          </li>
        </ol>
      </div>
    </div>
  </div>
  <div class="content-header-right col-md-6 col-12">
    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
      <a class="btn btn-outline-primary" href="#" onclick="return m_ujian_e(0);"><i class="ft-plus"></i></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Daftar Ujian</h4>
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
          <table class="table table-bordered" id="datatabel">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Tes</th>
                <th width="20%">Mata Pelajaran</th>
                <th width="10%">Jumlah Soal</th>
                <th width="15%">Waktu</th>
                <th width="15%">Pengacakan Soal</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>






<div class="modal fade" id="m_ujian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel">Buat Ujian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <a href="#" onclick="return view_petunjuk('petunjuk');">petunjuk ..?</a>
          <div id="petunjuk">
            <ul>
              <li><b>Jml Soal</b>, harap dimasukkan sesuai jumlah soal yang sudah ada di bank soal</li>
              <li><b>Tgl Mulai</b>, adalah waktu awal boleh mulai meng-klik tombol "mulai ujian"</li>
              <li><b>Tgl Selesai</b>, adalah waktu akhir boleh mulai meng-klik tombol "mulai ujian"</li>
              <li><b>Acak Soal</b>, jika dipilih acak, maka soal akan diacak, jika diurutkan, maka akan diurutkan berdasarkan urutan soal masuk</li>
            </ul>
          </div>
        </div>

        <form name="f_ujian" id="f_ujian" onsubmit="return m_ujian_s();">
          <input type="hidden" name="id" id="id" value="0">
          <input type="hidden" name="jumlah_soal1" id="jumlah_soal1" value="0">
          <table class="table table-form">
            <tr><td style="width: 25%">Nama Ujian</td><td style="width: 75%"><input type="text" class="form-control" name="nama_ujian" id="nama_ujian" required></td></tr>
            <tr><td>Mata Pelajaran</td><td><?php echo form_dropdown('mapel', $p_mapel, '', 'class="form-control"  id="mapel" required'); ?></td></tr>
            <tr><td>Jumlah soal</td><td><?php echo form_input('jumlah_soal', '', 'class="form-control"  id="jumlah_soal" required'); ?></td></tr>
            <tr><td>Tgl Mulai</td><td>
              <input type="date" name='tgl_mulai' class="form-control" style="width: 150px; display: inline; float: left" id="tgl_mulai" placeholder="Tgl" data-tooltip="waktu awal boleh menge-klik tombol \"mulai\" ujian" required>
              <input type="time" name='wkt_mulai' class="form-control" style="width: 100px; display: inline; float: left" id="wkt_mulai" placeholder="Waktu" required>
            </td></tr>
            <tr><td>Tgl Selesai</td><td>
              <input type="date" name='terlambat' class="form-control" style="width: 150px; display: inline; float: left" id="terlambat" placeholder="Tgl" required>
              <input type="time" name='terlambat2' class="form-control" style="width: 100px; display: inline; float: left" id="terlambat2" placeholder="Waktu" required>
            </td></tr>
            <tr><td>Waktu Ujian</td><td><?php echo form_input('waktu', '', 'class="form-control" id="waktu" placeholder="menit" required style="width: 100px; display: inline; float: left"'); ?> <div style="float: left; margin: 4px 0 0 10px"> menit</div></td></tr>
            <tr><td>Acak Soal</td><td><?php echo form_dropdown('acak', $pola_tes, '', 'class="form-control"  id="acak" required'); ?></td></tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
          <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-minus-circle"></i> Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/resources/js/jquery-1.11.3.min.js"></script> 
