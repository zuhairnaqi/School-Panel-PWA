<?php
session_start();  
include("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;

}
$mobileno='';
if(isset($_POST['Add']))
{
  if(isset($_SESSION['schooladmin'])) 
  {
  $school=$_SESSION['schooladmin']['id'];  
  $mobileno=explode(',',$_POST['mobileno']);
  
  if($mobileno) 
  {
      
      $sqls = $conn->query("SELECT * FROM `schooladmin` WHERE id=".$school);
      $exs = $sqls->fetch_assoc();
      $schoolsname = $exs['schoolname'];
      for($i=0;$i<count($mobileno);$i++)
      { 
        
        $mno = preg_replace('/\s+/', '',$mobileno[$i]);
        $sql = $conn->query("SELECT * FROM `parent` WHERE mobileno='$mno'");
        $cnt = $sql->num_rows;
        if($cnt==1)
        {
          $error="Mobile Number Already Exist";
          header("location:".BASE_URL."admin/parent/add.php?error=".$error);
        }

        else if(!is_numeric($mno))
        {
          $error2="Mobile Number Can't Contain Alphabets";
          header("location:".BASE_URL."admin/parent/add.php?error=".$error2);
        }
        
        else if(strlen($mno)!=10)
        {
          $error1="Mobile Number Must Contain Only 10 Digits";
          header("location:".BASE_URL."admin/parent/add.php?error=".$error1);
        }
        
        else
        {
           $sql2="INSERT INTO `parent`(`school`,`mobileno`,`password`,`status`) VALUES ('$school','$mno','$mno','Active')";

          $usernme = 'myideal';
          $password = '123456';
          $from = 'MISAPP';
          $sms_text = urlencode("Download $schoolsname Mobile App https://play.google.com/store/apps/details?id=school.myideal.intel.myidealschool \n \n Sign in and add Student \n School ID- $school \n  Mobile No.-$mno \n Password -$mno \n \n Read User Guide - www.myidealschoolapp.com/parentapp.pdf");

           $api_url = "http://www.ptechsms.co.in/app/smsapi/index.php?username=".$usernme."&password=".$password."&campaign=6681&routeid=100636&type=text&contacts=".$mno."&senderid=".$from."&msg=".$sms_text;

           $response = file_get_contents($api_url);
           echo $response; 
          $ex2=$conn->query($sql2);

          if($ex2)
          {
            $insert="Parent Added Successfully";
            header("location:".BASE_URL."admin/parent/add.php?insert=".$insert);
          }
          else
          {
            $error="Not Added Successfully";
            header("location:".BASE_URL."admin/parent/add.php?error=".$error);
          }
        }
    }
      
  }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Add Parent</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/select2/dist/css/select2.min.css"><!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style type="text/css">
  .error
  {
    color: red;
  }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <?php include('../../assets/include/header.php'); ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include('../../assets/include/sidebar.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Parent
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Parent</a></li>
        <li class="active">Add Parent</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Parent</h3>
              
            </div>
            <h4 align="center" style="color: green">
              <?php
              if(isset($_REQUEST['insert']))
              {
                echo $_REQUEST['insert'];
              }
              ?>
            </h4>
            <h4 align="center" style="color: red">
              <?php
              if(isset($_REQUEST['error']))
              {
                echo $_REQUEST['error'];
              }
              ?> 
            </h4>
            <h4 align="center" style="color: red">
              <?php
              if(isset($_REQUEST['error1']))
              {
                echo $_REQUEST['error1'];
              }
              ?> 
            </h4>
            <h4 align="center" style="color: red">
              <?php
              if(isset($_REQUEST['error2']))
              {
                echo $_REQUEST['error2'];
              }
              ?> 
            </h4>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile Number</label><br>
                  <h4>Note : Copy-Paste Mobile Nos from notepad or excel sheet or type in below BOX line by line</h4>
                  <h4>Please write one mobile no in each line e.g</h4>
                  9958******<br>
                  9654******
                  <textarea rows="5" class="form-control" placeholder="Enter maximum 5000 number only" name="mobileno" ></textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="Add" id="addclass" class="btn btn-primary">Add Parent</button>
                <a href="<?php echo BASE_URL ?>admin/parent/list.php" class="btn btn-primary">List Parent</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <?php include('../../assets/include/footer.php'); ?>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <?php include('../../assets/include/controlsidebar.php'); ?>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- FastClick -->
<script src="<?php echo BASE_URL ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo BASE_URL ?>assets/dist/js/demo.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
})
</script>

</body>
</html>
