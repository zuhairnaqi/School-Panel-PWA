<?php
session_start();  
include("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}

if(isset($_REQUEST['active']))
{
  $id=$_REQUEST['active'];
  $sql="UPDATE `student` SET status='Active' WHERE `studentid`='$id'";
  $ex=$conn->query($sql);
  if($ex)
  {
    $delete="Student Activated Successfully";
    header("location:".BASE_URL."admin/students/list.php?update=".$delete);
  }
  else
  {
    $error="Not Activated";
    header("location:".BASE_URL."admin/students/list.php?error=".$error);
  }
}

if(isset($_REQUEST['inactive']))
{
  $id=$_REQUEST['inactive'];
  $sql="UPDATE `student` SET status='Inactive' WHERE `studentid`='$id'";
  $ex=$conn->query($sql);
  if($ex)
  {
    $delete="Student Inactivated Successfully";
    header("location:".BASE_URL."admin/students/list.php?update=".$delete);
  }
  else
  {
    $error="Not Inactivated";
    header("location:".BASE_URL."admin/students/list.php?error=".$error);
  }
}
if(isset($_REQUEST['delete']))
{
  for($i=0;$i<count($_POST['del']);$i++)
  {
    $dsql="DELETE FROM `student` WHERE `studentid`=".$_POST['del'][$i];
    $dex=$conn->query($dsql);
  }
  if($dex)
  {
    $delete="Student Deleted Successfully";
    header("location:".BASE_URL."admin/students/list.php?deletemsg=".$delete);
  }
  else
  {
    $error="Not Deleted";
    header("location:".BASE_URL."admin/students/list.php?deletemsg=".$error);
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>List Student</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/plugins/iCheck/square/blue.css">
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
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
        List Student
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Student</a></li>
        <li class="active">List Student</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Student</h3>
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
              if(isset($_REQUEST['deletemsg']))
              {
                echo $_REQUEST['deletemsg'];
              }
              ?>
              <?php
              if(isset($_REQUEST['error']))
              {
                echo $_REQUEST['error'];
              }
              ?>
            </h3>
            <!-- /.box-header -->
            <form action="" method="post" enctype="multipart/form-data">
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Delete</th>
                  <th>Sr. No</th>
                  <th>Roll No</th>
                  <th>Student Image</th>
                  <th>Student Name</th>
                  <th>Class Name</th>
                  <th>Mobile Number</th>
                  <th>Father Name</th>
                  <th>Mother Name</th>
                  <th>DOB</th>
                  <th>Blood Group</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql="SELECT * FROM `student` join `class` on `student`.class=class.classid WHERE student.school=".$_SESSION['schooladmin']['id'];
                $ex=$conn->query($sql);
                $i=1;
                while($student=$ex->fetch_object())
                {
                ?>
                <tr>
                    <td>
                    <div class="checkbox icheck">
                    <label>
                      <input type="checkbox" value="<?php echo $student->studentid ?>" name="del[]">
                    </label>
                  </div>
                  </td>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $student->roleno ?></td>
                  <td><img src="<?php echo BASE_URL ?>assets/uploads/student/<?php echo $student->photo ?>" class="img-circle" alt="User Image" height="50" width="50"></td>
                  <td><?php echo $student->studentname ?></td>
                  <td><?php echo $student->classname ?></td>
                  <td><?php echo $student->mno ?></td>
                  <td><?php echo $student->fathername ?></td>
                  <td><?php echo $student->mothername ?></td>
                  <td><?php echo $student->dob ?></td>
                  <td><?php echo $student->bloodgroup ?></td>
                  <td><?php echo $student->status ?></td>
                  <td width="15%">

                    <a href="<?php echo BASE_URL ?>admin/students/edit.php?editid=<?php echo $student->studentid ?>" class="btn btn-primary btn-sm"  data-toggle="tooltip" title=""  data-original-title="Edit Student"><i class="fa fa-edit"></i></a>
                    
                    <a href="<?php echo BASE_URL ?>admin/students/view.php?view=<?php echo $student->studentid ?>" class="btn btn-warning btn-sm"  data-toggle="tooltip" title=""  data-original-title="View Student"><i class="fa fa-eye"></i></a>

                    <a href="<?php echo BASE_URL ?>admin/students/list.php?active=<?php echo $student->studentid ?>" class="btn btn-success btn-sm"  data-toggle="tooltip" title=""  data-original-title="Active Student">
                    Active
                    </a>

                    <a href="<?php echo BASE_URL ?>admin/students/list.php?inactive=<?php echo $student->studentid ?>" class="btn btn-danger btn-sm"  data-toggle="tooltip" title=""  data-original-title="Inactive Student">
                    Inactive
                    </a>

                  </td>
                </tr>
                <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Delete</th>
                  <th>Sr. No</th>
                  <th>Roll No</th>
                  <th>Student Image</th>
                  <th>Student Name</th>
                  <th>Class Name</th>
                  <th>Mobile Number</th>
                  <th>Father Name</th>
                  <th>Mother Name</th>
                  <th>DOB</th>
                  <th>Blood Group</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <button type="submit" name="delete" class="btn btn-danger pull-right">Delete Students</button>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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
<!-- DataTables -->
<script src="<?php echo BASE_URL ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_URL ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo BASE_URL ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo BASE_URL ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo BASE_URL ?>assets/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
