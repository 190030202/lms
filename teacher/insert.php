<?php
require_once('../class.function.php');
$teacher = new DTFunction(); 

ini_set('display_errors', 1);
ini_set('error_reporting', E_ERROR);

if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "submit_teacher")
	{	
		$teacher_EmpID = $_POST["teacher_EmpID"];
		$teacher_fname = $_POST["teacher_fname"];
		$teacher_mname = $_POST["teacher_mname"];
		$teacher_lname = $_POST["teacher_lname"];
		$teacher_bday = $_POST["teacher_bday"];
		$teacher_suffix = $_POST["teacher_suffix"];
		$teacher_sex = $_POST["teacher_sex"];
		$teacher_marital = $_POST["teacher_marital"];
		$teacher_email = addslashes($_POST["teacher_email"]);
		$teacher_address = addslashes($_POST["teacher_address"]);

		if (isset($_FILES['teacher_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['teacher_img']['tmp_name']));
			
		}
		else{
			$new_img = '';
		}


		
		$stmt1 = $teacher->runQuery("SELECT rid_EmpID FROM `record_instructor_details` WHERE rid_EmpID = $teacher_EmpID LIMIT 1");
		$stmt1->execute();
		$rs = $stmt1->fetchAll();
		if($stmt1->rowCount() > 0){
			echo "Instructor ID Already Used";
		}
		else{
			try{
				$stmt = $teacher->runQuery("INSERT INTO `record_instructor_details` 
					(
					`rid_ID`,
					 `rid_Img`,
					  `user_ID`,
					   `rid_EmpID`,
					    `rid_FName`,
					     `rid_MName`,
					      `rid_LName`,
					       `suffix_ID`,
					        `sex_ID`,
					         `marital_ID`,
					          `rid_Email`,
					           `rid_Bday`,
					            `rid_Address`)
					             VALUES (
					             NULL,
					              '$new_img',
					               NULL,
					                '$teacher_EmpID',
					                 '$teacher_fname',
					                  '$teacher_mname',
					                   '$teacher_lname',
					                    '$teacher_suffix',
					                     '$teacher_sex',
					                      '$teacher_marital',
					                       '$teacher_email',
					                        '$teacher_bday',
					                         '$teacher_address');");

				$result = $stmt->execute();
				if(!empty($result))
				{
				    echo  "Instructor Record Succesfully Updated";  
				    
				}
			} 
			catch (PDOException $e)
			{
			    echo "There is some problem in connection: " . $e->getMessage();
			}

		}

		
		
	}

	if($_POST["operation"] == "teacher_update")
	{
		
		
		$teacher_ID = $_POST["teacher_ID"];
		$teacher_EmpID = $_POST["teacher_EmpID"];
		$teacher_fname = $_POST["teacher_fname"];
		$teacher_mname = $_POST["teacher_mname"];
		$teacher_lname = $_POST["teacher_lname"];
		$teacher_bday = $_POST["teacher_bday"];
		$teacher_suffix = $_POST["teacher_suffix"];
		$teacher_sex = $_POST["teacher_sex"];
		$teacher_marital = $_POST["teacher_marital"];
		$teacher_email = addslashes($_POST["teacher_email"]);
		$teacher_address = addslashes($_POST["teacher_address"]);

		if (isset($_FILES['teacher_img']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['teacher_img']['tmp_name']));
			$set_img = "`rid_Img` = '$new_img' ,";
			
		}
		else{
			$new_img = '';
			$set_img = '';
		}

		try{

			 

			$stmt0 = $teacher->runQuery("SELECT rid_EmpID FROM `record_instructor_details` WHERE rid_EmpID ='".$teacher_EmpID."' AND rid_ID = '".$teacher_ID."'");
			$stmt0->execute();
			$stmt1 = $teacher->runQuery("SELECT rid_EmpID FROM `record_instructor_details` WHERE rid_EmpID ='".$teacher_EmpID."' ");

			$stmt1->execute();
			$rc0 = $stmt0->rowCount(); 
			$rc1 = $stmt1->rowCount(); 
			//ID Instructor ID did not change
			if($rc0 > 0){
				$set_EmpID = "";
			}
			else{
				//check if exist
				if($rc1 > 0){
					$set_EmpID = "";
					$id_exist = true;
				}
				else{
					$set_EmpID= "`rid_EmpID` = '$teacher_EmpID',";
					$id_exist = false;
				}

				
			}

			if ($id_exist){
				echo "Instructor ID Already Used";
			}
			else{
				$stmt = $teacher->runQuery("UPDATE 
				`record_instructor_details` 
				SET ".$set_img."
					".$set_EmpID."
					`rid_FName` = '$teacher_fname' ,
					`rid_MName` = '$teacher_mname' ,
					`rid_LName` = '$teacher_lname' ,
					`suffix_ID` = '$teacher_suffix' ,
					`sex_ID` = '$teacher_sex' ,
					`marital_ID` = '$teacher_marital' ,
					`rid_Email` = '$teacher_email' ,
					`rid_Bday` = '$teacher_bday' ,
					`rid_Address` = '$teacher_address' 
				WHERE `record_instructor_details`.`rid_ID` = $teacher_ID;");
				$result = $stmt->execute();
				if(!empty($result))
				{
				    echo  "Instructor Record Succesfully Updated";  
				    
				}

			}
			
		} 
		catch (PDOException $e)
		{
		    echo "There is some problem in connection: " . $e->getMessage();
		}

	
	}

	if($_POST["operation"] == "delete_teacher")
	{
		$statement = $teacher->runQuery(
			"DELETE FROM `record_instructor_details` WHERE `rid_ID` = :teacher_ID"
		);
		$result = $statement->execute(
			array(
				':teacher_ID'	=>	$_POST["teacher_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}
	if($_POST["operation"] == "gen_account")
	{
		$teacher_ID = $_POST["teacher_ID"];

		$teacher->generate_account($teacher_ID,"instructor");

	}

	
}
?>

