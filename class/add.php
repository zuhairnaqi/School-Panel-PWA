<?php
session_start();  
include("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;

}
$class='';
if(isset($_POST['Add']))
{
  if(isset($_SESSION['schooladmin'])) 
  {
  $school=$_SESSION['schooladmin']['id'];  
  $classname=$_POST['classname'];
  if($classname == '')
  {
  $class="Please Class Name Required.";
  }
  elseif ($classname) 
  {
    $classs="SELECT * FROM `class` WHERE `classname`='$classname' AND `school`='$school'";
    $ex1=$conn->query($classs);
    $num=mysqli_num_rows($ex1);
    if($num >=  1)
    {
      $class="Please Class Must Be Unique.";
    }
    else
    {
      $sql2="INSERT INTO `class`(`classname`,`school`) VALUES ('$classname','$school')";
  $ex2=$conn->query($sql2);
  if($ex2)
  {
    $insert="Add Class Successfully";
    header("location:".BASE_URL."admin/class/add.php?insert=".$insert);
    //header("location:".BASE_URL."api/class/add.php");
  }
  else
  {
    $error="Not Add Class Successfully";
    header("location:".BASE_URL."admin/class/add.php?error=".$error);
  }
    }
  }
  else
  {
  $sql="INSERT INTO `class`(`classname`,`school`) VALUES ('$classname','$school')";
  $ex=$conn->query($sql);
  if($ex)
  {
    $insert="Add Class Successfully";
    header("location:".BASE_URL."admin/class/add.php?insert=".$insert);
  }
  else
  {
    $error="Not Add Class Successfully";
    header("location:".BASE_URL."admin/class/add.php?error=".$error);
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
  <title>Add Class</title>
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
        Add Class
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Class</a></li>
        <li class="active">Add Class</li>
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
              <h3 class="box-title">Add Class</h3>
            </div>
            <h3 align="center" style="color: green">
              <?php
              if(isset($_REQUEST['insert']))
              {
                echo $_REQUEST['insert'];
              }
              ?>
            </h3>
            <h3 align="center" style="color: red">
              <?php
              if(isset($_REQUEST['error']))
              {
                echo $_REQUEST['error'];
              }
              ?>
            </h3>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Class Name</label>
                  <input type="text" class="form-control" id="classname" placeholder="Enter Class Name" name="classname" value="<?php if(isset($_POST['classname'])){echo $_POST['classname'];} ?>">
                </div>
                <span class="error"><?php echo $class ?></span>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="Add" id="addclass" class="btn btn-primary">Add Class</button>
                <a href="<?php echo BASE_URL ?>admin/class/list.php" class="btn btn-primary">List Class</a>
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
