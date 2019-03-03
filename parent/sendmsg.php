<?php 
include('../../config.php');
$id = $_REQUEST['parent'];
$sql = $conn->query("SELECT * FROM `parent` WHERE parentid=".$id);
if($sql->num_rows)
{
		$result = mysqli_fetch_assoc($sql);
	
		$mno = $result['mobileno'];
		$school = $result['school'];
		
		$sqls = $conn->query("SELECT * FROM `schooladmin` WHERE id=".$school);
      $exs = $sqls->fetch_assoc();
      $schoolsname = $exs['schoolname'];

       $usernme = 'myideal';
          $password = '123456';
          $from = 'MISAPP';
          $sms_text = urlencode("Download $schoolsname Mobile App https://play.google.com/store/apps/details?id=school.myideal.intel.myidealschool \n \n Sign in and add Student \n School ID- $school \n  Mobile No.-$mno \n Password -$mno \n \n Read User Guide - www.myidealschoolapp.com/parentapp.pdf");

           $api_url = "http://www.ptechsms.co.in/app/smsapi/index.php?username=".$usernme."&password=".$password."&campaign=6681&routeid=100636&type=text&contacts=".$mno."&senderid=".$from."&msg=".$sms_text;

           $response = file_get_contents($api_url);
           echo $response; 
	
        $success_message = "SMS Sent Successfully";
        header("location:".BASE_URL."admin/parent/list.php?update=".$success_message);
       
	
}
else
{
	$error_message = "Not Activated Successfully";
    header("location:".BASE_URL."admin/parent/list.php?update=".$error_message);
}
?>