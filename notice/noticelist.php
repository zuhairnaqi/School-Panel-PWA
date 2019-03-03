<?php
session_start();  
require_once("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}

if(isset($_REQUEST['delete']))
{
  $deleteid=$_REQUEST['delete'];
  $sql="DELETE FROM `notice` WHERE `id`='$deleteid'";
  $ex=$conn->query($sql);
  if($ex)
  {
    $delete="Notice Deleted Successfully";
    header("location:".BASE_URL."admin/notice/noticelist.php?deletemsg=".$delete);
  }
  else
  {
    $error="Notice Not Deleted";
    header("location:".BASE_URL."admin/notice/noticelist.php?error=".$error);
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>List Notice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
        List Notice
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Notice</a></li>
        <li class="active">List Notice</li>
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
              <h3 class="box-title">List Notice</h3>
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
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputEmail1">Class</label>
                  <select class="form-control select2" name="class" id="classid">
                    <option value=" ">Select Class</option>
                    <?php
                    $sql="SELECT * FROM `class` WHERE school=".$_SESSION['schooladmin']['id'];
                    $ex=$conn->query($sql);
                    while($class=$ex->fetch_object())
                    {
                    ?>
                    <option value="<?php echo $class->classid ?>"><?php echo $class->classname ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="Add" value="Search Notice" class="btn btn-primary">
              </div>

            </form>
          </div>
          <?php if(isset($_POST['Add'])) { ?>
            <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List Notice</h3>
              <a href="<?php echo BASE_URL.'admin/notice/noticeadd.php' ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add</a>
              <h3 align="center" style="color: green">
              <?php
              if(isset($_REQUEST['deletemsg']))
              {
                echo $_REQUEST['deletemsg'];
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
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Class</th>
                  <th>Notice Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql="SELECT * FROM `notice` join `class` on notice.class=class.classid WHERE notice.school=".$_SESSION['schooladmin']['id']." AND notice.class=".$_POST['class']." order by notice.id DESC";
                $ex=$conn->query($sql);
                while($section=$ex->fetch_object())
                {
                ?>
                <tr>
                  <td><?php echo $section->classname ?></td>
                  <td><?php echo $section->noticedate ?></td>
                  <td><?php echo $section->description ?></td>
                  <td>

                    <a href="<?php echo BASE_URL ?>admin/notice/view.php?id=<?php echo $section->id ?>" class="btn btn-warning btn-sm"  data-toggle="tooltip" title=""  data-original-title="View Notice">
                    <i class="fa fa-eye"></i>
                    </a>

                    <a href="<?php echo BASE_URL ?>admin/notice/noticelist.php?delete=<?php echo $section->id ?>" class="btn btn-danger btn-sm"  data-toggle="tooltip" title=""  data-original-title="Delete Notice">
                    <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Class</th>
                  <th>Notice Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
         
        <?php } else { ?>
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List Notice</h3>
              <a href="<?php echo BASE_URL.'admin/notice/noticeadd.php' ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add</a>
              <h3 align="center" style="color: green">
              <?php
              if(isset($_REQUEST['deletemsg']))
              {
                echo $_REQUEST['deletemsg'];
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
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="examples1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Class</th>
                  <th>Notice Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql="SELECT * FROM `notice` join `class` on notice.class=class.classid WHERE notice.school=".$_SESSION['schooladmin']['id']." order by notice.id DESC";
                $ex=$conn->query($sql);
                while($section=$ex->fetch_object())
                {
                ?>
                <tr>
                  <td><?php echo $section->classname ?></td>
                  <td><?php echo $section->noticedate ?></td>
                  <td><?php echo $section->description ?></td>
                  <td>

                    <a href="<?php echo BASE_URL ?>admin/notice/view.php?id=<?php echo $section->id ?>" class="btn btn-warning btn-sm"  data-toggle="tooltip" title=""  data-original-title="View Notice">
                    <i class="fa fa-eye"></i>
                    </a>

                    <a href="<?php echo BASE_URL ?>admin/notice/noticelist.php?delete=<?php echo $section->id ?>" class="btn btn-danger btn-sm"  data-toggle="tooltip" title=""  data-original-title="Delete Notice">
                    <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <?php
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Class</th>
                  <th>Notice Date</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        <?php } ?>
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
<script src="<?php echo BASE_URL ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_URL ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
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

<script type="text/javascript">
  $('#classid').change(function(){
    var classid = $(this).val();

    $.ajax({
      url : 'getsection.php',
      type : 'get',
      data : {classid:classid},
      success:function(data){
        $('#sectionid').html(data); 
      }
    })
  })
</script>
<!-- page script -->
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
<script>
  $(function () {
    $('#examples1').DataTable()
    $('#examples2').DataTable({
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
