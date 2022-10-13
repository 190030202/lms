<?php
require_once('../class.function.php');
$room = new DTFunction(); 
session_start();
if(isset($_POST["q_operation"]))
{


	if($_POST["q_operation"] == "QandA_add")
	{
		
		function chk_ic($a,$b){
			if($a === $b){
				$c = 1;
			}
			else{
				$c = 0;
			}
			return $c;
		}

			$xtest_ID = $_POST["xtest_ID"];
			$q_question = $_POST["q_question"];
			$q_choice_a = $_POST["q_choice_a"];
			$q_choice_b = $_POST["q_choice_b"];
			$q_choice_c = $_POST["q_choice_c"];
			$q_choice_d = $_POST["q_choice_d"];
			$q_is_correct = $_POST["q_is_correct"];

			$question_ID = $room->insert_question($q_question,$xtest_ID);
			$room->insert_choice($question_ID,chk_ic($q_is_correct,"A"),$q_choice_a);
			$room->insert_choice($question_ID,chk_ic($q_is_correct,"B"),$q_choice_b);
			$room->insert_choice($question_ID,chk_ic($q_is_correct,"C"),$q_choice_c);
			$room->insert_choice($question_ID,chk_ic($q_is_correct,"D"),$q_choice_d);
  			echo 'Successfully Added';
	
		
	
	}
	if($_POST["q_operation"] == "QandA_edit")
	{

		$cl = array("A","B","C","D");
		$q_choice = array();
		$clz = array();

		$q_question = $_POST["q_question"];
		$q_choice["A"] = ucwords(strtolower(addslashes($_POST["q_choice_a"])));
		$q_choice["B"] = ucwords(strtolower(addslashes($_POST["q_choice_b"])));
		$q_choice["C"] = ucwords(strtolower(addslashes($_POST["q_choice_c"])));
		$q_choice["D"] = ucwords(strtolower(addslashes($_POST["q_choice_d"])));
		$q_is_correct = $_POST["q_is_correct"];
		$xtest_ID = $_POST["xtest_ID"];
		$question_ID = $_POST["question_ID"];


		/**
		SET ALL CHOICE TO GET ALL ID;
		**/
		$x = 0;
		$stmt = $room->runQuery("SELECT * FROM `class_room_test_choices` WHERE question_ID =".$question_ID."");
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{

			$clz[$cl[$x]] =  $row["choice_ID"];
			
			// $choice_ID = $row["choice_ID"];
			$x++;
		
		}
		/**
		SET ALL CHOICE TO 0;
		**/
		
		$stmt1 = $room->runQuery("UPDATE `class_room_test_choices` 
				SET `is_correct` = '0' 
				WHERE question_ID =".$question_ID.";");
		$stmt1->execute();
		/**
		GET CHOICE ID TO BE UPDATED AS CORRECT
		**/
		
		foreach ($cl as $row1)
		{
			if($row1 == $q_is_correct){
				$new_is_correct = $clz[$row1];
			}
			$room->setnewChoice($clz[$row1],$q_choice[$row1]);
		
		}

		$stmt2 = $room->runQuery("UPDATE `class_room_test_choices` SET `is_correct` = '1' WHERE `choice_ID` = ".$new_is_correct.";");

		$stmt2->execute();
		echo 'Successfully Edit';
	}
	if($_POST["q_operation"] == "QandA_delete")
	{
		$question_ID = $_POST["question_ID"];

			
		$stmt1 = $room->runQuery("DELETE FROM `class_room_test_choices` WHERE `question_ID` = ".$question_ID."");
		$stmt2 = $room->runQuery("DELETE FROM `class_room_test_questions` WHERE `question_ID` = ".$question_ID."");

		$stmt1->execute();
		$stmt2->execute();
		echo "Successfully Deleted";
	}
	if($_POST["q_operation"] == "QandA_answer")
	{

		$output = array();
		$qcount = $_POST["qcount"];
		$user_ID = $_SESSION['user_ID'];
		$test_ID = $_POST['q_testID'];

		$score = 0;
		for ($i = 1; $i <= $qcount; $i++){
			
			$score += $room->check_choice($_POST["q_coption".$i]);
			
		}
		
		$output["score_ID"] = $room->test_score($score,$user_ID,$test_ID);
		$output["msg"] = "submit complete";

		echo json_encode($output);

		unset($_SESSION["timmer".$test_ID]);
		

	}
	if($_POST["q_operation"] == "retake")
	{
		$score_user_ID = $_POST["score_user_ID"];
		$test_ID = $_POST["test_ID"];
		$atmp_ID = $_POST["atmp_ID"];
		$retake_count = $_POST["retake_count"];
		$new_count = --$retake_count;
		$stmt1 = $room->runQuery("UPDATE `class_room_test_attemp` SET `count` = '".$new_count."' WHERE `atmp_ID` = ".$atmp_ID."");
		$stmt1->execute();
		
		// unset($_SESSION["timmer".$test_ID]);
		// echo $test_ID
		
	}

	
	

	




	
}
?>

