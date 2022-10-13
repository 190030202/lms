<?php
require_once('../class.function.php');
$account = new DTFunction(); 
session_start();
if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $account->runQuery("SELECT * FROM `class_room_assignment` WHERE ca_ID  = '".$_POST["ca_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $row)
	{
		$stmt1 = $account->runQuery("SELECT * FROM `class_room_assignment_attachment` WHERE ca_ID  = '".$_POST["ca_ID"]."' AND user_ID = '".$_SESSION["user_ID"]."' 
		LIMIT 1");
		$stmt1->execute();
		$result1 = $stmt1->fetchAll();
		$output["sassg_attch"] = '<ul class="list-group">';
		$attachment_Desc ="";
		foreach($result1 as $row1)
		{
			$attachment_Name = json_decode($row1["attachment_Name"]);
			$attachment_Desc = $row1["attachment_Desc"];

			$dl = 'href="data:'.$row1["attachment_MIME"].';base64,'.base64_encode($row1['attachment_Data']).'"';
			// <li class="list-group-item">'.$attachment_Name[0].'</li>
			$output["sassg_attch"] .= '
										<div class="list-group-item">
										<a  class="float-left" '.$dl.' download="">'.$attachment_Name[0].'</a>  
										<i class="icon-cross float-right  delete_sassigment_s " id="'.$row1["attachment_ID"].'" style="font-size: 20px;" ></i>
										</div>
									  ';

		}
		$output["sassg_attch"] .= '</ul>';
		$output["sassg_desc"] = $attachment_Desc;
	
		
		$output["assg_ID"] = $row["ca_ID"];
		$output["assg_Name"] = $row["ca_Name"];
		$output["assg_Desc"] = $row["ca_Desc"];

		$output["assg_expired"] = date('Y-m-d\TH:i:s', strtotime($row["ca_Expired"]));
	
	}
	
	echo json_encode($output);
	
}









 

?>
