<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array

session_start();
$query = '';
$output = array();
$query .= "SELECT 
* ";
$query .= "FROM `class_room_assignment` cra";

if (isset($_REQUEST['classroom_ID'])) {
	$classroom_ID = $_REQUEST['classroom_ID'];
 	$query .= '  WHERE `cra`.`class_ID` = '.$classroom_ID.' AND ';
}
else{
	 $query .= ' WHERE';
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(cra.ca_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR cra.ca_Name LIKE "%'.$_POST["search"]["value"].'%" )';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY ca_ID DESC ';
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
	
		
	$format_date_added=date_create($row["ca_Added"]);
	$format_date_expired=date_create($row["ca_Expired"]);
	
	$format_date_added = date_format($format_date_added,"Y/m/d h:i a");
	$format_date_expired = date_format($format_date_expired,"Y/m/d h:i a");



	$zsql = "SELECT * FROM `class_room_assignment_attachment` WHERE ca_ID = ".$row["ca_ID"]." AND user_ID = ".$_SESSION["user_ID"]."";
	$statementxz = $account->runQuery($zsql);
	$statementxz->execute();
	$xcount = $statementxz->rowCount();
	if($account->student_level()) { 
		if($xcount > 0){
			$sb = '<button class="btn btn-outline-info btn-sm update_assignment" id="'.$row["ca_ID"].'">Update Assignment</button>';
		}
		else{
			$sb = '<button class="btn btn-outline-info btn-sm submit_assignment" id="'.$row["ca_ID"].'">Submit Assignment</button>';
		}
		$sbz ='';
	}
	else{
		$sb ='';
		$sbz = '<button class="btn btn-outline-info btn-sm view_subassg" id="'.$row["ca_ID"].'">View Submission</button>';
	}
	

		$sub_array[] = $iz;
		$sub_array[] = $row["ca_Name"];
		$sub_array[] = $format_date_added;
		$sub_array[] = $format_date_expired;
		$sub_array[] = '
		<div class="">
			'.$sbz.'
			'.$sb.'
			<button class="btn btn-outline-info btn-sm view_assg" id="'.$row["ca_ID"].'"><i class="icon-eye" style="font-size: 20px;"></i></button>
		 
		  <button class="btn btn-outline-primary btn-sm edit_assg"  id="'.$row["ca_ID"].'"><i class="icon-database-edit2" style="font-size: 20px;"></i></button>

		  <button class="btn btn-outline-danger btn-sm delete_assg"  id="'.$row["ca_ID"].'"><i class="icon-cross" style="font-size: 20px;"></i></button>
		</div>

		';
		// <div class="dropdown-divider"></div>
		// <a class="dropdown-item delete" id="'.$row["ca_ID"].'">Delete</a>
	$data[] = $sub_array;
	$iz++;
}
if (isset($_REQUEST['classroom_ID'])) {
	$classroom_ID = $_REQUEST['classroom_ID'];
 	$q = 'SELECT * FROM `class_room_assignment`  WHERE `cra`.`class_ID` = '.$classroom_ID.'  ';
}
else{
$q = "SELECT * FROM `class_room_assignment`";	
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



        
