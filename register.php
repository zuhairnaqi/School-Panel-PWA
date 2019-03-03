<?php
session_start();
require_once("../config.php");
?>
<?php 
$serror_message = '';
$merror_message = '';
$emerror_message = '';
$aerror_message = '';
$derror_message = '';
$stateerror_message = '';
$perror_message = '';
$ferror_message = '';
$pass_message='';
$cpass_message='';
$querym = $conn->query("SELECT * FROM schooladmin WHERE mobileno=".$_POST['mobileno']);
if(isset($_POST['submit']))
{
  $valid = 1;
  if(empty($_POST['schoolname']))
  {
    $valid = 0;
    $serror_message .= 'School Name can not be empty<br>';
  }

  else if(empty($_POST['mobileno']))
  {
    $valid = 0;
    $merror_message .= 'Mobile Number can not be empty<br>';
  }
  
  else if(empty($_POST['email']))
  {
    $valid = 0;
    $emerror_message .= 'Email can not be empty<br>';
  }

  else if(empty($_POST['address']))
  {
    $valid = 0;
    $aerror_message .= 'School Address can not be empty<br>';
  }

  else if(empty($_POST['district']))
  {
    $valid = 0;
    $derror_message .= 'District can not be empty<br>';
  }

  else if(empty($_POST['state']))
  {
    $valid = 0;
    $stateerror_message .= 'State can not be empty<br>';
  }

  else if(empty($_POST['pincode']))
  {
    $valid = 0;
    $perror_message .= 'Pincode can not be empty<br>';
  }
  else if(empty($_POST['password']))
  {
    $valid = 0;
    $pass_message .= 'Password can not be empty<br>';
  }
  else if(empty($_POST['cpassword']))
  {
    $valid = 0;
    $pass_message .= 'Confirm Password can not be empty<br>';
  }
  else if(empty($_FILES['schoollogo']['name']))
  {
    $path = $_FILES['schoollogo']['name'];
    $path_tmp = $_FILES['schoollogo']['tmp_name'];

    if($path!='') {
        $valid = 0;
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $ferror_message .= 'You must have to upload jpg, jpeg, gif or png file for featured photo<br>';
        }
    } else {
        $valid = 0;
        $ferror_message .= 'You must have to select a photo<br>';
    }
    }
    
    else if($_POST['password']!=$_POST['cpassword']){
        $password_message = "Confirm Password does Not Match";
        header("location:".BASE_URL."admin/register.php?passwordmsg=".$password_message);
    }
    
    else if($querym->num_rows==1)
    {
        $mno = "Mobile Number already Exist";
        header("location:".BASE_URL."admin/register.php?mno=".$mno);
    }

    else
    {

      $schoolname = $_POST['schoolname'];
      $mobileno = $_POST['mobileno'];
      $email = $_POST['email'];
      $address = addslashes($_POST['address']);
      $district = $_POST['district'];
      $state = $_POST['state'];
      $pincode = $_POST['pincode'];
      $pass = $_POST['password'];
      $path = $_FILES['schoollogo']['name'];
    $path_tmp = $_FILES['schoollogo']['tmp_name'];
      move_uploaded_file($path_tmp, '../assets/uploads/schooladmin/'.$path);
      echo $q="INSERT INTO schooladmin(schoolname,mobileno,email,address,district,state,pincode,schoollogo,status,role,type,password) VALUES ('$schoolname','$mobileno','$email','$address','$district','$state','$pincode','$path','Active','Admin','register','$pass')";
    
      $sql = $conn->query($q);
      
      if($sql)
      { 
          $schoolid = $conn->insert_id;
          /*$msg  = "Your School User ID - ".$schoolid." Reg. Mobile No.-".$mobileno." Password -".$password;

        $url = "http://hindit.co.in/API/pushsms.aspx?loginID=T1myideal&password=52700&mobile=".$mobileno."&text=".$msg."&senderid=MISAPP &route_id=2&Unicode=1";

        

        $url = str_replace(" ","%20",$url);
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        //return $data; */
        $usernme = 'myideal';
        $password = '123456';
        $contacts = $mobileno;
        $from = 'MISAPP';
        $sms_text = urlencode("Login - https://goo.gl/o9YuqF \n\n Your School User ID - ".$schoolid." \n Reg. Mobile No.-".$contacts." \n Password -".$pass);

         $api_url = "http://www.ptechsms.co.in/app/smsapi/index.php?username=".$usernme."&password=".$password."&campaign=6681&routeid=100636&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;

        //Submit to server

        $response = file_get_contents( $api_url);
        echo $response;
        $success_message = "Successfully Registered.";
        header("location:".BASE_URL."admin/register.php?insert=".$success_message);
      }
      else
      {
          'not';
      }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>School Admin Registration</title>
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
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .error
    {
      color: red;
    }
  </style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="<?php echo BASE_URL ?>assets/index2.html">Admin Registration</a>
  </div>

  <div class="register-box-body">

      <?php if(isset($_REQUEST['insert'])): ?>
        <h2 align="center" style="color:green"><?php echo $_REQUEST['insert']; ?></h2>
      <?php endif; ?>
      
       <?php if(isset($_REQUEST['passwordmsg'])): ?>
        <h4 align="center" style="color:red"><?php echo $_REQUEST['passwordmsg']; ?></h4>
        <?php endif; ?>
        <?php if(isset($_REQUEST['mno'])): ?>
        <h4 align="center" style="color:red"><?php echo $_REQUEST['mno']; ?></h4>
      <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="School Name" name="schoolname" value="<?php if(isset($_POST['schoolname'])){echo $_POST['schoolname'];} ?>"  >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <?php if($serror_message): ?><p style="color: red"><?php echo $serror_message; ?></p><?php endif; ?>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Enter Mobile Number" id="phonenumber" name="mobileno" value="<?php if(isset($_POST['mobileno'])){echo $_POST['mobileno'];} ?>" >
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
        <?php if($merror_message): ?><p style="color: red"><?php echo $merror_message; ?></p><?php endif; ?>
        <span id="phonenumbererror" class="error"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Enter Email" id="email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" >
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
        <?php if($emerror_message): ?><p style="color: red"><?php echo $emerror_message; ?></p><?php endif; ?>
      </div>
      
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Enter Address" name="address" value="<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>" >
        <span class="glyphicon glyphicon-tags form-control-feedback"></span>
        <?php if($aerror_message): ?><p style="color: red"><?php echo $aerror_message; ?></p><?php endif; ?>
      </div>
      
      <div class="form-group has-feedback">
          <select class="form-control" name="state" id="stateid" >
            <option value="">Select a State</option>
              <?php
              $i=0;
              $sql = $conn->query("SELECT * FROM state ORDER BY stateid ASC"); 
            
              while($row=$sql->fetch_assoc()) { ?>
                  <option value="<?php echo $row['stateid']; ?>"><?php echo $row['statename']; ?></option>
              <?php } ?>
          </select>
        <span class="glyphicon glyphicon-check form-control-feedback"></span>
        <?php if($stateerror_message): ?><p style="color: red"><?php echo $stateerror_message; ?></p><?php endif; ?>
      </div>

      <div class="form-group has-feedback">
        <select class="form-control" name="district" id="districtid">
            <option value="">Select a District</option>
              
        </select>
        <span class="glyphicon glyphicon-check form-control-feedback"></span>
        <?php if($derror_message): ?><p style="color: red"><?php echo $derror_message; ?></p><?php endif; ?>
      </div>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Enter Pin Code" name="pincode" >
        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
        <?php if($perror_message): ?><p style="color: red"><?php echo $perror_message; ?></p><?php endif; ?>
      </div>
      
      <div class="form-group">
          <label>Upload School Logo</label>
        <input type="file" class="form-control" name="schoollogo" >
        <?php if($ferror_message): ?><p style="color: red"><?php echo $ferror_message; ?></p><?php endif; ?>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Enter Password">
        <?php if($pass_message): ?><p style="color: red"><?php echo $pass_message; ?></p><?php endif; ?>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="cpassword" placeholder="Enter Confirm Password">
        <?php if($cpass_message): ?><p style="color: red"><?php echo $cpass_message; ?></p><?php endif; ?>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" required="required"> I agree to the <a href="terms.php">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    Already Registered ?<a href="<?php echo BASE_URL ?>admin/login.php" class="text-center">Click Here</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo BASE_URL ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo BASE_URL ?>assets/plugins/iCheck/icheck.min.js"></script>
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
  jQuery(document).ready(function($){
    $cf = $('#phonenumber');
    $cf.blur(function(e){
        phone = $(this).val();
        phone = phone.replace(/[^0-9]/g,'');
        if (phone.length != 10)
        {
           $('#phonenumbererror').html('Phone number must be 10 digits.'); 
           
        }
    });
});
</script>
<script type="text/javascript">
  $('#stateid').change(function(){
    var stateid = $(this).val();
    //alert(stateid);
    $.ajax({
      url : 'getdistrict.php',
      type : 'get',
      data : {stateid:stateid},
      success:function(data){
          //alert(data);
        $('#districtid').html(data); 
      }
    })
  })
</script>
</body>
</html>
