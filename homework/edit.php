<?php
function cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){

    //folder path setup
    $target_path = $target_folder;
    $thumb_path = $thumb_folder;
    
    //file name setup
    $filename_err = explode(".",$_FILES[$field_name]['name']);
    $filename_err_count = count($filename_err);
    $file_ext = $filename_err[$filename_err_count-1];
    if($file_name != ''){
        $fileName = $file_name.'.'.$file_ext;
    }else{
        $fileName = $_FILES[$field_name]['name'];
    }
    
    //upload image path
    $upload_image = $target_path.basename($fileName);
    
    //upload image
    if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
    {
        //thumbnail creation
        if($thumb == TRUE)
        {
            $thumbnail = $thumb_path.$fileName;
            list($width,$height) = getimagesize($upload_image);
            $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
            switch($file_ext){
                case 'jpg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;
                case 'jpeg':
                    $source = imagecreatefromjpeg($upload_image);
                    break;

                case 'png':
                    $source = imagecreatefrompng($upload_image);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($upload_image);
                    break;
                default:
                    $source = imagecreatefromjpeg($upload_image);
            }

            imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
            switch($file_ext){
                case 'jpg' || 'jpeg':
                    imagejpeg($thumb_create,$thumbnail,100);
                    break;
                case 'png':
                    imagepng($thumb_create,$thumbnail,100);
                    break;

                case 'gif':
                    imagegif($thumb_create,$thumbnail,100);
                    break;
                default:
                    imagejpeg($thumb_create,$thumbnail,100);
            }

        }

        return $fileName;
    }
    else
    {
        return false;
    }
}
session_start();  
require_once("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}
if(isset($_REQUEST['editid']))
{
  $editid=$_REQUEST['editid'];
  $sql="SELECT * FROM `homework` WHERE `homeworkid`='$editid'";
  $ex=$conn->query($sql);
  $homework=$ex->fetch_object();
}
if(isset($_POST['Update']))
{
  if(isset($_SESSION['schooladmin'])) 
  {
  $school=$_SESSION['schooladmin']['id'];
  $homeworktitle = $_POST['homeworktitle'];
  $class=$_POST['class'];
  $document = $_FILES['document']['name'];
  $document_tmp = $_FILES['document']['tmp_name'];
  $homeworkid=$_POST['homeworkid'];
  $olddocument=$_POST['olddocument'];
  $homeworkdate = date('d/m/Y');
  if($_FILES['document']['error'] == 4)
  {
    $sql1="UPDATE `homework` SET `homeworktitle`='$homeworktitle',`class`='$class',`school`='$school',`document`='$olddocument' WHERE `homeworkid`='$homeworkid'";
    $ex1=$conn->query($sql1);
    if($ex1)
    {
    $update="Homework Updated Successfully";
    header("location:".BASE_URL."admin/homework/list.php?update=".$update);
    }
    else
    {
    $error="Homework Not Updated Successfully";
    header("location:".BASE_URL."admin/homework/list.php?error=".$error);
    }
  }
  else
  {
    //move_uploaded_file( $document_tmp, '../../assets/uploads/homework/'.$document);
    $upload_img = cwUpload('document','../../assets/uploads/homework/','',TRUE,'../../assets/uploads/homework/thumb/','300','260');
    //full path of the thumbnail image
  $thumb_src = $upload_img;
  $sql="UPDATE `homework` SET `homeworktitle`='$homeworktitle',`class`='$class',`school`='$school',`document`='$thumb_src',document_thumbnail='$thumb_src' WHERE `homeworkid`='$homeworkid'";
  $ex=$conn->query($sql);
  if($ex)
  {
    $update="Homework Updated Successfully";
    header("location:".BASE_URL."admin/homework/list.php?update=".$update);
  }
  else
  {
    $error="Homework Not Updated Successfully";
    header("location:".BASE_URL."admin/homework/list.php?error=".$error);
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
  <title>Edit Homework</title>
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
        Edit Homework
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Homework</a></li>
        <li class="active">Edit Homework</li>
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
              <h3 class="box-title">Edit Homework</h3>
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
                  <label for="exampleInputFile">Homework Title</label>
                  <input type="text" class="form-control" name="homeworktitle" placeholder="Homework Title" value="<?php echo $homework->homeworktitle ?>">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Class</label>
                  <select class="form-control select2" name="class" id="classid" required> 
                    <option value=" ">Select Class</option>
                    <?php
                    $sql="SELECT * FROM `class` WHERE school=".$_SESSION['schooladmin']['id'];
                    $ex=$conn->query($sql);
                    while($class=$ex->fetch_object())
                    {
                    ?>
                    <option <?php if($homework->class == $class->classid) { echo "Selected"; } ?> value="<?php echo $class->classid ?>"><?php echo $class->classname ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                
                <input type="hidden" name="homeworkid" value="<?php echo $homework->homeworkid; ?>">
                <input type="hidden" name="olddocument" value="<?php echo $homework->document; ?>">
                
               

              </div>
              <div class="col-md-6">
                
                <div class="form-group">
                  <label for="exampleInputFile">Attach Document</label>
                  <input type="file" id="exampleInputFile" class="form-control" name="document">
                </div>
                <img src="<?php echo BASE_URL.'assets/uploads/homework/' ?><?php echo $homework->document; ?>" height="50" width="50">
                

                
              </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="Update" value="Update Homework" class="btn btn-primary">
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

</body>
</html>
