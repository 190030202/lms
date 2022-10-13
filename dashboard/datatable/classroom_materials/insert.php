<?php
require_once('../class.function.php');
$account = new DTFunction(); 
if(isset($_POST["m_operation"]))
{

	if($_POST["m_operation"] == "material_submit")
	{	
		try
		{
			
			$class_ID = $_POST["class_ID"];
			$section_ID = $_POST["section_ID"];
			$material_name = $_POST["material_name"];
			
			$file_origin_name = $_FILES["material_file"]["name"];
			$mcn = array($material_name,$file_origin_name);
			$material_names = json_encode($mcn);
			$file_mime_type = $_FILES["material_file"]["type"];

			if (isset($_FILES['material_file']['tmp_name'])) 
			{
				$file_Data = addslashes(file_get_contents($_FILES['material_file']['tmp_name']));
				
			}
			else{
				$file_Data = '';
			}

		
		
			
			$sql = "INSERT INTO `class_room_attachment` 
			(`attachment_ID`, `class_ID`, `attachment_Name`, `attachment_MIME`, `attachment_Data`, `attachment_Date`,`section_ID`) 
			VALUES (NULL, :class_ID, :material_names, :file_mime_type, '$file_Data', CURRENT_TIMESTAMP,'$section_ID');";
			$statement = $account->runQuery($sql);
				
			$result = $statement->execute(
			array(

					':class_ID'				=>	$class_ID ,
					':file_mime_type'		=>	$file_mime_type ,
					':material_names'		=>	$material_names ,
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
						WHERE `crs`.`class_ID` = ".$class_ID."";
			$statement1 = $account->runQuery($sql1);	
			$statement1->execute();	
			$res = $statement1->fetchAll();	

			foreach($res as $row){

				
				if (empty($row["user_ID"]))
				{

				}
				else{
					
					$sql2="INSERT INTO `notification` (`notif_ID`, `user_ID`, `notif_Msg`, `notif_Date`, `notif_Type`, `notif_State`) 
					VALUES (NULL, ".$row["user_ID"].", '(".$row["class_Name"].") Added New Material Files ', CURRENT_TIMESTAMP, NULL, 1);";
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

	

	if($_POST["m_operation"] == "material_delete")
	{
		try{
			$statement = $account->runQuery(
			"DELETE FROM `class_room_attachment` WHERE `attachment_ID` = :attachment_ID"
			);
			$result = $statement->execute(
				array(
					':attachment_ID'	=>	$_POST["material_ID"]
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
}
?>

