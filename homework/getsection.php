<?php
require_once('../../config.php');
$classid = $_GET['classid'];
$sql = $conn->query("SELECT * FROM `section` WHERE class=".$classid);

?><option value="0">Select Section</option><?php while($class=$sql->fetch_object()) { ?> <option value="<?php echo $class->sectionid ?>"><?php echo $class->sectionname ?></option> <?php }
?>
