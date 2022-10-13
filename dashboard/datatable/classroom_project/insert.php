<?php
require_once('../class.function.php');
$account = new DTFunction(); 
session_start();
error_reporting(0);
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_project")
	{	
		try
		{
			$class_ID = $_POST["class_ID"];
			$section_ID = $_POST["section_ID"];
			$proj_name = $_POST["proj_name"];
			$proj_desc = $_POST["proj_desc"];
			$proj_expired = $_POST["proj_expired"];

			$sql = "INSERT INTO `class_room_project` 
			(`proj_ID`, `class_ID`, `proj_Name`,`proj_Desc`, `proj_Added`, `proj_Expired`, `section_ID`) 
			VALUES (NULL, :class_ID, :proj_name, :proj_desc, CURRENT_TIMESTAMP, :proj_expired, :section_ID);";
				$statement = $account->runQuery($sql);
					
				$result = $statement->execute(
				array(

						':class_ID'		=>	$class_ID ,
						':section_ID'		=>	$section_ID ,
						':proj_name'		=>	$proj_name ,
						':proj_desc'		=>	$proj_desc ,
						':proj_expired'		=>	$proj_expired ,
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

	if($_POST["operation"] == "edit_project")
	{
		
		

			$proj_ID = $_POST["proj_ID"];
			$class_ID = $_POST["class_ID"];
			$section_ID = $_POST["section_ID"];
			$proj_name = $_POST["proj_name"];
			$proj_desc = $_POST["proj_desc"];
			$proj_expired = $_POST["proj_expired"];

		$sql = "UPDATE `class_room_project` 
		SET 
		`proj_Name` = :proj_name,
		`proj_Desc` = :proj_desc, 
		`proj_Expired` = :proj_expired
		 WHERE `proj_ID` = :proj_ID; ";
		$statement = $account->runQuery($sql);
			
		$result = $statement->execute(
		array(
				':proj_ID'	=>	$proj_ID,
				':proj_name'		=>	$proj_name ,
				':proj_desc'		=>	$proj_desc ,
				':proj_expired'		=>	$proj_expired ,
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
	
	}

	if($_POST["operation"] == "proj_delete")
	{
		$statement = $account->runQuery(
			"DELETE FROM `class_room_project` WHERE `proj_ID` = :proj_ID "
		);
		$result = $statement->execute(
			array(
				':proj_ID'	=>	$_POST["proj_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}

	
}

if(isset($_POST["sp_operation"]))
{
	if($_POST["sp_operation"] == "sproject_submit")
	{

		try
		{
			
			$class_ID = $_POST["class_ID"];
			$projx_ID = $_POST["projx_ID"];
			$sproj_Desc = $_POST["sproj_Desc"];
			
			$file_origin_name = $_FILES["sproj_file"]["name"];
			$mcn = array($file_origin_name,$file_origin_name);
			$material_names = json_encode($mcn);
			$file_mime_type = $_FILES["sproj_file"]["type"];

			if (isset($_FILES['sproj_file']['tmp_name'])) 
			{
				$file_Data = addslashes(file_get_contents($_FILES['sproj_file']['tmp_name']));
				
			}
			else{
				$file_Data = '';
			}

		
		
			
			$sql = "INSERT INTO `class_room_project_attachment` 
			(`attachment_ID`, `class_ID`, `attachment_Name`, `attachment_MIME`, `attachment_Data`, `attachment_Date`,`proj_ID`,`user_ID`,`attachment_Desc`) 
			VALUES (NULL, :class_ID, :material_names, :file_mime_type, '$file_Data', CURRENT_TIMESTAMP,'$projx_ID','".$_SESSION["user_ID"]."',:sproj_Desc);";
			$statement = $account->runQuery($sql);
				
			$result = $statement->execute(
			array(

					':class_ID'				=>	$class_ID ,
					':file_mime_type'		=>	$file_mime_type ,
					':material_names'		=>	$material_names ,
					':sproj_Desc'			=>	$sproj_Desc ,

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
if(isset($_POST["sp_operation"])){
	if($_POST["sp_operation"] == "sproject_update")
	{

		$sproj_Desc = $_POST["sproj_Desc"];
		$class_ID = $_POST["class_ID"];
		$projx_ID = $_POST["projx_ID"];

		if ($_FILES['sproj_file']['error'] == 0) 
		{

			$file_origin_name = $_FILES["sproj_file"]["name"];
			$mcn = array($file_origin_name,$file_origin_name);
			$file_names = json_encode($mcn);
			$file_mime_type = $_FILES["sproj_file"]["type"];

			$file_Data = addslashes(file_get_contents($_FILES['sproj_file']['tmp_name']));
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
		
 		$sql = "UPDATE `class_room_project_attachment` 
 		SET 
 		$sz
 		`attachment_Desc` = '$sproj_Desc' 
 		WHERE class_ID = '$class_ID' AND proj_ID = $projx_ID AND user_ID = ".$_SESSION["user_ID"].";";
 		$statement = $account->runQuery($sql);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
		
	}
}


?>

