<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Import Data Soal</h4>
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
                   <form name="f_siswa" action="<?php echo base_url(); ?>import/soal" id="f_siswa" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="id" id="id" value="0">
                    <table class="table table-form">
                        <tr><td style="width: 25%">Guru</td><td style="width: 75%">
                            <?php echo form_dropdown('id_guru', $p_guru, '', 'class="form-control" id="id_guru" required'); ?>
                        </td></tr>
                        <tr><td>Mata Pelajaran</td><td><?php echo form_dropdown('id_mapel', $p_mapel, '', 'class="form-control" id="id_mapel" required'); ?></td></tr>

                        <tr><td>File</td><td><input type="file" class="form-control col-md-3" name="import_excel" required></td></tr>
                        <tr><td></td><td>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                            <a href="<?php echo base_url(); ?>adm/siswa" class="btn btn-default"><i class="fa fa-minus-circle"></i> Kembali</a>
                        </td></tr>
                    </table>
                </form>


            </div>
        </div>
    </div>
</div>

</div>

