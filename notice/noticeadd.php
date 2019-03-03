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
  if($_POST['class']==' ')
  {
    $err_msg .= 'Class Name is Required';
  }
  else
  {
  if(isset($_SESSION['schooladmin'])) 
  {
  $school=$_SESSION['schooladmin']['id'];
  $description=addslashes($_POST['description']);
  
  $noticedate=date('d/m/Y');
  $class=$_POST['class'];

  $sql="INSERT INTO `notice`(`description`,`noticedate`,`class`,`school`) VALUES ('$description','$noticedate','$class','$school')";
  
  $ex=$conn->query($sql);
   $schoolsql = $conn->query("SELECT * FROM `schooladmin` WHERE id='$school'");
  $schoolex = $schoolsql->fetch_assoc();
  $schools = $schoolex['schoolname'];
  $notice=$conn->insert_id;
    if($ex)
    {
      
      for($a=0;$a<count($_POST['students']);$a++)
      {
        $students = $_POST['students'][$a];
        $sql1="INSERT INTO `noticestudents`(`notice`,`student`) VALUES ('$notice','$students')";
        $ex1=$conn->query($sql1);
      }
      if($ex1){
           $sql11 = "SELECT * FROM `notice` WHERE id='$notice'";
           
      $result1 = $conn->query($sql11);
      $total1 = $result1->num_rows;
          $registration_ids = [];
          $parentids = [];
          $i = 0;
          $j = 0;
      for($b=0;$b<count($_POST['students']);$b++)
      {
    
            
        $studentss = $_POST['students'][$b];
        $stud = "SELECT parent FROM `student` WHERE class='$class' AND studentid='$studentss' GROUP BY parent";
          $studresult = $conn->query($stud);
         
          //print_r($studresult->fetch_assoc());exit;
          while($row = $studresult->fetch_assoc()) {
            $parentids[$i] = $row['parent'];
            $i++;
        }
        foreach ($parentids as $key => $value) {
          $parent = "SELECT deviceId FROM `parent` WHERE parentid='$value'";
          $parentresult = $conn->query($parent);
          while($row1 = $parentresult->fetch_assoc()) {
            $registration_ids[$j] = $row1['deviceId'];
            $j++;
          }
         
        }
        //print_r($registration_ids);die();
   
    
        $data = $result1->fetch_assoc();
        //$registration_ids = json_encode();

       $msg = array('hi');
       $msg['data']['msg'] = "newhomework";
       $msg['data']['message'] = "You have Notice";
       $msg['data']['image'] = $data['document'];
       $msg['data']['channel'] = "newhomework";
        
       $fields = array('registration_ids' => $registration_ids,'data' => $msg);
       //print_r($fields);die();
       $fcmApiKey = 'AAAAW4RzumU:APA91bGFyDHB5S02gl51LeY4EXstcortR9h-lzoUiWU2M__2MKzPUsJTWe3vVFeWJathHusanvIG-_mJOrFkJiGeRUZ2b9F3gylLgY89tkDmkIWH5qVGzTS1YNjGSvCwrPG8mowKdRUQ';//App API Key(This is google cloud messaging api key not web api key)
        $url = 'https://fcm.googleapis.com/fcm/send';//Google URL

        $headers = array(
           'Authorization: key=' . $fcmApiKey,
           'Content-Type: application/json'
       );
       
       print_r($headers);
       $ch = curl_init();
       curl_setopt( $ch,CURLOPT_URL, $url );
       curl_setopt( $ch,CURLOPT_POST, true );
       curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
       curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
       curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
       curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
      
       $result = curl_exec($ch);
        
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        //return $result;
        //echo $result;
        //print_r($result);
        // Close connection
        curl_close($ch);
        
      }
      
      }
      $insert="Notice Added Successfully";
      header("location:".BASE_URL."admin/notice/noticeadd.php?insert=".$insert);
    }
    else
    {
      $error="Notice Not Added Successfully";
      header("location:".BASE_URL."admin/notice/noticeadd.php?error=".$error);
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
  <title>Add Notice</title>
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
        Add Notice
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Notice</a></li>
        <li class="active">Add Notice</li>
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
              <h3 class="box-title">Add Notice</h3>
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
                  <?php if($err_msg): ?><p style="color: red"><?php echo $err_msg; ?></p><?php endif; ?>
                </div>
              </div>

              <div class="col-md-12">
                <label for="exampleInputEmail1">Student List</label>
                <div class="checkbox">
                  <label>
                    <div id="studentsid">
                    </div>
                  </label>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputEmail1">Notice Description</label>
                  <textarea class="form-control" name="description"></textarea>
                </div>
              </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" name="Add" value="Add Notice" class="btn btn-primary">
                <a href="<?php echo BASE_URL ?>admin/notice/noticelist.php" class="btn btn-primary">List Notice</a>
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
    var classid = $('#classid').val();
    $.ajax({
      url : 'getstudent.php',
      type : 'get',
      data : {classid:classid},
      success:function(data){
        $('#studentsid').html(data); 
      }
    })
  })
</script>
</body>
</html>
