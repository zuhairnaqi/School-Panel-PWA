<?php
session_start();  
 include("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}



if(isset($_POST['Add']))
{
  if(isset($_SESSION['schooladmin'])) 
  {
  $studentname=$_POST['studentname'];
  $fathername = $_POST['fathername'];
  $mothername = $_POST['mothername'];
  $address = $_POST['address'];
  $mno = $_POST['mno'];
  $dob = $_POST['dob'];
  $bloodgroup = $_POST['bloodgroup'];
  $school=$_SESSION['schooladmin']['id'];
  $pincode = $_POST['pincode'];
  $joindate = date('d/m/Y h:i');
  $class=$_POST['class'];
  $parent = $_POST['parent'];
  $district = $_POST['district'];
  $state = $_POST['state'];
  $roleno=$_POST['roleno'];
  $mno=$_POST['mno'];
  $photoname=$_FILES['photo']['name'];
  $oldpath=$_FILES['photo']['tmp_name'];
  $newpath="../../assets/uploads/student/".$photoname;
  move_uploaded_file($oldpath, $newpath);
  
  
  
  $sql="INSERT INTO `student`(`studentname`, `fathername`, `mothername`, `class`, `roleno`, `address`, `mno`, `dob`, `bloodgroup`, `photo`, `parent`, `status`, `addby`, `school`, `district`, `state`, `pincode`, `joindate`, `thumbimg`) VALUES ('$studentname','$fathername','$mothername','$class','$roleno','$address','$mno','$dob','$bloodgroup','$photoname','$parent','Active','School','$school','$district','$state','$pincode','$joindate','')";

  $ex=$conn->query($sql);
  if($ex)
  {
    $insert="Student Added Successfully";
    header("location:".BASE_URL."admin/students/add.php?insert=".$insert);
  }
  else
  {
    $error="Student Not Added";
    header("location:".BASE_URL."admin/students/add.php?error=".$error);
  }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Add Student</title>
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
        Add Student
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Student</a></li>
        <li class="active">Add Student</li>
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
              <h3 class="box-title">Add Student</h3>
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
            <!-- form start -->
            <form role="form" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputEmail1">Student Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Student Name" name="studentname" required="required">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Father Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Father Name" name="fathername" required="required">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Mother Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Mother Name" name="mothername" required="required">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Class</label>
                  <select class="form-control select2" name="class" id="classid">
                    <option value=" ">Select Class</option>
                    <?php 
                    $sql="SELECT * FROM `class` WHERE school=".$_SESSION['schooladmin']['id'];
                    $ex=$conn->query($sql);
                    while ($class=$ex->fetch_object()) 
                    {
                    ?>
                    <option value="<?php echo $class->classid ?>"><?php echo $class->classname ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>

             

                <div class="form-group">
                  <label for="exampleInputEmail1">Roll No</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Roll No" name="roleno" required="required">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Address" name="address" required="required">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Mobile Number</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Mobile Number" name="mno" required="required">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Date of Birth</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Date of Birth" name="dob" required="required">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Blood Group</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Blood Group" name="bloodgroup" >
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Student Photo</label>
                  <input type="file" class="form-control" id="exampleInputEmail1" name="photo" required="required">
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Parent</label>
                  <select class="form-control select2" name="parent" id="parentid">
                    <option value=" ">Select Parent</option>
                    <?php 
                    $sql="SELECT * FROM `parent` WHERE school=".$_SESSION['schooladmin']['id'];
                    $ex=$conn->query($sql);
                    while ($class=$ex->fetch_object()) 
                    {
                    ?>
                    <option value="<?php echo $class->parentid ?>"><?php echo $class->mobileno ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">District</label>
                  <select class="form-control select2" name="district" id="districtid">
                    <option value=" ">Select District</option>
                    <?php 
                    $sql="SELECT * FROM `district`";
                    $ex=$conn->query($sql);
                    while ($class=$ex->fetch_object()) 
                    {
                    ?>
                    <option value="<?php echo $class->districtid ?>"><?php echo $class->districtname ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">State</label>
                  <select class="form-control select2" name="state" id="stateid">
                    <option value=" ">Select State</option>
                    <?php 
                    $sql="SELECT * FROM `state`";
                    $ex=$conn->query($sql);
                    while ($class=$ex->fetch_object()) 
                    {
                    ?>
                    <option value="<?php echo $class->stateid ?>"><?php echo $class->statename ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="Add" value="Add Student" class="btn btn-primary">
                <a href="<?php echo BASE_URL ?>admin/students/list.php" class="btn btn-primary">List Student</a>
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
