<?php
require_once('../class.function.php');
$room = new DTFunction(); 
if(isset($_POST["operation"]))
{

if($_POST["operation"] == "studentlist_submit")
	{	
		try
		{
			$rsd_ID = $_POST["rsd_ID"];
			$class_ID = $_POST["class_ID"];
			$section_ID = $_POST['section_ID'];
			$sql = "INSERT INTO `class_room_student` (`crs_ID`, `class_ID`, `rsd_ID`,`section_ID`) VALUES (NULL, :class_ID, :rsd_ID,:section_ID);";
				$statement = $room->runQuery($sql);
					
				$result = $statement->execute(
				array(

						':rsd_ID'		=>	$rsd_ID ,
						':class_ID'		=>	$class_ID ,
						':section_ID'		=>	$section_ID ,

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



	if($_POST["operation"] == "studentlist_delete")
	{
		$statement = $room->runQuery(
			"DELETE FROM `class_room_student` WHERE `crs_ID` = :crs_ID"
		);
		$result = $statement->execute(
			array(
				':crs_ID'	=>	$_POST["crs_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}

	if($_POST["operation"] == "student_approve" || $_POST["operation"] == "student_enable")
	{
		$statement = $room->runQuery(
			"UPDATE `class_room_student` SET `status_ID` = '2' WHERE `class_room_student`.`crs_ID` = :crs_ID"
		);
		$result = $statement->execute(
			array(
				':crs_ID'	=>	$_POST["crs_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
		
	
	}
	if($_POST["operation"] == "student_disable")
	{
		$statement = $room->runQuery(
			"UPDATE `class_room_student` SET `status_ID` = '3' WHERE `class_room_student`.`crs_ID` = :crs_ID"
		);
		$result = $statement->execute(
			array(
				':crs_ID'	=>	$_POST["crs_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}


	
	
	
}
?>

