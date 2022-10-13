<?php
require_once('../class.function.php');
$account = new DTFunction(); 
session_start();
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "test_submit")
	{	
		try
		{
			

			$class_ID = $_POST["class_ID"];
			$section_ID = $_POST["section_ID"];
			$test_name = $_POST["test_name"];
			$test_expired = $_POST["test_expired"];
			$test_timer = $_POST["test_timer"];
			$test_type = $_POST["test_type"];
			$test_status = $_POST["test_status"];
		
		
			
			$sql = "INSERT INTO `class_room_test` (`test_ID`, `class_ID`, `test_Name`, `test_Added`, `test_Expired`, `test_Timer`, `status_ID`, `tstt_ID`,`section_ID`) 
			VALUES (
			NULL,
			 :class_ID,
			  :test_name,
			   CURRENT_TIMESTAMP,
			    :test_expired,
			     :test_timer,
			      :test_status,
			       :test_type,
			       :section_ID);";
			$statement = $account->runQuery($sql);
				
			$result = $statement->execute(
			array(

					':class_ID'		=>	$class_ID ,
					':test_name'		=>	$test_name ,
					':test_expired'		=>	$test_expired ,
					':test_timer'		=>	$test_timer ,
					':test_status'		=>	$test_status ,
					':test_type'		=>	$test_type ,
					':section_ID'		=>	$section_ID ,
				)
			);

			$sql1 = "SELECT 
						`crs`.`crs_ID`,
						`rsd`.`user_ID`,
						`rsd`.`rsd_ID`,
						`rsd`.`rsd_StudNum`,
						`rsd`.`rsd_FName`,
						`rsd`.`rsd_MName`,
						`rsd`.`rsd_LName`,
						`sn`.`suffix`,
						`sx`.`sex_Name`,
						`crs`.`status_ID`,
						`cr`.`class_Name`
						 FROM `class_room_student` `crs`
						LEFT JOIN `record_student_details` `rsd` ON `rsd`.`rsd_ID` = `crs`.`rsd_ID`
						LEFT JOIN `ref_suffixname` `sn` ON `sn`.`suffix_ID` = `rsd`.`suffix_ID`
						LEFT JOIN `ref_sex` `sx` ON `sx`.`sex_ID` = `rsd`.`sex_ID`
						LEFT JOIN `class_room` `cr` ON `cr`.`class_ID` = `crs`.`class_ID`
						WHERE `crs`.`class_ID` = ".$class_ID." AND crs.section_ID = ".$section_ID."";
			$statement1 = $account->runQuery($sql1);	
			$statement1->execute();	
			$res = $statement1->fetchAll();	

			foreach($res as $row){

				
				if (empty($row["user_ID"]))
				{

				}
				else{
					
					$sql2="INSERT INTO `notification` (`notif_ID`, `user_ID`, `notif_Msg`, `notif_Date`, `notif_Type`, `notif_State`) 
					VALUES (NULL, ".$row["user_ID"].", '(".$row["class_Name"].") Added New Activity ".$test_name."', CURRENT_TIMESTAMP, NULL, 1);";
						$statement2 = $account->runQuery($sql2);	
						$statement2->execute();	
				}
			}

			if(!empty($result))
			{
				echo 'Successfully Added';
			}
			

		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}
		
	}

	if($_POST["operation"] == "test_edit")
	{
		
		try
		{
			

			$class_ID = $_POST["class_ID"];
			$test_ID = $_POST["test_ID"];
			$test_name = $_POST["test_name"];
			$test_expired = $_POST["test_expired"];
			$test_timer = $_POST["test_timer"];
			$test_type = $_POST["test_type"];
			$test_status = $_POST["test_status"];
		

			$sql = "UPDATE `class_room_test` 
			SET 
			`test_Name` = :test_name,
			`test_Expired` = :test_expired,
			`test_Timer` = :test_timer,
			`status_ID` = :test_status,
			`tstt_ID` = :test_type
			 WHERE `test_ID` = :test_ID AND `class_ID` = :class_ID";
			$statement = $account->runQuery($sql);
				
			$result = $statement->execute(
			array(

					':class_ID'		=>	$class_ID ,
					':test_ID'		=>	$test_ID ,
					':test_name'		=>	$test_name ,
					':test_expired'		=>	$test_expired ,
					':test_timer'		=>	$test_timer ,
					':test_type'		=>	$test_type ,
					':test_status'		=>	$test_status ,

				)
			);
			if(!empty($result))
			{
				echo 'Successfully Added';
			}
		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}
	
	}

	if($_POST["operation"] == "test_delete")
	{
		try{
			$test_ID = $_POST["test_ID"];

			
			
			$statement0 = $account->runQuery(
				"DELETE FROM `class_room_test_attemp` WHERE `test_ID` = $test_ID"
				);
			$statement0->execute();

			$statement1 = $account->runQuery(
				"DELETE FROM `class_room_test_score` WHERE `test_ID` = $test_ID"
				);
			$statement1->execute();

			$statement2 = $account->runQuery(
				"SELECT * FROM `class_room_test_questions`  WHERE `test_ID` = $test_ID"
				);
			$statement2->execute();
			$resx = $statement2->fetchAll();
			foreach ($resx as $row){
				$question_ID = $row['question_ID'];

				$statement3 = $account->runQuery(
				"DELETE FROM `class_room_test_choices` WHERE `question_ID` = $question_ID"
				);
				$statement3->execute();

			}

			$statement1 = $account->runQuery(
				"DELETE FROM `class_room_test_questions` WHERE `test_ID`  = $test_ID"
				);
			$statement1->execute();

			$statement = $account->runQuery(
			"DELETE FROM `class_room_test` WHERE `test_ID` = :test_ID"
			);
			$result = $statement->execute(
				array(
					':test_ID'	=>	$_POST["test_ID"]
				)
			);
			
			if(!empty($result))
			{
				echo 'Successfully Deleted';
			}
		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}
	
		
	
	}

	if($_POST["operation"] == "test_view")
	{
		try{
			$test_ID = $_POST["test_ID"];
			$user_ID = $_SESSION["user_ID"];
			$statement = $account->runQuery(
			"SELECT * FROM `class_room_test_score` WHERE test_ID = :test_ID and user_ID = :user_ID 
			ORDER BY `score_ID` DESC   LIMIT 1"
			);
			$statement->execute(
				array(
					':test_ID'	=>	$test_ID,
					':user_ID'	=>	$user_ID
				)
			);
			
			$result = $statement->fetchAll();

			if($statement->rowCount() > 0){
				foreach($result as $row)
				{
					$score = 'Score: '.$row['score'];
				}
			}
			else
			{
				$score = 'No score';
			}
			echo $score;
			
		}
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}
		
	}

	

	
}
?>

