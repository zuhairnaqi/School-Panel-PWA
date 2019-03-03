<?php
session_start();
require_once("../config.php");
$error_msg = '';
if(isset($_SESSION['schooladmin'])) {
  header('location: '.BASE_URL.'admin/index.php');
  exit;
}
if(isset($_POST['submit']))
{
  if(empty($_POST['username']) || empty($_POST['mobileno']) || empty($_POST['password'])) {
        $error_msg = 'School User ID and/or Mobile Number or Password can not be empty<br>';
    } else {
      $username = $_POST['username'];
      $mobileno = $_POST['mobileno'];
      $password = $_POST['password'];
      $sql = "SELECT * FROM `schooladmin` WHERE id='$username'";
      $result = $conn->query($sql);
     $total = $result->num_rows;
      
        if($total==0) {
            $error_msg .= '<div class="error">Username does not match</div>';
        } else {      

            while($row=$result->fetch_assoc()) { 
                $status = $row['status'];
                $type = $row['type'];
                $row_mobileno = $row['mobileno'];
                $row_password = $row['password'];
          if($type=='register')
          {
            if( $row_mobileno != $mobileno ) {
                $error_msg .= '<div class="error">Mobile Number does not match</div>';
            } 
            elseif( $row_password != $password ) {
                $error_msg .= '<div class="error">Password does not match</div>';
            } 
            elseif($status == 'Pending') {
                $error_msg .= '<div class="error">Your Account is Pending</div>';
            } 
            elseif($status!= 'Active') {
                $error_msg .= '<div class="error">Your Account is Not Active</div>';
            }
           
            else {       
                $_SESSION['schooladmin'] = $row;
                header("location: index.php");
            }
          }
          else
          {
            if($row_mobileno != $mobileno) {
                $error_msg .= '<div class="error">Mobile Number does not match</div>';
            }
            elseif( $row_password != $password ) {
                $error_msg .= '<div class="error">Password does not match</div>';
            } 
            elseif($status!= 'Active') {
                $error_msg .= '<div class="error">Your Account is Not Active</div>';
            } else {
                $_SESSION['schooladmin'] = $row;
                header("location: ".BASE_URL."admin/index.php");
            }
          }

          }
        }

    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <style type="text/css">
    .error
    {
      color: red;
      font-size: 18px;
      text-align: center;
    }
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>School Admin | Sign in</title>
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
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<center><img src="<?php echo BASE_URL ?>Logo.png" height="150" width="350"></center>
  <div class="login-logo">

  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
       <h4 align="center"><b> School  Admin</b></h4>
    <p class="login-box-msg">Sign in to start your session</p>

    <?php 
      if((isset($error_msg)) && ($error_msg!='')):
          echo '<div class="error">'.$error_msg.'</div>';
      endif;
      ?>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="School ID" name="username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Mobile No." name="mobileno">
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8"></div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  <a href="<?php echo BASE_URL ?>admin/register.php" class="text-center">Register New School</a>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

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
</body>
</html>
