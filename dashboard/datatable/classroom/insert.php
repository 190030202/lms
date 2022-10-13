<?php
require_once('../class.function.php');

session_start();
$classroom = new DTFunction(); 
if($_POST["action"] == "classroom_add")
{	
	try
	{	$user_ID = $_SESSION['user_ID'];
		$classroom_course = $_POST["classroom_course"];
		$classroom_descr = $_POST["classroom_descr"];
		$classroom_password = $_POST["classroom_password"];

		$last_id = $classroom->insert_classroom($user_ID,$classroom_course,$classroom_descr,$classroom_password);
		$y = date("Y");
        $m = date("m");
        $d = date("d");
        $classcode = $y.$m.$d+$last_id;

        $sql ="SELECT * FROM `class_room` WHERE class_Code = '$classcode'";
        $smtp = $classroom->runQuery($sql);
		$chk_result = $smtp->execute();
		if($smtp->rowCount() == 1)
		{
			 $classcode += 1;
		}
	
		
		$sql = "UPDATE `class_room` SET `class_Code` = '".$classcode."' WHERE `class_ID` = ".$last_id;
		$smtp1 = $classroom->runQuery($sql);
		$update_result = $smtp1->execute();
		if(!empty($update_result))
		{
			echo 'Successfully Added';
		}
		

	}
	catch (PDOException $e)
	{	
	    echo "There is some problem in connection: " . $e->getMessage();
	}
	
}
if($_POST["action"] == "classroom_delete")
{	
	try
	{
		$classroom_ID = $_POST["classroom_ID"];

		$sql0 = "DELETE FROM `class_room_student` WHERE `class_ID` = $classroom_ID";
		$statement0 = $classroom->runQuery($sql0);
				
		$result0 = $statement0->execute();

		$sql1 = "DELETE FROM `class_room_test` WHERE `class_ID` = $classroom_ID";
		$statement1 = $classroom->runQuery($sql1);
				
		$result1 = $statement1->execute();

		

		$sql = "DELETE FROM `class_room` WHERE `class_room`.`class_ID` = $classroom_ID";
		$statement = $classroom->runQuery($sql);
				
		$result = $statement->execute();
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

if($_POST["action"] == "classroom_edit")
{
	try
	{
		$classroom_ID = $_POST["classroom_ID"];
		$classroom_course = $_POST["classroom_course"];
		$classroom_descr = $_POST["classroom_descr"];
		$classroom_password = $_POST["classroom_password"];
		$class_status = $_POST["class_status"];

		$sql = "UPDATE `class_room` 
		SET 
		`class_Name` = '$classroom_course',
		`class_Description` = '$classroom_descr',
		`status_ID` = '$class_status',
		`class_Password` = '$classroom_password' 
		WHERE `class_room`.`class_ID` =  $classroom_ID";
		$statement = $classroom->runQuery($sql);
				
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Successfully Enable';
		}
	}
	catch (PDOException $e)
	{	
	    echo "There is some problem in connection: " . $e->getMessage();
	}
	
}
if($_POST["action"] == "enable_classroom")
{
	try
	{
		$classroom_ID = $_POST["classroom_ID"];

		$sql = "UPDATE `class_room` SET `status_ID` = '1' WHERE `class_room`.`class_ID` = $classroom_ID";
		$statement = $classroom->runQuery($sql);
				
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Successfully Enable';
		}
	}
	catch (PDOException $e)
	{	
	    echo "There is some problem in connection: " . $e->getMessage();
	}
	
}
if($_POST["action"] == "disabled_classroom")
{
	try
	{
		$classroom_ID = $_POST["classroom_ID"];

		$sql = "UPDATE `class_room` SET `status_ID` = '2' WHERE `class_room`.`class_ID` = $classroom_ID";
		$statement = $classroom->runQuery($sql);
				
		$result = $statement->execute();

		
		if(!empty($result))
		{
			echo 'Successfully Disabled';
		}
	}
	catch (PDOException $e)
	{	
	    echo "There is some problem in connection: " . $e->getMessage();
	}
}


if($_POST["action"] == "joinclass_submit")
{
	
	
	try
	{
		$class_Code = $_POST["join_code"];
		$class_Section = $_POST["join_section"];
		$class_Password = $_POST["join_password"];
		$user_ID = $_SESSION['user_ID'];

		$sql = "SELECT * FROM `class_room` WHERE 
		class_Code  = '$class_Code' AND 
		class_Password = '$class_Password'";
		$statement = $classroom->runQuery($sql);
				
		$statement->execute();
		$result = $statement->fetchAll();

		//CHECK IF CLASS EXIST
		if ($statement->rowCount() > 0)
		{
			try
			{
				//GET CLASS ID
				foreach($result as $row)
				{
					$class_ID = $row["class_ID"];
				}
				//GET STUDENT RSD ID
				$sql1 = "SELECT rsd_ID FROM `record_student_details` WHERE user_ID = '$user_ID' LIMIT 1";
				$statement1 = $classroom->runQuery($sql1);
				$statement1->execute();
	            $result1 = $statement1->fetchAll();
				foreach($result1 as $row)
				{
					$rsd_ID = $row["rsd_ID"];
				}


				 $sqlxc = "SELECT *,REPLACE(UPPER(section_Name),\" \",\"_\") `secName` FROM `ref_section` WHERE `class_ID` = '".$class_ID."' HAVING `secName` = '".$class_Section."'";
				$statementxc = $classroom->runQuery($sqlxc);
				$statementxc->execute();
				$result3 = $statementxc->fetchAll();
				//IF SECTION IS EXIST
				if ($statementxc->rowCount() > 0)
				{
					foreach($result3 as $row)
					{
						$section_ID = $row["section_ID"];
					}
					// //CHECK IF STUDENT IS ALREADY IN CLASS
					$sqlx = "SELECT * FROM `class_room_student`
					WHERE 
					rsd_ID = '$rsd_ID' and 
					class_ID  = '$class_ID' and
					section_ID  = '$section_ID' 
					LIMIT 1";
					$statementx = $classroom->runQuery($sqlx);
					$statementx->execute();
					if ($statementx->rowCount() > 0)
					{
						echo 'You already join to this room';
					}
					else
					{
						//INSERT STUDENT IN CLASS
						$sql2 = "INSERT INTO `class_room_student` 
						(`crs_ID`, `class_ID`, `rsd_ID`, `status_ID`,`section_ID`) 
						VALUES (NULL, '$class_ID', '$rsd_ID', '3','$section_ID');";
						$statement2 = $classroom->runQuery($sql2);
								
						$result2 = $statement2->execute();

						if(!empty($result2))
						{
							echo 'Successfully Join Wait For Approval';
						}
					}

					
				}
				//
				else{
					echo 'Section Don\'t Exist';
				}


				
			}
			catch (PDOException $e)
			{	
			    echo "There is some problem in connection: " . $e->getMessage();
			}	
		}
		else{
			echo 'Wrong Password Or Class ID';
		}
		
	}
	catch (PDOException $e)
	{	
	    echo "There is some problem in connection: " . $e->getMessage();
	}
	
}




?>

