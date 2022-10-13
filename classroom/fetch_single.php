<?php
require_once('../class.function.php');
$account = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT * FROM `class_room` WHERE class_ID  = '".$_POST["classroom_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{


		$output["class_ID"] = $row["class_ID"];
		$output["class_Code"] = $row["class_Code"];
		$output["class_Name"] = $row["class_Name"];
		$output["class_Description"] = $row["class_Description"];
		$output["class_Password"] = $row["class_Password"];
		$output["class_status"] = $row["status_ID"];

	
	}
	
	echo json_encode($output);
	
}









 

?>