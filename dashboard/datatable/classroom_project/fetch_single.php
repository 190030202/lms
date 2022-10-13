<?php
require_once('../class.function.php');
$account = new DTFunction(); 
session_start();
if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT * FROM `class_room_project` WHERE proj_ID  = '".$_POST["proj_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{
		$stmt1 = $account->runQuery("SELECT * FROM `class_room_project_attachment` WHERE proj_ID  = '".$_POST["proj_ID"]."' AND user_ID = '".$_SESSION["user_ID"]."' 
		LIMIT 1");
		$stmt1->execute();
		$result1 = $stmt1->fetchAll();
		$output["sproj_attch"] = '<ul class="list-group">';
		$attachment_Desc ="";
		foreach($result1 as $row1)
		{
			$attachment_Name = json_decode($row1["attachment_Name"]);
			$attachment_Desc = $row1["attachment_Desc"];

			$dl = 'href="data:'.$row1["attachment_MIME"].';base64,'.base64_encode($row1['attachment_Data']).'"';
			// <li class="list-group-item">'.$attachment_Name[0].'</li>
			$output["sproj_attch"] .= '
										<div class="list-group-item">
										<a  class="float-left" '.$dl.' download="">'.$attachment_Name[0].'</a>  
										<i class="icon-cross float-right  delete_sproj_s " id="'.$row1["attachment_ID"].'" style="font-size: 20px;" ></i>
										</div>
									  ';

		}
		$output["sproj_attch"] .= '</ul>';
		$output["sproj_desc"] = $attachment_Desc;
	
		
		$output["proj_ID"] = $row["proj_ID"];
		$output["proj_Name"] = $row["proj_Name"];
		$output["proj_expired"] = date('Y-m-d\TH:i:s', strtotime($row["proj_Expired"]));
	
	}
	
	echo json_encode($output);
	
}









 

?>
