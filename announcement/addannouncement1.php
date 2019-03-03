<?php
session_start();  
include("../../config.php");
if(!isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/login.php');
  exit;
}

if(isset($_POST['Add']))
{
  $announcementtitle=$_POST['announcementtitle'];
  $announcementdesc = $_POST['description'];
  $announcementdate = date('d/m/Y');
  $school = $_SESSION['schooladmin']['id'];
  $type = $_POST['type'];

  if($type=='all')
  {
    $sql="INSERT INTO `schoolannouncements`(`announcementtitle`,`description`,`announcementdate`,`school`,`type`) VALUES ('$announcementtitle','$announcementdesc','$announcementdate','$school','$type')";
    $ex=$conn->query($sql);
    $announcement = $conn->insert_id;
    
    if($ex)
    {
         $sql1 = "INSERT INTO `announcementsclass`(`class`,`schoolannouncements`) VALUES ('0','$announcement')";
        $ex1 = $conn->query($sql1);
        $sql2 = "INSERT INTO `announcementssection`(`section`,`schoolannouncements`) VALUES ('0','$announcement')";
        $ex2 = $conn->query($sql2);
        
      $insert="Add Successfully";
      header("location:".BASE_URL."admin/announcement/addannouncement.php?insert=".$insert);
    }
    else
    {
      $error="Not Added Successfully";
      header("location:".BASE_URL."admin/announcement/addannouncement.php?insert=".$error);
    }
  }
  else
  {
    $sql="INSERT INTO `schoolannouncements`(`announcementtitle`,`description`,`announcementdate`,`school`,`type`) VALUES ('$announcementtitle','$announcementdesc','$announcementdate','$school','$type')";
    $ex=$conn->query($sql);
    $announcement = $conn->insert_id;
    $registration_ids = [];
    if($ex)
    {
      for($i=0;$i<count($_POST['class']);$i++)
      {
        $class = $_POST['class'][$i];
        $sql1 = "INSERT INTO `announcementsclass`(`class`,`schoolannouncements`) VALUES ('$class','$announcement')";
        $ex1 = $conn->query($sql1);
      }

      for($i=0;$i<count($_POST['section']);$i++)
      {
        $section = $_POST['section'][$i];
        $sql2 = "INSERT INTO `announcementssection`(`section`,`schoolannouncements`) VALUES ('$section','$announcement')";
        $ex2 = $conn->query($sql2);
      }
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
        foreach ($parentids as $key => $value) {
          $parent = "SELECT deviceId FROM `parent` WHERE parentid='$value'";
          $parentresult = $conn->query($parent);
          while($row1 = $parentresult->fetch_assoc()) {
            $registration_ids[$j] = $row1['deviceId'];
            $j++;
          }
         
        }
   
    
        $data = $result1->fetch_assoc();
        //$registration_ids = json_encode();

       $msg = array('hi');
       $msg['data']['title'] = "newhomework";
       $msg['data']['message'] = "Today's Homework";
       $msg['data']['channel'] = "newhomework";
        
       $fields = array('registration_ids' => $registration_ids,'data' => $msg);
       
       $fcmApiKey = 'AAAAW4RzumU:APA91bGFyDHB5S02gl51LeY4EXstcortR9h-lzoUiWU2M__2MKzPUsJTWe3vVFeWJathHusanvIG-_mJOrFkJiGeRUZ2b9F3gylLgY89tkDmkIWH5qVGzTS1YNjGSvCwrPG8mowKdRUQ';//App API Key(This is google cloud messaging api key not web api key)
        $url = 'https://fcm.googleapis.com/fcm/send';//Google URL

        $headers = array(
           'Authorization: key=' . $fcmApiKey,
           'Content-Type: application/json'
       );
       
       $ch = curl_init();
       curl_setopt( $ch,CURLOPT_URL, $url );
       curl_setopt( $ch,CURLOPT_POST, true );
       curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
       curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
       curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
       curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
      
       $result = curl_exec($ch);
       print_r($result);
        echo $result;die();
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
      $insert="Add Successfully";
      header("location:".BASE_URL."admin/announcement/addannouncement.php?insert=".$insert);
    }
    else
    {
      $error="Not Added Successfully";
      header("location:".BASE_URL."admin/announcement/addannouncement.php?insert=".$error);
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Add Announcement</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/select2/dist/css/select2.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

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
        Add Announcement
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Announcement</a></li>
        <li class="active">Add Announcement</li>
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
              <h3 class="box-title">Add Announcement</h3>
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
                <label for="exampleInputEmail1">Announcement Type</label>
                <div class="form-group">

                  <div class="radio">
                    <label>
                      <input type="radio" class="all" name="type" id="type" value="all" >
                      All
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input class="classsection" type="radio" name="type" id="types" value="classsection" checked="checked">
                      Class / Section
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Announcement By</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" name="announcementtitle" required="required">
                </div>

                <div class="form-group" id="class">
                  <label for="exampleInputEmail1">Class</label>
                  <select class="form-control select2" multiple="multiple" name="class[]" id="classid" data-placeholder="Select a Class"> 
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

                <div class="form-group" id="section">
                  <label for="exampleInputEmail1">Section</label>
                  <select class="form-control select2" data-placeholder="Select a Section" multiple="multiple" id="sectionid" name="section[]">
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Announcement Description</label>
                  <textarea class="form-control" name="description" placeholder="Enter Description" required="required"></textarea>                
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <input type="submit" name="Add" value="Add" class="btn btn-primary">
                <a href="<?php echo BASE_URL ?>admin/announcement/announcementlist.php" class="btn btn-primary">List</a>
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
<!-- Select2 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo BASE_URL ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo BASE_URL ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo BASE_URL ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo BASE_URL ?>assets/dist/js/demo.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
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

<script type="text/javascript">
     $('.all').click(function(){
      $('#class').hide();
      $('#section').hide();
     })

     $('.classsection').click(function(){
      $('#class').show();
      $('#section').show();
     })
</script>
</body>
</html>
