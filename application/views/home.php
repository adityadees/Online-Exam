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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/ui/prism.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/vendors/css/file-uploaders/dropzone.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/plugins/file-uploaders/dropzone.min.css">
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
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
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
          <a class="navbar-brand" href="<?= base_url();?>adm">
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


<?php echo gen_menu(); ?>

<div class="app-content content">
   <div class="content-wrapper">
      <div class="content-body">
     

         <?php echo $this->load->view($p); ?>


      </div>
   </div>
</div>

<!-- insert modal -->
<div id="tampilkan_modal"></div>


<footer class="footer footer-static footer-light navbar-border">
 <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
 </p>
</footer>
<script src="<?php echo base_url();?>assets/backend/vendors/js/vendors.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/charts/raphael-min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/charts/morris.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/extensions/unslider-min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/timeline/horizontal-timeline.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/core/app-menu.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/core/app.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/scripts/customizer.js" type="text/javascript"></script>
  <!--
  <script src="<?php echo base_url();?>assets/backend/js/scripts/pages/dashboard-ecommerce.js" type="text/javascript"></script>
    <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAogXD-AHrsmnWinZIyhRORJ84bgLwDPpg&callback=initMap">
</script>

  <script src="<?php echo base_url();?>assets/backend/js/scripts/forms/wizard-steps.js" type="text/javascript"></script>
  <script src="<?php echo base_url();?>assets/backend/js/extensions/jquery.steps.min.js" type="text/javascript"></script>
-->
<script src="<?php echo base_url();?>assets/backend/js/scripts/tables/datatables/datatable-basic.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/scripts/extensions/sweet-alerts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/vendors/js/extensions/sweetalert.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/backend/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/scripts/extensions/toastr.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/backend/vendors/js/forms/toggle/bootstrap-checkbox.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/backend/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/scripts/forms/switch.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/backend/vendors/js/ui/prism.min.js" type="text/javascript"></script><!-- 
<script src="<?php echo base_url();?>assets/backend/vendors/js/extensions/dropzone.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/js/scripts/extensions/dropzone.min.js" type="text/javascript"></script> -->
<?php 
if ($this->uri->segment(2) == "soal_ujian" && $this->uri->segment(3) == "edit") {
   ?>
   <script src="<?php echo base_url(); ?>assets/resources/plugin/ckeditor/ckeditor.js"></script>
   <?php
}
?>

<!-- <script src="<?php echo base_url(); ?>assets/resources/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/resources/plugin/datatables/dataTables.bootstrap.min.js"></script>
-->
<script src="<?php echo base_url(); ?>assets/resources/plugin/jquery_zoom/jquery.zoom.min.js"></script>
<script src="<?php echo base_url(); ?>assets/resources/plugin/countdown/jquery.countdownTimer.js"></script>


<script type="text/javascript">
   var base_url = "<?php echo base_url(); ?>";
   var editor_style = "<?php echo $this->config->item('editor_style'); ?>";
   var uri_js = "<?php echo $this->config->item('uri_js'); ?>";
</script>
<script src="<?php echo base_url(); ?>assets/resources/js/aplikasi.js?time=<?php echo time(); ?>"></script> 

</body>
</html>
