<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>Ujian Online</title>
  <link rel="apple-touch-icon" href="<?php echo base_url();?>assets/backend/images/ico/apple-icon-120.png">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/core/menu/menu-types/vertical-menu-modern.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/vendors.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/extensions/unslider.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/weather-icons/climacons.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/fonts/meteocons/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/charts/morris.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/app.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/fonts/simple-line-icons/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/ui/prism.min.css"><!-- 
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/file-uploaders/dropzone.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/plugins/file-uploaders/dropzone.min.css"> -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/pages/timeline.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/tables/datatable/datatables.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/plugins/forms/wizard.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/extensions/sweetalert.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/backend/vendors/css/extensions/toastr.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/backend/css/plugins/extensions/toastr.min.css">

  <link href="<?php echo base_url(); ?>assets/resources/plugin/fa/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/resources/plugin/datatables/dataTables.bootstrap.css" rel="stylesheet">
<!--
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendors/css/forms/toggle/switchery.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/core/menu/menu-types/vertical-menu-modern.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/plugins/forms/switch.min.css">
-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/backend/assets/css/style.css">


<!-- <link href="<?php echo base_url(); ?>assets/resources/css/bootstrap.css" rel="stylesheet"> -->
<!-- <link href="<?php echo base_url(); ?>assets/resources/css/style.css?<?php echo time(); ?>" rel="stylesheet"> -->
<style type="text/css">
  .no-js #loader { display: none;  }
  .js #loader { display: block; position: absolute; left: 100px; top: 0; }
  .se-pre-con {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(<?php echo base_url('assets/resources/img/facebook.gif'); ?>) center no-repeat #fff;
  }

  .ajax-loading {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: #6f6464;
    opacity: 0.75;
    color: #fff;
    text-align: center;
    font-size: 25px;
    padding-top: 200px;
    display: none;
  }
</style>
</head>


<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" onload="document.documentElement.webkitRequestFullScreen();">
  <div class="se-pre-con"></div>

  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
   <div class="navbar-wrapper">
     <div class="navbar-header">
       <ul class="nav navbar-nav flex-row position-relative">
         <li class="nav-item mobile-menu d-md-none mr-auto">
           <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
             <i class="ft-menu font-large-1"></i>
           </a>
         </li>
         <li class="nav-item mr-auto">
          <a class="navbar-brand" href="<?= base_url();?>admin">
            <h2 class="brand-text">Apps</h2>
          </a>
        </li>
        <li class="nav-item d-none d-md-block nav-toggle">
         <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
           <i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i>
         </a>
       </li>
       <li class="nav-item d-md-none">
        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile">
          <i class="fa fa-ellipsis-v"></i>
        </a>
      </li>
    </ul>
  </div>
  <div class="navbar-container content">
   <div class="collapse navbar-collapse" id="navbar-mobile">
     <ul class="nav navbar-nav mr-auto float-left">
       <li class="nav-item d-none d-md-block">
         <a class="nav-link nav-link-expand" href="#">
           <i class="ficon ft-maximize"></i>
         </a>
       </li>
       <li class="nav-item nav-search">
        <a class="nav-link nav-link-search" href="#">
          <i class="ficon ft-search"></i>
        </a>
        <div class="search-input">
          <input class="input" type="text" placeholder="Explore Stack...">
        </div>
      </li>
    </ul>
    <ul class="nav navbar-nav float-right">
     <li class="dropdown dropdown-user nav-item">
       <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
         <span class="user-name"><?php echo $this->session->userdata('admin_nama')." (".$this->session->userdata('admin_user').")"; ?> </span>
       </a>




       <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="#" onclick="return rubah_password();">
          <i class="ft-globe"></i> Ubah Password
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo base_url(); ?>adm/logout" onclick="return confirm('keluar..?');">
          <i class="ft-power"></i> Logout</a>
        </div>
      </li>
    </ul>
  </div>
</div>
</div>
</nav>


<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true" id="v_jawaban">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      <li class=" navigation-header">
        <span>Navigasi Soal</span><i class=" ft-minus" data-toggle="tooltip" data-placement="right"
        data-original-title="General"></i>
      </li>

      <div id="tampil_jawaban" class="text-center"></div>

    </ul>
  </div>
</div>



<div class="app-content content">
 <div class="content-wrapper">
  <div class="content-body">

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-12">
        <div class="card">
          <div class="card-content">
            <div class="media align-items-stretch">
              <div class="p-2 bg-gradient-x-primary white media-body">
                <div class="row">
                  <div class="col-md-6">
                    <a id="tbl_show_jawaban" href="#" onclick="return show_jawaban()" class="btn btn-info" title="Tampilkan bilah jawaban"><i class="glyphicon glyphicon-search"></i> ON / OFF Navigasi Soal</a>
                  </div>
                  <div class="col-md-6">
                    <a class="btn btn-danger float-right" onclick="return simpan_akhir();"><i class="fa fa-stop"></i>&nbsp;&nbsp;Akhiri Ujian</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>


  <div class="row match-height">
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Soal</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="col-md-12">
              <form role="form" name="_form" method="post" id="_form">
                <div class="row">
                  <div class="col-md-6">
                    Soal Ke <div class="btn btn-info" id="soalke"></div>
                  </div>
                  <div class="col-md-6">
                    <div id="clock" style="font-weight: bold" class="btn btn-danger float-right"></div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-12">
                    <div class="panel-body" style="overflow: auto">
                      <br>
                      <b>Pertanyaan :</b> 
                      <?php echo $html; ?>
                    </div>
                    <div class="panel-footer text-center">
                      <a class="action back btn btn-info" rel="0" onclick="return back();"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>

                      <a class="action next btn btn-info" rel="2" onclick="return next();"><i class="glyphicon glyphicon-chevron-right"></i> Next</a>

                      <a class="ragu_ragu btn btn-warning" rel="1" onclick="return tidak_jawab();">Ragu-ragu</a>

                      <a class="selesai action submit btn btn-danger" onclick="return simpan_akhir();"><i class="glyphicon glyphicon-stop"></i> Selesai</a>

                      <input type="hidden" name="jml_soal" id="jml_soal" value="<?php echo $no; ?>">
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<div class="ajax-loading"><i class="fa fa-spin fa-spinner"></i> Loading ...</div>
<script src="<?php echo base_url();?>assets/backend/vendors/js/vendors.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/extensions/unslider-min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/timeline/horizontal-timeline.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/backend/js/core/app-menu.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/core/app.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/scripts/customizer.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/backend/vendors/js/forms/toggle/bootstrap-checkbox.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/resources/js/jquery-1.11.3.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/resources/js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/resources/plugin/countdown/jquery.countdownTimer.js"></script> 
<script src="<?php echo base_url(); ?>assets/resources/plugin/jquery_zoom/jquery.zoom.min.js"></script>
<script type="text/javascript">
$(document).on("keydown",function(ev){
  console.log(ev.keyCode);
  if(ev.keyCode===27||ev.keyCode===122) return false
})
</script>
<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";
  id_tes = "<?php echo $id_tes; ?>";
  $(window).load(function() {
    $(".se-pre-con").fadeOut("slow");
  });

  function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    $.map(unindexed_array, function(n, i){
      indexed_array[n['name']] = n['value'];
    });
    return indexed_array;
  }
  
  $(document).on("ready", function(){
    $('.gambar').each(function(){
      var url = $(this).attr("src");
      $(this).zoom({url: url});
    });

    hitung();
    simpan_sementara();
    buka(1);

    widget      = $(".step");
    btnnext     = $(".next");
    btnback     = $(".back"); 
    btnsubmit   = $(".submit");

    $(".step").hide();
    $(".back").hide();
    $("#widget_1").show();
  });

  widget      = $(".step");
  total_widget = widget.length;
  
  simpan_sementara = function() {
    var f_asal  = $("#_form");
    var form  = getFormData(f_asal);
        //form = JSON.stringify(form);
        var jml_soal = form.jml_soal;
        jml_soal = parseInt(jml_soal);

        var hasil_jawaban = "";

        for (var i = 1; i < jml_soal; i++) {
          var idx = 'opsi_'+i;
          var idx2 = 'rg_'+i;
          var jawab = form[idx];
          var ragu = form[idx2];

          if (jawab != undefined) {
            if (ragu == "Y") {
              if (jawab == "-") {
                hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". "+jawab+"</a>";
              } else {
                hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-warning btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". "+jawab+"</a>";
              }
            } else {
              if (jawab == "-") {
                hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". "+jawab+"</a>";
              } else {
                hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-success btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". "+jawab+"</a>";
              }
            }
          } else {
            hasil_jawaban += '<a id="btn_soal_'+(i)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i)+');">'+(i)+". -</a>";
          }
        }

        $("#tampil_jawaban").html('<div id="yes"></div>'+hasil_jawaban);
      }

      simpan = function() {
        var f_asal  = $("#_form");
        var form  = getFormData(f_asal);
        
        $.ajax({    
          type: "POST",
          url: base_url+"adm/ikut_ujian/simpan_satu/"+id_tes,
          data: JSON.stringify(form),
          dataType: 'json',
          contentType: 'application/json; charset=utf-8',
          beforeSend: function() {
            $('.ajax-loading').show();    
          }
        }).done(function(response) {
          $('.ajax-loading').hide(); 
          
          var hasil_jawaban = "";
          var panjang       = response.data.length;
          
          for (var i = 0; i < panjang; i++) {
            if (response.data[i] != "_N") {
              var getjwb = response.data[i];
              var pc_getjwb = getjwb.split('_');

              if (pc_getjwb[1] == "Y") {
                if (pc_getjwb[0] == "-") {
                  hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". "+pc_getjwb[0]+"</a>";
                } else {
                  hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-warning btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". "+pc_getjwb[0]+"</a>";
                }
              } else {
                if (pc_getjwb[0] == "-") {
                  hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". "+pc_getjwb[0]+"</a>";
                } else {
                  hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-success btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". "+pc_getjwb[0]+"</a>";
                }
              }
            } else {
              hasil_jawaban += '<a id="btn_soal_'+(i+1)+'" class="btn btn-default btn_soal btn-sm" onclick="return buka('+(i+1)+');">'+(i+1)+". -</a>";
            }
          }

            //$("#tampil_jawaban").html('<div id="yes"></div>'+hasil_jawaban);
          });
        return false;
      }
      
      hitung = function() {
        var tgl_mulai = '<?php echo date('Y-m-d H:i:s'); ?>';
        var tgl_selesai = '<?php echo $jam_selesai; ?>';

        $("div#clock").countdowntimer({
          startDate : tgl_mulai,
          dateAndTime : tgl_selesai,
          size : "lg",
          displayFormat: "HMS",
          timeUp : selesai,
        });
      }

      selesai = function() {
        var f_asal  = $("#_form");
        var form  = getFormData(f_asal);
        simpan_akhir(id_tes);
        window.location.assign("<?php echo base_url(); ?>adm/sudah_selesai_ujian/"+id_tes); 

        return false;
      }

      next = function() {
        var berikutnya  = $(".next").attr('rel');
        berikutnya = parseInt(berikutnya);
        berikutnya = berikutnya > total_widget ? total_widget : berikutnya;

        $("#soalke").html(berikutnya);

        $(".next").attr('rel', (berikutnya+1));
        $(".back").attr('rel', (berikutnya-1));
        $(".ragu_ragu").attr('rel', (berikutnya));
        cek_status_ragu(berikutnya);
        cek_terakhir(berikutnya);
        
        var sudah_akhir = berikutnya == total_widget ? 1 : 0;

        $(".step").hide();
        $("#widget_"+berikutnya).show();

        if (sudah_akhir == 1) {
          $(".back").show();
          $(".next").hide();
        } else if (sudah_akhir == 0) {
          $(".next").show();
          $(".back").show();
        }

        simpan_sementara();
        simpan();
      }

      back = function() {
        var back  = $(".back").attr('rel');
        back = parseInt(back);
        back = back < 1 ? 1 : back;

        $("#soalke").html(back);
        
        $(".back").attr('rel', (back-1));
        $(".next").attr('rel', (back+1));
        $(".ragu_ragu").attr('rel', (back));
        cek_status_ragu(back);
        cek_terakhir(back);
        
        $(".step").hide();
        $("#widget_"+back).show();

        var sudah_awal = back == 1 ? 1 : 0;

        $(".step").hide();
        $("#widget_"+back).show();
        
        if (sudah_awal == 1) {
          $(".back").hide();
          $(".next").show();
        } else if (sudah_awal == 0) {
          $(".next").show();
          $(".back").show();
        }

        simpan_sementara();
        simpan();
      }

      tidak_jawab = function() {
        var id_step = $(".ragu_ragu").attr('rel');
        var status_ragu = $("#rg_"+id_step).val();

        if (status_ragu == "N") {
          $("#rg_"+id_step).val('Y');
          $("#btn_soal_"+id_step).removeClass('btn-success');
          $("#btn_soal_"+id_step).addClass('btn-warning');

        } else {
          $("#rg_"+id_step).val('N');
          $("#btn_soal_"+id_step).removeClass('btn-warning');
          $("#btn_soal_"+id_step).addClass('btn-success');
        }


        cek_status_ragu(id_step);

        simpan_sementara();
        simpan();
      }

      cek_status_ragu = function(id_soal) {
        var status_ragu = $("#rg_"+id_soal).val();

        if (status_ragu == "N") {
          $(".ragu_ragu").html('Ragu');
        } else {
          $(".ragu_ragu").html('Tidak Ragu');
        }
      }

      cek_terakhir = function(id_soal) {
        var jml_soal = $("#jml_soal").val();
        jml_soal = (parseInt(jml_soal) - 1);

        if (jml_soal == id_soal) {
          $(".selesai").show();
        } else {
          $(".selesai").hide();
        }
      }

      buka = function(id_widget) {
        $(".next").attr('rel', (id_widget+1));
        $(".back").attr('rel', (id_widget-1));
        $(".ragu_ragu").attr('rel', (id_widget));
        cek_status_ragu(id_widget);
        cek_terakhir(id_widget);

        $("#soalke").html(id_widget);
        
        $(".step").hide();
        $("#widget_"+id_widget).show();
      }

      simpan_akhir = function() {
        simpan();
        if (confirm('Ujian telah selesai. Anda yakin akan mengakhiri tes ini..?')) {
          simpan();
          $.ajax({
            type: "GET",
            url: base_url+"adm/ikut_ujian/simpan_akhir/"+id_tes,
            beforeSend: function() {
              $('.ajax-loading').show();    
            },
            success: function(r) {
              if(r.status == "ok") {
                window.location.assign("<?php echo base_url(); ?>adm/sudah_selesai_ujian/"+id_tes); 
              }
            }
          });

          return false;
        }
      }

      show_jawaban = function() {
        $("#v_jawaban").toggle();
      }
    </script>
  </body>
  </html>
