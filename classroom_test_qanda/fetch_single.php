<?php
require_once('../class.function.php');
$room = new DTFunction(); 

if (isset($_POST['action'])) {
	
	$output = array();
	$stmt = $room->runQuery("SELECT 
crtq.*,
(SELECT GROUP_CONCAT(crtc.choice_ID)  FROM `class_room_test_choices` `crtc` WHERE crtc.question_ID = crtq.question_ID) choice_ID,
(SELECT GROUP_CONCAT(crtc.is_correct)  FROM `class_room_test_choices` `crtc` WHERE crtc.question_ID = crtq.question_ID) is_correct,
(SELECT GROUP_CONCAT(crtc.choice)  FROM `class_room_test_choices` `crtc` WHERE crtc.question_ID = crtq.question_ID) choice 
FROM `class_room_test_questions` `crtq`
WHERE crtq.question_ID =   '".$_POST["question_ID"]."' 
			LIMIT 1");
	$stmt->execute();
	$result = $stmt->fetchAll();


	$a = 1;
	foreach($result as $row)
	{

	
		$break_c = explode(",",$row["choice"]);
		$break_d = explode(",",$row["is_correct"]);

		
		$output["question_ID"] = $row["question_ID"];
		$output["q_question"] = $row["question"];
		$output["q_choice_a"] = $break_c[0];
		$output["q_choice_b"] = $break_c[1];
		$output["q_choice_c"] = $break_c[2];
		$output["q_choice_d"] = $break_c[3];
		$break_d[0] == 1 ? $xic = "A" :"";
		$break_d[1] == 1 ? $xic = "B" :"";
		$break_d[2] == 1 ? $xic = "C" :"";
		$break_d[3] == 1 ? $xic = "D" :"";
		
		
		
		$output["q_is_correct"] = $xic;

		$a++;
	
	}
	
	echo json_encode($output);
	
}









 

?>