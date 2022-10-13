<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array

session_start();
$query = '';
$output = array();
$query .= "SELECT 
* ";
$query .= "FROM `class_room_project` crp";

if (isset($_REQUEST['classroom_ID'])) {
	$classroom_ID = $_REQUEST['classroom_ID'];
 	$query .= '  WHERE `crp`.`class_ID` = '.$classroom_ID.' AND ';
}
else{
	 $query .= ' WHERE';
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(crp.proj_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR crp.proj_Name LIKE "%'.$_POST["search"]["value"].'%" )';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY proj_ID DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $account->runQuery($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
$iz = 1;
foreach($result as $row)
{
	

	$sub_array = array();
	
		
	$format_date_added=date_create($row["proj_Added"]);
	$format_date_expired=date_create($row["proj_Expired"]);
	
	$format_date_added = date_format($format_date_added,"Y/m/d h:i a");
	$format_date_expired = date_format($format_date_expired,"Y/m/d h:i a");



	$zsql = "SELECT * FROM `class_room_project_attachment` WHERE proj_ID = ".$row["proj_ID"]." AND user_ID = ".$_SESSION["user_ID"]."";
	$statementxz = $account->runQuery($zsql);
	$statementxz->execute();
	$xcount = $statementxz->rowCount();
	if($account->student_level()) { 
		if($xcount > 0){
			$sb = '<button class="btn btn-outline-info btn-sm update_proj" id="'.$row["proj_ID"].'">Update Project</button>';
		}
		else{
			$sb = '<button class="btn btn-outline-info btn-sm submit_proj" id="'.$row["proj_ID"].'">Submit Project</button>';
		}
		$sbz ='';
	}
	else{
		$sb ='';
		$sbz = '<button class="btn btn-outline-info btn-sm view_subproj" id="'.$row["proj_ID"].'">View Submission</button>';
	}
	

		$sub_array[] = $iz;
		$sub_array[] = $row["proj_Name"];
		$sub_array[] = $format_date_added;
		$sub_array[] = $format_date_expired;
		$sub_array[] = '
		<div class="">
			'.$sbz.'
			'.$sb.'
			<button class="btn btn-outline-info btn-sm view_proj" id="'.$row["proj_ID"].'"><i class="icon-eye" style="font-size: 20px;"></i></button>
		 
		  <button class="btn btn-outline-primary btn-sm edit_proj"  id="'.$row["proj_ID"].'"><i class="icon-database-edit2" style="font-size: 20px;"></i></button>

		  <button class="btn btn-outline-danger btn-sm delete_proj"  id="'.$row["proj_ID"].'"><i class="icon-cross" style="font-size: 20px;"></i></button>
		</div>

		';
		// <div class="dropdown-divider"></div>
		// <a class="dropdown-item delete" id="'.$row["proj_ID"].'">Delete</a>
	$data[] = $sub_array;
	$iz++;
}
if (isset($_REQUEST['classroom_ID'])) {
	$classroom_ID = $_REQUEST['classroom_ID'];
 	$q = 'SELECT * FROM `class_room_project`  WHERE `crp`.`class_ID` = '.$classroom_ID.'  ';
}
else{
$q = "SELECT * FROM `class_room_project`";	
}

$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
