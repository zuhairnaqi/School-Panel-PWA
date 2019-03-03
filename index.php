<?php
session_start();  
require_once("../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}
else if(isset($_SESSION['superadmin']))
{
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}
else if(isset($_SESSION['parent']))
{
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>School Admin | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

 <!-- LINK FOR PWA -->
 <link rel="apple-touch-icon" sizes="57x57" href="./PWA/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="./PWA/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="./PWA/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="./PWA/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="./PWA/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="./PWA/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="./PWA/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="./PWA/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="./PWA/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/PWA/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="./PWA/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="./PWA/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="./PWA/favicon-16x16.png">
<link rel="manifest" href="./manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="./ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <?php include('../assets/include/header.php'); ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include('../assets/include/sidebar.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <?php 
              $sql = $conn->query("SELECT * FROM `class` WHERE school=".$_SESSION['schooladmin']['id']);
              $cnt = $sql->num_rows;
              ?>
              <h3><?php echo $cnt; ?></h3>

              <p>Class</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo BASE_URL ?>admin/class/list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php 
              $sql2 = $conn->query("SELECT * FROM `student` WHERE school=".$_SESSION['schooladmin']['id']);
              $cnt2 = $sql2->num_rows;
              ?>
              <h3><?php echo $cnt2 ?></h3>

              <p>Students</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo BASE_URL ?>admin/students/list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <?php 
              $sql3 = $conn->query("SELECT * FROM `parent` WHERE school=".$_SESSION['schooladmin']['id']);
              $cnt3 = $sql3->num_rows;
              ?>
              <h3><?php echo $cnt3 ?></h3>

              <p>Parents</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo BASE_URL ?>admin/parent/list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
              <?php 
              $sql4 = $conn->query("SELECT * FROM `homework` WHERE school=".$_SESSION['schooladmin']['id']);
              $cnt4 = $sql4->num_rows;
              ?>
              <h3><?php echo $cnt4; ?></h3>

              <p>Homework</p>
            </div>
            <div class="icon">
              <i class="ion ion-edit"></i>
            </div>
            <a href="<?php echo BASE_URL ?>admin/homework/list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <?php 
              $sql5 = $conn->query("SELECT * FROM `schoolannouncements` WHERE school=".$_SESSION['schooladmin']['id']);
              $cnt5 = $sql5->num_rows;
              ?>
              <h3><?php echo $cnt5; ?></h3>

              <p>Announcement</p>
            </div>
            <div class="icon">
              <i class="ion ion-edit"></i>
            </div>
            <a href="<?php echo BASE_URL ?>admin/announcement/listannouncement.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <?php 
              $sql22 = $conn->query("SELECT * FROM `notice` WHERE school=".$_SESSION['schooladmin']['id']);
              $cnt22 = $sql22->num_rows;
              ?>
              <h3><?php echo $cnt22 ?></h3>

              <p>Notice</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo BASE_URL ?>admin/notice/noticelist.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php 
              $sqlss = $conn->query("SELECT * FROM `teacher` WHERE school=".$_SESSION['schooladmin']['id']);
              $cntss = $sqlss->num_rows;
              ?>
              <h3><?php echo $cntss; ?></h3>

              <p>Teachers</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo BASE_URL ?>admin/teacher/list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <?php 
              $sql3 = $conn->query("SELECT * FROM `parent` WHERE school=".$_SESSION['schooladmin']['id']." AND deviceId=''");
              $cnt3 = $sql3->num_rows;
              ?>
              <h3><?php echo $cnt3 ?></h3>

              <p>Active Parents</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo BASE_URL ?>admin/parent/activelist.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Small boxes (Stat box) -->
      <div class="row">
        
       
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
              <div class="box-body">
                   <?php
               $date = date("d/m/Y");
                $totalhomework = $conn->query("SELECT * FROM `homework` WHERE school=".$_SESSION['schooladmin']['id']." AND homeworkdate='$date'");
                
                $count1 = $totalhomework->num_rows;
               ?><h4>Today's Homework :<?php echo $count1; ?> </h4>
               <?php
               
               $date = date("d/m/Y");
                $totalannouncement = $conn->query("SELECT * FROM `schoolannouncement` WHERE school=".$_SESSION['schooladmin']['id']." AND announcementdate='$date'");
                $count = $totalannouncement->num_rows;
               ?><h4>Today's Announcement : <?php echo $count; ?> </h4>
              
               <?php
               $date = date("d/m/Y");
                $totalnotice = $conn->query("SELECT * FROM `notice` WHERE school=".$_SESSION['schooladmin']['id']." AND noticedate='$date'");
                
                $count2 = $totalnotice->num_rows;
               ?><h4>Today's Notice :<?php echo $count2; ?> </h4>
              </div>
          </div>
        </div>
      </div>
      <!-- Main row -->
      
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <?php include('../assets/include/footer.php'); ?>
  </footer>

  <!-- Control Sidebar -->
 
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo BASE_URL ?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo BASE_URL ?>assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo BASE_URL ?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo BASE_URL ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo BASE_URL ?>assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo BASE_URL ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo BASE_URL ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo BASE_URL ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo BASE_URL ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo BASE_URL ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo BASE_URL ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo BASE_URL ?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo BASE_URL ?>assets/dist/js/demo.js"></script>

<script>
  // TODO add service worker code here
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker
             .register('./service-worker.js')
             .then(function() { console.log('Service Worker Registered'); });
  }

  var deferredPrompt= false;
window.addEventListener("load", () => {
    deferredPrompt = true;
})
window.addEventListener('beforeinstallprompt', (e) => {
    if(deferredPrompt){
        e.prompt();
        e.userChoice.then(choice => {
            if(choice.outcome === "dismissed"){
                deferredPrompt = false;
            }
        })
    }else {
        console.log('trigger is not trigerred!!');
    }

});

</script>
</body>
</html>
