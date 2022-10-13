<?php
require_once('../class.function.php');
$account = new DTFunction();  		 // Create new connection by passing in your configuration array

session_start();

$query = '';
$output = array();
$query .= "SELECT `crt`.*,`rs`.`status_Name`,`rtt`.`tstt_Name`";
$query .= " FROM `class_room_test`  `crt`
LEFT JOIN `ref_status`  `rs` ON `rs`.`status_ID` = `crt`.`status_ID`
LEFT JOIN `ref_test_type`  `rtt` ON `rtt`.`tstt_ID` = `crt`.`tstt_ID`";

if($account->student_level()) 
{
	$cxza = " AND rs.status_ID = 1 ";
	
}
else{
	$cxza ="";
}





if (isset($_REQUEST['class_ID']) || isset($_REQUEST['section_ID']) ) {
	$class_ID = $_REQUEST['class_ID'];
	$section_ID = $_REQUEST['section_ID'];
	if(isset($_REQUEST['type']))
	{
			$cxzax = " AND crt.tstt_ID = '".$_REQUEST['type']."'";
			
	}
	else
	{
		$cxzax  ="";

	}

 	$query .= '  WHERE crt.class_ID = '.$class_ID.' '.$cxza.' '.$cxzax.' AND crt.section_ID = '.$section_ID.'   AND';
}
else{
	 $query .= ' WHERE';
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(test_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR class_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR test_Name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR test_Added LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR test_Expired LIKE "%'.$_POST["search"]["value"].'%" )';
}




if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY test_ID DESC ';
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
$xzz =1;
foreach($result as $row)
{
	
	if($row["status_Name"] == "Enable")
	{
		$span = "<div class='btn btn-sm btn-success' style='min-width:65px;'>".$row["status_Name"]."</div>";
	}
	else{
		$span = "<div class='btn btn-sm btn-danger' style='min-width:65;'>".$row["status_Name"]."</div>";

	}




	$atmp_count = $account->atmp_count($_SESSION["user_ID"],$row["test_ID"]);
	//CHECK IF ACTIVITY IS EXPIRED
	$timenow = date("Y/m/d h:i:s");
	$test_Expired = $row["test_Expired"];

	// $te_dc = date_create($test_Expired);
	// $tn_dc = date_create($timenow);
	
	// $fd_te_dc= date_format($te_dc,"Y/m/d h:i a");
	// $fd_tn_dc = date_format($tn_dc,"Y/m/d h:i a");


	 $micro_timenow = strtotime($timenow);
	 $micro_timeexp = strtotime($test_Expired);


	 if(isset($_REQUEST['type'])){
	 	if($_REQUEST['type'] == 1){
		$zxczz  = "Quiz";
		}
		if($_REQUEST['type'] == 3){
			$zxczz  = "Assignment";
		}
	 }
	
	
	

	if ($atmp_count == 2 || $atmp_count == 1)
	{
		$takex = '
  	<a class="btn btn-outline-secondary btn-sm "   href="take?test_ID='.$row["test_ID"].'&classroom_ID='.$class_ID.'" target="_BLANK">Retake '.$zxczz.'</a>
		';

	}
	else{
		$takex = '<a class="btn btn-outline-secondary btn-sm "  href="take?test_ID='.$row["test_ID"].'&classroom_ID='.$class_ID.'" target="_BLANK">Take '.$zxczz.'</a>';
	}
	if ($micro_timenow > $micro_timeexp){
		
		// $takex = '<a class="dropdown-item "  href="#" >Activity Expired</a>';
		$takex = '';
		

	}



	if($account->student_level()){
	$btnx = '
    <a class="btn btn-outline-info studview_score" id="'.$row["test_ID"].'">View Scores</a>
    '.$takex;
	}
	
	
	if($account->admin_level() || $account->instructor_level()){
	$btnx = '
  	<a  class="btn btn-outline-secondary btn-sm "   href="questionaire?test_ID='.$row["test_ID"].'" target="_BLANK">View Questionaire</a>
  	<button type="button" class="btn btn-outline-info btn-sm view_score"  id="'.$row["test_ID"].'">View Scores</button>
     '.$takex.'
  	<button type="button" class="btn btn-outline-primary btn-sm edit"  id="'.$row["test_ID"].'">Edit</button>
  	<button type="button" class="btn btn-outline-danger btn-sm delete"  id="'.$row["test_ID"].'">Delete</button>

    ';
	}
	

	
	$format_date_added=date_create($row["test_Added"]);
	$format_date_expired=date_create($test_Expired);
	
	$format_date_added = date_format($format_date_added,"Y/m/d h:i a");
	$format_date_expired = date_format($format_date_expired,"Y/m/d h:i a");

	$sub_array = array();
	$sub_array[] = $xzz;
	// $sub_array[] = $row["class_ID"];
	$sub_array[] = $row["test_Name"];
	$sub_array[] = $row["tstt_Name"];
	$sub_array[] = $format_date_added;
	$sub_array[] = $format_date_expired;



	if($row["test_Timer"] > 1){
		$m = " Mins";
	}
	else{
		$m = " Min";
	}
	$sub_array[] = $row["test_Timer"].$m;
	$sub_array[] = $span;

		$sub_array[] = '
		<div class="" role="group" aria-label="Basic example">
		'.$btnx.'
		</div>

		';
	$data[] = $sub_array;
	$xzz++;
}

$q = "SELECT * FROM `class_room_test`";
$filtered_rec = $account->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
