<?php
require_once('../../config.php');
$classid = $_GET['classid'];
$sql = $conn->query("SELECT * FROM `student` WHERE class=".$classid);

?><?php while($student=$sql->fetch_object()) { ?> <input type="checkbox" name="students[]" value="<?php echo $student->studentid ?>"><?php echo $student->studentname ?><br> <?php }
?>
