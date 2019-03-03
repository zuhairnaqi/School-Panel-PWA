<?php
session_start();  
require_once("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}

$err_msg = '';
$err_msg1 = '';
if(isset($_POST['Add']))
{
  if($_POST['class']==' ' and $_POST['section']==' ')
  {
    $err_msg .= 'Class Name is Required';
    $err_msg1 .= 'Section Name is Required';
  }
  else
  {
  if(isset($_SESSION['schooladmin'])) 
  {
  $school=$_SESSION['schooladmin']['id'];
  $homeworktitle = $_POST['homeworktitle'];
  $section=$_POST['section'];
  $class=$_POST['class'];
  $homeworkdate = date('d/m/Y');
  $document = $_FILES['document']['name'];
  $document_tmp = $_FILES['document']['tmp_name'];
 
  move_uploaded_file( $document_tmp, '../../assets/uploads/homework/'.$document);
  $sql="INSERT INTO `homework`(`homeworktitle`,`class`,`section`,`school`,`homeworkdate`,`document`,`status`) VALUES ('$homeworktitle','$class','$section','$school','$homeworkdate','$document','')";
  $ex=$conn->query($sql);
  if($ex)
  {
    $last_id = $conn->insert_id;
     
      $sql1 = "SELECT * FROM `homework` WHERE homeworkid='$last_id'";
      $result1 = $conn->query($sql1);
      echo $total1 = $result1->num_rows;
        die();
          $registration_ids = [];
      if($total1){
          $stud = "SELECT parent FROM `student` WHERE class='$class' AND section='$section' GROUP BY parent";
          $studresult = $conn->query($stud);
          $parentids = [];
          $i = 0;
          $j = 0;
          //print_r($studresult->fetch_assoc());exit;
          while($row = $studresult->fetch_assoc()) {
            $parentids[$i] = $row['parent'];
            $i++;
        }
    $insert="Homework Added Successfully";
    header("location:".BASE_URL."admin/addhomework/add.php?insert=".$insert);
  }
  }
  else
  {
    $error="Homework Not Added Successfully";
    header("location:".BASE_URL."admin/addhomework/add.php?error=".$error);
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
  <title>Add Homework</title>
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
        Add Homework
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Homework</a></li>
        <li class="active">Add Homework</li>
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
              <h3 class="box-title">Add Homework</h3>
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
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="exampleInputFile">Upload By</label>
                  <input type="text" class="form-control" name="homeworktitle" placeholder="Enter Name" required>
                </div>
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
                  <?php if($err_msg): ?><p style="color: red"><?php echo $err_msg; ?></p><?php endif; ?>
                </div>

                
              </div>
              <div class="col-md-6">

                <div class="form-group">
                  <label for="exampleInputFile">Attach Homework</label>
                  <input type="file" id="exampleInputFile" class="form-control" name="document" required>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Section</label>
                  <select class="form-control select2" name="section" id="sectionid">
                    <option value=" ">Select Section</option>
                    
                  </select>
                  <?php if($err_msg1): ?><p style="color: red"><?php echo $err_msg1; ?></p><?php endif; ?>
                </div>
              </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="Add" value="Add Homework" class="btn btn-primary">
                <a href="<?php echo BASE_URL ?>admin/homework/list.php" class="btn btn-primary">List Homework</a>
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
</body>
</html>
