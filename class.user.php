<?php
require_once('dbconfig.php');

class USER
{	

	private $conn;
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	//log in function 
	public function doLogin($login_user,$login_password)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_ID, lvl_ID ,user_Name, user_Pass,user_Img FROM user_account WHERE user_Name=:user_Name");
			$stmt->execute(array(':user_Name'=>$login_user));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($login_password, $userRow['user_Pass']))
				{
					$_SESSION['lvl_ID'] = $userRow['lvl_ID'];
					$_SESSION['user_ID'] = $userRow['user_ID'];
					$_SESSION['user_Name'] = $userRow['user_Name'];
					if (!empty($userRow['user_Img'])) {
					 $s_img = 'data:image/jpeg;base64,'.base64_encode($userRow['user_Img']);
					}
					else{
					  $s_img = "../assets/img/users/default.jpg";
					}
					 $_SESSION['user_Img'] = $s_img;
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	// register function
	public function register($reg_studentnum,$reg_password,$reg_email)
	{
		try
		{	
			
			$stmt = $this->conn->prepare("SELECT * FROM `record_student_details` WHERE rsd_StudNum = :reg_studentnum OR rsd_Email = :reg_email LIMIT 1");

			$stmtx = $this->conn->prepare("SELECT * FROM `user_account` WHERE user_Name =  :reg_studentnum LIMIT 1");


			$stmt->bindparam(":reg_studentnum", $reg_studentnum);	
			$stmtx->bindparam(":reg_studentnum", $reg_studentnum);	
			$stmt->bindparam(":reg_email", $reg_email);	
			$stmt->execute();
			$stmtx->execute();
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		
			if ($stmtx->rowCount() > 0)
			{
				// echo "User Already Register";
				return false;
			}
			else
			{
				if($stmt->rowCount() == 1)
				{
					$rsd_ID = $userRow["rsd_ID"];
					$new_password = password_hash($reg_password, PASSWORD_DEFAULT);

					$stmt = $this->conn->prepare("INSERT INTO `user_account` (`user_ID`, `lvl_ID`, `user_Img`, `user_Name`, `user_Pass`, `user_Registered`) VALUES (NULL, 1, NULL, :reg_studentnum, :reg_password, CURRENT_TIMESTAMP);");
							
					$stmt->bindparam(":reg_studentnum", $reg_studentnum);	 
					$stmt->bindparam(":reg_password", $new_password);	
					$stmt->execute();
					$user_ID = $this->conn->lastInsertId();

					$stmt = $this->conn->prepare("UPDATE `record_student_details` SET `user_ID` = :user_ID WHERE `record_student_details`.`rsd_ID` = :rsd_ID;");
					$stmt->bindparam(":user_ID", $user_ID);	
					$stmt->bindparam(":rsd_ID", $rsd_ID); 
					$stmt->execute();		

					
					
					return $stmt;
				}

			}

			


			
		}
		catch(PDOException $e)
		{
			// echo $e->getMessage();
			return false;
		}				
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_ID']))
		{
			return true;
		}
	}
	public function check_accesslevel($page_level)
	{
		if (isset($_SESSION['lvl_ID'])) {

			if ($_SESSION['lvl_ID'] !=  $page_level) {
			    header('Location: ../error');
			}
		}
	}
	public function redirect_dashboard()
	{
		if (isset($_SESSION['lvl_ID'])) 
		{
			header("Location: dashboard");
			
		}
	}
	public function redirect($url)
	{
		header("Location: $url");
	}
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_ID']);
		return true;
	}
	public function parseUrl()
	{
		if(isset($_GET['url'])){

			$url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

			return $url;

		}

	}
	public function getUsername()
	{
		echo $_SESSION['user_Name'];
	}

	public function getUserPic()
	{
		echo $_SESSION['user_Img'] ;
	}
	public function page_url()
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $url;
	}
	public function close()
	{
		return mysql_close();
	}
	//ACCOUNT PAGE
	public function user_level_option()
	{
		$query ="SELECT * FROM `user_level`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["lvl_ID"].'">'.$row["lvl_Name"].'</option>';
		}
		
	}
	public function ref_status()
	{
		$query ="SELECT * FROM `ref_status`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["status_ID"].'">'.$row["status_Name"].'</option>';
		}
		
	}
	public function ref_test_type()
	{
		$query ="SELECT * FROM `ref_test_type`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			if($row["tstt_ID"] == 2){

			}
			else{

				echo '<option value="'.$row["tstt_ID"].'">'.$row["tstt_Name"].'</option>';
			}
		}
	}
	public function user_suffix_option()
	{
		$query ="SELECT * FROM `ref_suffixname`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["suffix_ID"].'">'.$row["suffix"].'</option>';
		}
		
	}
	public function get_suffix($suffix_ID)
	{
		$query ="SELECT * FROM `ref_suffixname` WHERE suffix_ID = $suffix_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			if ($row["suffix"] == "N/A")
			{
				$suffix = "";
			}
			else
			{
				$suffix =  $row["suffix"];
			}
		}
		
	}
	public function get_test($test_ID)
	{
		$query ="SELECT * FROM `class_room_test` WHERE test_ID = $test_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
		
	}
	public function get_score($score_ID)
	{
		$query ="SELECT * FROM `class_room_test_score` WHERE score_ID = $score_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
		
	}
	public function get_section($section_ID)
	{
		$query ="SELECT * FROM `ref_section` WHERE section_ID = $section_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();

		
		return $result;
		
	}

	
	public function user_sex_option()
	{
		$query ="SELECT * FROM `ref_sex`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["sex_ID"].'">'.$row["sex_Name"].'</option>';
		}
		
	}
	
	public function user_marital_option()
	{
		$query ="SELECT * FROM `ref_marital`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["marital_ID"].'">'.$row["marital_Name"].'</option>';
		}
		
	}
	public function user_course_option()
	{
		$query ="SELECT * FROM `cvsu_course`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["course_ID"].'">'.$row["course_Name"].'</option>';
		}
		
	}
	
	//SCHOOL YEAR PAGE
	public function schoolyear_status_option()
	{
		$query ="SELECT * FROM `status`";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach($result as $row)
		{
			echo '<option value="'.$row["status_ID"].'">'.$row["status_Name"].'</option>';
		}
		
	}
	public function profile_email()
	{
		$user_type = "";
		$user_type_acro = "";
		if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "student";
			$user_type_acro = "rsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "instructor";
			$user_type_acro = "rid";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "admin";
			$user_type_acro = "rad";
		}
		$query ="SELECT ".$user_type_acro."_Email FROM `record_".$user_type."_details` WHERE user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
	
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row[$user_type_acro."_Email"];
			}
		}
		else{
			echo "Empty";
		}
	}
	public function profile_address()
	{
		$user_type = "";
		$user_type_acro = "";
		if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "student";
			$user_type_acro = "rsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "instructor";
			$user_type_acro = "rid";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "admin";
			$user_type_acro = "rad";
		}
		$query ="SELECT ".$user_type_acro."_Address FROM `record_".$user_type."_details` WHERE user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row[$user_type_acro."_Address"];
			}
		}
		else{
			echo "Empty";
		}	
	}
	public function profile_name()
	{
		$user_type = "";
		$user_type_acro = "";
		if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "student";
			$user_type_acro = "rsd";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "instructor";
			$user_type_acro = "rid";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "admin";
			$user_type_acro = "rad";
		}
		$query ="SELECT ".$user_type_acro."_FName,".$user_type_acro."_MName,".$user_type_acro."_LName, suffix_ID FROM `record_".$user_type."_details` WHERE user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				$full_name = "";
				$full_name .= $row[$user_type_acro."_LName"].", ";
				$full_name .= $row[$user_type_acro."_FName"]." ";
				$full_name .= $row[$user_type_acro."_MName"]." ";
				$full_name .= $this->get_suffix($row["suffix_ID"]);

			}
				echo $full_name;
		}
		else{
			echo "Empty";
		}	
	}
	public function profile_school_id()
	{
		$user_type = "";
		$user_type_acro = "";
		if ($_SESSION['lvl_ID'] == "1")
		{
			$user_type = "student";
			$id_type = "rsd_StudNum";
		}
		if ($_SESSION['lvl_ID'] == "2")
		{
			$user_type = "instructor";
			$id_type = "rid_EmpID";
		}
		if ($_SESSION['lvl_ID'] == "3")
		{
			$user_type = "admin";
			$id_type = "rad_EmpID";
		}
		$query ="SELECT ".$id_type." FROM `record_".$user_type."_details` WHERE user_ID = ".$_SESSION['user_ID'];
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() == 1)
		{
			foreach($result as $row)
			{
				echo $row[$id_type];
			}
		}
		else{
			echo "Empty";
		}	
	}
	public function  student_level()
	{
		if ($_SESSION['lvl_ID'] == "1")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function  instructor_level()
	{
		if ($_SESSION['lvl_ID'] == "2")
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	public function  admin_level()
	{
		if ($_SESSION['lvl_ID'] == "3")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	 public function  classroom_details($classroom_ID)
	{
		$output = array();
		$query ="SELECT cr.*,
(case  
 when (ua.lvl_ID = 1) then (SELECT CONCAT(rsd.rsd_FName,' ',rsd.rsd_MName,' ',rsd.rsd_LName) FROM record_student_details rsd WHERE rsd.user_ID = ua.user_ID)
when (ua.lvl_ID = 2)  then (SELECT CONCAT(rid.rid_FName,' ',rid.rid_MName,' ',rid.rid_LName) FROM record_instructor_details rid WHERE rid.user_ID = ua.user_ID)
when (ua.lvl_ID = 3)  then (SELECT CONCAT(rad.rad_FName,' ',rad.rad_MName,' ',rad.rad_LName) FROM record_admin_details rad WHERE rad.user_ID = ua.user_ID)
end)  Posted_By 
FROM `class_room` `cr` 
LEFT JOIN `user_account` `ua` ON `ua`.`user_ID` = `cr`.`user_ID`
LEFT JOIN `user_level` `ul` ON `ul`.`lvl_ID` = `ua`.`lvl_ID`
WHERE `cr`.class_ID  = '".$classroom_ID."' 
			LIMIT 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();

		foreach($result as $row)
		{


			$output["class_ID"] = $row["class_ID"];
			$output["class_Code"] = $row["class_Code"];
			$output["class_Name"] = $row["class_Name"];
			$output["class_Description"] = $row["class_Description"];
			$output["class_Password"] = $row["class_Password"];
			$output["class_status"] = $row["status_ID"];
			$output["Instructor"] = $row["Posted_By"];
			

		
		}
		return $output;
	}
	public function test_choices($choices_ID,$i_x_n){
		
		$query ="SELECT * FROM `class_room_test_choices` WHERE question_ID = $choices_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		$x = 1;
		foreach($result as $row)
		{
			?>
			<div class="form-check ">
                <input class="form-check-input" type="radio" name="q_coption<?php echo $i_x_n?>" id="inlineRadio<?php echo $x?>" value="<?php echo $row["choice_ID"]?>">
                <label class="form-check-label" for="inlineRadio<?php echo $x?>"><?php echo $row["choice"]?></label>
             </div>
			<?php

			$x++;
		}
	}
	public function test_question($test_ID){
		$query ="SELECT * FROM `class_room_test_questions` WHERE test_ID = $test_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$count = $stmt->rowCount();
		$x = 1;
		if($count < 1){
			echo "NO CONTENT";
		}
		else{
			foreach($result as $row)
			{
				?>
				<div class="form-group col-md-12">
	              <label for=""><?php echo $x?>.) <?php echo $row["question"]?></label>
	              <?php $this->test_choices($row["question_ID"],$x)?>
	            </div>
				<?php

				$x++;
			}

		}
		
		?><input type="hidden" name="qcount" value="<?php echo $count;?>">
		<?php
	}

	public function test_time($test_ID){
		$query ="SELECT test_Timer FROM `class_room_test` WHERE test_ID =$test_ID";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$time = $row["test_Timer"];
		}
		return $time;
	}
	public function getSidenavUserInfo()
	{
		 // $_SESSION['user_Name'];
		$uID = $_SESSION['user_ID'];
		$sql = "SELECT 
				(case  
				 when (ua.lvl_ID = 1) then (SELECT CONCAT(rsd.rsd_FName,' ',LEFT(rsd.rsd_MName, 1),'. ',rsd.rsd_LName) FROM record_student_details rsd WHERE rsd.user_ID = ua.user_ID)
				when (ua.lvl_ID = 2)  then (SELECT CONCAT(rid.rid_FName,' ',LEFT(rid.rid_MName, 1),'. ',rid.rid_LName) FROM record_instructor_details rid WHERE rid.user_ID = ua.user_ID)
				when (ua.lvl_ID = 3)  then (SELECT CONCAT(rad.rad_FName,' ',LEFT(rad.rad_MName, 1),'. ',rad.rad_LName) FROM record_admin_details rad WHERE rad.user_ID = ua.user_ID)
				end) fullname
				FROM `user_account` ua WHERE ua.user_ID = $uID LIMIT 1";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		foreach($result as $row)
		{
			$fullname = ucwords($row["fullname"]);
		}
		echo $fullname;
		if($this->student_level() ){
			echo "<br><small>(Student)</small>";
		}
		if($this->instructor_level() ){
			echo "<br><small>(Insturctor)</small>";
		}
		if($this->admin_level() ){
			echo "<br><small>(Admin)</small>";
		}
	}

	 public function notification(){


		$query = "SELECT * FROM `notification` WHERE user_ID = ".$_SESSION['user_ID']." 
		ORDER BY `notification`.`notif_Date`  DESC LIMIT 25";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		if($stmt->rowCount() > 0){
			foreach($result as $row){


			    $ndate = strtotime($row["notif_Date"]);
				$ndate =  date("Y-m-d h:i:sa",$ndate);
			?>
			<div class="p-2 bd-highlight border-bottom">
                  <small class=""><?php echo $row["notif_Msg"]?></small>
                  <br>
                  <small class="text-muted float-right"><?php echo  $ndate?></small>
            </div>
			<?php
			}
		}
		else{
			?>
			<div class="p-2 bd-highlight border-bottom"><small>No Notification Available</small></div>
			<?php


		}
		
		
		
	}


	
	



	
}