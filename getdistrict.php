<?php
require_once('../config.php');
$classid = $_GET['stateid'];
$sql = $conn->query("SELECT * FROM `district` WHERE state=".$classid);

while($class=$sql->fetch_object()) { ?> <option value="<?php echo $class->districtid ?>"><?php echo $class->districtname ?></option> <?php }
?>
