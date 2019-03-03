<?php
require_once('../../config.php');
$classid = $_GET['classid'];

for($i=0;$i<count($classid);$i++)
{
	$sql = $conn->query("SELECT * FROM `section` join `class` on section.class=class.classid WHERE class=".$classid[$i]);
	while($class=$sql->fetch_object()) { ?> <option value="<?php echo $class->sectionid ?>"><?php echo $class->classname ?> - <?php echo $class->sectionname ?></option> <?php }
}