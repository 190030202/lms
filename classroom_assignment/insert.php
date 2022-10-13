<?php
require_once('../class.function.php');
$account = new DTFunction(); 
session_start();
error_reporting(0);
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_assignment")
	{	
		try
		{
			$class_ID = $_POST["class_ID"];
			$section_ID = $_POST["section_ID"];
			$ca_Name = $_POST["assg_name"];
			$ca_Desc = $_POST["assg_desc"];
			$ca_Expired = $_POST["assg_expired"];

			$sql = "INSERT INTO `class_room_assignment` 
			(`ca_ID`, `class_ID`, `ca_Name`,`ca_Desc`, `ca_Added`, `ca_Expired`, `section_ID`) 
			VALUES (NULL, :class_ID, :ca_Name, :ca_Desc, CURRENT_TIMESTAMP, :ca_Expired, :section_ID);";
				$statement = $account->runQuery($sql);
					
				$result = $statement->execute(
				array(

						':class_ID'		=>	$class_ID ,
						':section_ID'		=>	$section_ID ,
						':ca_Name'		=>	$ca_Name ,
						':ca_Desc'		=>	$ca_Desc ,
						':ca_Expired'		=>	$ca_Expired ,
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

	if($_POST["operation"] == "edit_assg")
	{
		
		

			$ca_ID = $_POST["ca_ID"];
			$class_ID = $_POST["class_ID"];
			$section_ID = $_POST["section_ID"];
			$ca_Name = $_POST["assg_name"];
			$ca_Desc = $_POST["assg_desc"];
			$ca_Expired = $_POST["assg_expired"];

		$sql = "UPDATE `class_room_assignment` 
		SET 
		`ca_Name` = :ca_Name,
		`ca_Desc` = :ca_Desc, 
		`ca_Expired` = :ca_Expired
		 WHERE `ca_ID` = :ca_ID; ";
		$statement = $account->runQuery($sql);
			
		$result = $statement->execute(
		array(
				':ca_ID'	=>	$ca_ID,
				':ca_Name'		=>	$ca_Name ,
				':ca_Desc'		=>	$ca_Desc ,
				':ca_Expired'		=>	$ca_Expired ,
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
	
	}

	if($_POST["operation"] == "assignment_delete")
	{
		$statement = $account->runQuery(
			"DELETE FROM `class_room_assignment` WHERE `ca_ID` = :ca_ID "
		);
		$result = $statement->execute(
			array(
				':ca_ID'	=>	$_POST["ca_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}

	
}

if(isset($_POST["sa_operation"]))
{
	if($_POST["sa_operation"] == "sassignment_submit")
	{

		try
		{
			
			$class_ID = $_POST["class_ID"];
			$sassg_ID = $_POST["sassg_ID"];
			$sassg_desc = $_POST["sassg_desc"];
			
			$file_origin_name = $_FILES["sassg_file"]["name"];
			$mcn = array($file_origin_name,$file_origin_name);
			$material_names = json_encode($mcn);
			$file_mime_type = $_FILES["sassg_file"]["type"];

			if (isset($_FILES['sassg_file']['tmp_name'])) 
			{
				$file_Data = addslashes(file_get_contents($_FILES['sassg_file']['tmp_name']));
				
			}
			else{
				$file_Data = '';
			}

		
		
			
			$sql = "INSERT INTO `class_room_assignment_attachment` 
			(`attachment_ID`, `class_ID`, `attachment_Name`, `attachment_MIME`, `attachment_Data`, `attachment_Date`,`ca_ID`,`user_ID`,`attachment_Desc`) 
			VALUES (NULL, :class_ID, :material_names, :file_mime_type, '$file_Data', CURRENT_TIMESTAMP,'$sassg_ID','".$_SESSION["user_ID"]."',:sca_Desc);";
			$statement = $account->runQuery($sql);
				
			$result = $statement->execute(
			array(

					':class_ID'				=>	$class_ID ,
					':file_mime_type'		=>	$file_mime_type ,
					':material_names'		=>	$material_names ,
					':sca_Desc'			=>	$sassg_desc ,

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


}
if(isset($_POST["sa_operation"])){
	if($_POST["sa_operation"] == "sassigment_update")
	{



		$class_ID = $_POST["class_ID"];
		$sassg_ID = $_POST["sassg_ID"];
		$sassg_desc = $_POST["sassg_Desc"];

		if ($_FILES['sassg_file']['error'] == 0) 
		{

			$file_origin_name = $_FILES["sassg_file"]["name"];
			$mcn = array($file_origin_name,$file_origin_name);
			$file_names = json_encode($mcn);
			$file_mime_type = $_FILES["sassg_file"]["type"];

			$file_Data = addslashes(file_get_contents($_FILES['sassg_file']['tmp_name']));
			$sz = "
			attachment_Name = '$file_names',
			attachment_MIME = '$file_mime_type',
			attachment_Data = '$file_Data',
			";
			
			
		}
		else{
			$file_Data = '';
			$sz  = '';
		}
		
 		$sql = "UPDATE `class_room_assignment_attachment` 
 		SET 
 		$sz
 		`attachment_Desc` = '$sassg_desc' 
 		WHERE class_ID = '$class_ID' AND ca_ID = $sassg_ID AND user_ID = ".$_SESSION["user_ID"].";";
 		$statement = $account->runQuery($sql);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
		
	}
}


?>

