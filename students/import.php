<?php
session_start();  
include("../../config.php");

?>
<?php
require_once('../../vendor/php-excel-reader/excel_reader2.php');
require_once('../../vendor/SpreadsheetReader.php');

if (isset($_POST["import"]))
{
  $class = $_POST['classes'];
  
  $school = $_SESSION['schooladmin']['id'];

  $joindate = date('d/m/Y h:i');
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = '../../assets/uploads/excel/students/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $studentname = "";
                if(isset($Row[0])) {
                   $studentname = mysqli_real_escape_string($conn,$Row[0]);
                }
                
                $fathername = "";
                if(isset($Row[1])) {
                     $fathername = mysqli_real_escape_string($conn,$Row[1]);
                }


                $mothername = "";
                if(isset($Row[2])) {
                    $mothername = mysqli_real_escape_string($conn,$Row[2]);
                }

                $roleno = "";
                if(isset($Row[3])) {
                    $roleno = mysqli_real_escape_string($conn,$Row[3]);
                }

                $address = "";
                if(isset($Row[4])) {
                    $address = mysqli_real_escape_string($conn,$Row[4]);
                }

                $mno = "";
                if(isset($Row[5])) {
                    $mno = mysqli_real_escape_string($conn,$Row[5]);
                }

                $dob = "";
                if(isset($Row[6])) {
                    $dob = mysqli_real_escape_string($conn,$Row[6]);
                }

                $bloodgroup = "";
                if(isset($Row[7])) {
                     $bloodgroup = mysqli_real_escape_string($conn,$Row[7]);
                }

                $photo = "";
                if(isset($Row[8])) {
                    $photo = mysqli_real_escape_string($conn,$Row[8]);
                }

                $district = "";
                if(isset($Row[9])) {
                     $district = mysqli_real_escape_string($conn,$Row[9]);
                }

                $state = "";
                if(isset($Row[10])) {
                     $state = mysqli_real_escape_string($conn,$Row[10]);
                }

                $pincode = "";
                if(isset($Row[11])) {
                    $pincode = mysqli_real_escape_string($conn,$Row[11]);
                }
                if (!empty($studentname)) {
                   
                    $query = "INSERT INTO `student`(`studentname`,`fathername`,`mothername`,`class`,`roleno`,`address`,`mno`,`dob`,`bloodgroup`,`photo`,`parent`,`status`,`addby`,`school`,`district`,`state`,`pincode`,`joindate`,`thumbimg`) VALUES ('$studentname','$fathername','$mothername','$class','$roleno','$address','$mno','$dob','$bloodgroup','$photo','','Active','School',$school,'$district','$state','$pincode','$joindate','')";

                    $result = mysqli_query($conn, $query);
                  
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
             }
        
         }

  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Import Student</title>
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
        Import Student
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Student</a></li>
        <li class="active">Import Student</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="col-md-12">
                <h4 align="center" style="color: green;"><?php if(!empty($message)) { echo $message; } ?></h4>
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
                    <option <?php if(isset($_POST['Add'])) {if($class->classid == $_POST['class']) { echo "Selected"; } } ?> value="<?php echo $class->classid ?>"><?php echo $class->classname ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div> 
              </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="Add" value="Import" class="btn btn-primary">
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <?php if(isset($_POST['Add'])) { ?>
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">

          <!-- general form elements -->
          
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Import Student</h3>
              <a href="<?php echo BASE_URL ?>students.csv" class="btn btn-sm btn-primary pull-right"> Download Sample File</a>
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
            <form role="form" method="post" enctype="multipart/form-data">
              
              <h4 align="center" style="color: green;"><?php if(!empty($message)) { echo $message; } ?></h4>
              <input type="hidden" name="classes" value="<?php echo $_POST['class'] ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Select File to Import</label>
                  <input type="file" class="form-control" name="file">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="import" id="addclass" class="btn btn-primary">Import Student</button>
                <a href="<?php echo BASE_URL ?>admin/students/list.php" class="btn btn-primary">List Student</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
    <?php } ?>
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
