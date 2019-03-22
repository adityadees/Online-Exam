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
      <a class="btn btn-outline-primary" href="#" onclick="return guru_e(0);"><i class="ft-plus"></i></a>
      <a class="btn btn-outline-primary" href="<?php echo base_url(); ?>upload/format_import_guru.xlsx"><i class="ft-download"></i></a>
      <a class="btn btn-outline-primary" href="<?php echo base_url(); ?>adm/guru/import"><i class="ft-upload"></i></a>
    </div>
  </div>
</div>



<div class="row">
  <div class="col-xl-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title"> Data Guru</h4>
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
                <th width="40%">Nama</th>
                <th width="20%">NIP/Username</th>
                <th width="35%">Aksi</th>
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




<div class="modal fade" id="guru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel">Data Guru</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form name="f_guru" id="f_guru" onsubmit="return guru_s();">
          <input type="hidden" name="id" id="id" value="0">
          <table class="table table-form">
            <tr><td style="width: 25%">NIP</td><td style="width: 75%"><input type="text" class="form-control" name="nip" id="nip" required></td></tr>
            <tr><td style="width: 25%">Nama</td><td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td></tr>
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
