<?php
session_start();  
require_once("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}
if(isset($_REQUEST['editid']))
{
  $editid=$_REQUEST['editid'];
  $sql="SELECT * FROM `teacher` WHERE `teacherid`='$editid'";
  $ex=$conn->query($sql);
  $teacher=$ex->fetch_object();
}

if(isset($_POST['Update']))
{
  if(isset($_SESSION['schooladmin'])) 
  {
  $teacherid = $_POST['teacherid'];
  $school=$_SESSION['schooladmin']['id'];
  $teachername = $_POST['teachername'];
  $email = $_POST['email'];
  $mobileno=$_POST['mobileno'];
  $oldphoto = $_POST['oldphoto'];
  $password = $_POST['password'];
  $date = date('d/m/Y');
  
  $teacherprofile = $_FILES['teacherprofile']['name'];
  $teacherprofile_tmp = $_FILES['teacherprofile']['tmp_name'];
  
  if($_FILES['teacherprofile']['error'] == 4)
  {
      $sql = "UPDATE `teacher` SET `teachername`='$teachername',`mobileno`='$mobileno',`email`='$email',`password`='$password',`teacherprofile`='$oldphoto',`school`='$school' WHERE `teacherid`='$teacherid'";
      
      $ex=$conn->query($sql);
      if($ex)
      {
         $insert="Teacher Updated Successfully";
         header("location:".BASE_URL."admin/teacher/list.php?update=".$insert); 
      }
      else
      {
        $error="Teacher Not Updated Successfully";
        header("location:".BASE_URL."admin/teacher/list.php?error=".$error);
      }
  }
  else{
      move_uploaded_file($teacherprofile_tmp, '../../assets/uploads/teacher/'.$teacherprofile);
      $sql = "UPDATE `teacher` SET `teachername`='$teachername',`mobileno`='$mobileno',`email`='$email',`password`='$password',`teacherprofile`='$teacherprofile',`school`='$school' WHERE `teacherid`='$teacherid'";
      
      $ex=$conn->query($sql);
      if($ex)
      {
         $insert="Teacher Updated Successfully";
         header("location:".BASE_URL."admin/teacher/list.php?update=".$insert); 
      }
      else
      {
        $error="Teacher Not Updated Successfully";
        header("location:".BASE_URL."admin/teacher/list.php?error=".$error);
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
  <title>Add Teacher</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Theme style -->
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
        Add Teacher
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Teacher</a></li>
        <li class="active">Add Teacher</li>
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
              <h3 class="box-title">Add Teacher</h3>
            </div>
            <h3 align="center" style="color: green">
              <?php
              if(isset($_REQUEST['update']))
              {
                echo $_REQUEST['update'];
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
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="col-md-12">
                  <div class="form-group">
                  <label for="exampleInputFile">Teacher Name</label>
                  <input type="text" class="form-control" name="teachername" placeholder="Enter Name" value="<?php echo $teacher->teachername ?>" >
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile No</label>
                  <input type="text" class="form-control" name="mobileno" placeholder="Enter Mobile Number" value="<?php echo $teacher->mobileno ?>">
                </div>
                 <div class="form-group">
                  <label for="exampleInputEmail1">Email Address</label>
                  <input type="text" class="form-control" name="email" placeholder="Enter Email" value="<?php echo $teacher->email ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Set Password</label>
                  <input type="text" class="form-control" name="password" placeholder="Enter Password" value="<?php echo $teacher->password ?>" >
                </div>
                
                <div class="form-group">
                  <label for="exampleInputFile">Teacher Photo</label>
                  <input type="file" id="exampleInputFile" class="form-control" name="teacherprofile" >
                  <img src="<?php echo BASE_URL.'assets/uploads/teacher/' ?><?php echo $teacher->teacherprofile; ?>" height="50" width="50">
                  <input type="hidden" name="oldphoto" value="<?php echo $teacher->teacherprofile; ?>">
                  <input type="hidden" name="teacherid" value="<?php echo $teacher->teacherid;  ?>">
                </div>

                
              </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="Update" value="Update Teacher" class="btn btn-primary">
                <a href="<?php echo BASE_URL ?>admin/teacher/list.php" class="btn btn-primary">List Teacher</a>
              </div>
            </form>
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
<script src="<?php echo BASE_URL ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
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
  $('#datepicker').datepicker({
      autoclose: true
    })
</script>

</body>
</html>
