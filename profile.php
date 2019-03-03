<?php
session_start();  
include("../config.php");
if(isset($_POST['submit']))
{
  $pass = $_POST['password'];
  $school = $_POST['school'];
  $cpassword = $_POST['cpassword'];

  if($pass!=$cpassword)
  {
    $msg = "Confirm Password Does Not Match";
    header("location:".BASE_URL."admin/profile.php?msg=".$msg);
  }
  else
  {
    $sqls = $conn->query("UPDATE `schooladmin` SET password='$pass' WHERE id='$school'");
    if($sqls)
    {
      $delete="Profile Updated Successfully";
      header("location:".BASE_URL."admin/profile.php?successmsg=".$delete);
    }
    else
    {
      $error="Not Updated";
      header("location:".BASE_URL."admin/profile.php?error=".$error);
    }
  }
}
if(isset($_POST['update']))
{
  $oldphoto=$_POST['oldphoto'];
  $school = $_POST['school'];
  $photo = $_FILES['photo']['name'];
  $photo_tmp = $_FILES['photo']['tmp_name'];
  if($_FILES['photo']['error']==4){
    echo $sql1="UPDATE `schooladmin` SET `schoollogo`='$oldphoto' WHERE `id`='$school'";

    $ex1=$conn->query($sql1);
    if($ex1)
    {
    $update="Updated Successfully";
    header("location:".BASE_URL."admin/profile.php?successmsg=".$update);
    }
    else
    {
    $error="Not Updated";
    header("location:".BASE_URL."admin/profile.php?error=".$error);
    }
  }
  else
  {
    move_uploaded_file($photo_tmp, '../assets/uploads/schooladmin/'.$photo);
    echo $sql1="UPDATE `schooladmin` SET `schoollogo`='$photo' WHERE `id`='$school'";

    $ex1=$conn->query($sql1);
    if($ex1)
    {
    $update="Updated Successfully";
    header("location:".BASE_URL."admin/profile.php?successmsg=".$update);
    }
    else
    {
    $error="Not Updated";
    header("location:".BASE_URL."admin/profile.php?error=".$error);
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Profile</title>
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
        School Profile
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo BASE_URL ?>assets/uploads/schooladmin/<?php echo $_SESSION['schooladmin']['schoollogo'] ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $_SESSION['schooladmin']['schoolname'] ?></h3>

              <p class="text-muted text-center">School</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Class</b> <a class="pull-right" href="<?php echo BASE_URL ?>admin/class/list.php">
                    <?php
                    $classsql = $conn->query("SELECT * FROM `class` WHERE school=".$_SESSION['schooladmin']['id']);
                    echo $class = $classsql->num_rows;
                    ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Students</b> <a class="pull-right" href="<?php echo BASE_URL ?>admin/students/list.php">
                    <?php
                    $studentsql = $conn->query("SELECT * FROM `student` WHERE school=".$_SESSION['schooladmin']['id']);
                    echo $student = $studentsql->num_rows;
                    ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Teachers</b> <a class="pull-right" href="<?php echo BASE_URL ?>admin/teacher/list.php">
                    <?php
                    $teachersql = $conn->query("SELECT * FROM `teacher` WHERE school=".$_SESSION['schooladmin']['id']);
                    echo $teacher = $teachersql->num_rows;
                    ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Parents</b> <a class="pull-right" href="<?php echo BASE_URL ?>admin/parent/list.php">
                    <?php
                    $parentsql = $conn->query("SELECT * FROM `parent` WHERE school=".$_SESSION['schooladmin']['id']);
                    echo $parent = $parentsql->num_rows;
                    ?>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Profile</a></li>
              <li><a href="#timeline" data-toggle="tab">Change Password</a></li>
              <li><a href="#profile" data-toggle="tab">Change Profile Picture</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <h4 align="center" style="color: green">
                  <?php
                  if(isset($_REQUEST['successmsg']))
                  {
                    echo $_REQUEST['successmsg'];
                  }
                  ?>
                </h4>
                <h4 align="center" style="color: red">
                  <?php
                  if(isset($_REQUEST['msg']))
                  {
                    echo $_REQUEST['msg'];
                  }
                  ?>
                </h4>
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">School Name</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name" readonly="readonly" value="<?php echo $_SESSION['schooladmin']['schoolname'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <?php 
                    $statesql = $conn->query("SELECT * FROM `state` WHERE stateid=".$_SESSION['schooladmin']['state']);
                    $state = $statesql->fetch_assoc();
                    ?>
                    <label for="inputName" class="col-sm-2 control-label">State</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name" readonly="readonly" value="<?php echo $state['statename'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <?php 
                    $districtsql = $conn->query("SELECT * FROM `district` WHERE districtid=".$_SESSION['schooladmin']['district']);
                    $district = $districtsql->fetch_assoc();
                    ?>
                    <label for="inputEmail" class="col-sm-2 control-label">District</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email" readonly="readonly" value="<?php echo $district['districtname'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Address</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" readonly="readonly" value=""><?php echo $_SESSION['schooladmin']['address'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label" >Pincode</label>

                    <div class="col-sm-10">
                      <input type="text" value="<?php echo $_SESSION['schooladmin']['pincode'] ?>" class="form-control" readonly="readonly" id="inputSkills" placeholder="Skills">
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div> -->
                </form>
              </div>

               <div class="tab-pane" id="timeline">
                <form class="form-horizontal" action="" method="post">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <input type="password" name="password" class="form-control" id="inputName" placeholder="Password">
                      <input type="hidden" name="school" value="<?php echo $_SESSION['schooladmin']['id'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Confirm Password</label>

                    <div class="col-sm-10">
                      <input type="password" name="cpassword" class="form-control" id="inputName" placeholder="Confirm Password">
                     
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <input type="submit" name="submit" class="btn btn-primary" value="submit">
                    </div>
                  </div>
                </form>
              </div>
              
              
              <!-- /.tab-pane -->
             <div class="tab-pane" id="profile">
                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Upload Profile Picture</label>

                    <div class="col-sm-10">
                      <input type="file" name="photo" class="form-control" id="inputName">
                      <input type="hidden" name="oldphoto" value="<?php echo $_SESSION['schooladmin']['schoollogo'] ?>">
                      <input type="hidden" name="school" value="<?php echo $_SESSION['schooladmin']['id'] ?>">
                    </div>
                  </div>
                  <img src="<?php echo BASE_URL ?>assets/uploads/schooladmin/<?php echo $_SESSION['schooladmin']['schoollogo'] ?>" class="profile-user-img img-responsive img-circle" height="50" width="50" />
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <input type="submit" name="update" class="btn btn-primary" value="Update">
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

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
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo BASE_URL ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo BASE_URL ?>assets/dist/js/demo.js"></script>
</body>
</html>
