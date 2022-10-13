<?php
require_once('../class.function.php');
$room = new DTFunction();  		 // Create new connection by passing in your configuration array


if (isset($_REQUEST['test_ID'])) {
	$xtest_ID = $_REQUEST['test_ID'];
}


$query = '';
$output = array();
$query .= 'SELECT 
DISTINCT(rs.rsd_ID),
rs.crs_ID,
rsd.rsd_StudNum,
rsd.rsd_FName,
rsd.rsd_MName,
rsd.rsd_LName,
sn.suffix,
sx.sex_Name,
rsd.user_ID,
(
    SELECT 
    CONCAT("{\"datex\":\" ",MAX(score_Date),"\",\"score_ID\":\" ",score_ID,"\",\"score\":\" ",score,"\"}")
    FROM `class_room_test_score` crts2  WHERE crts2.user_ID = rsd.user_ID
) json_score,
(SELECT count(test_ID) FROM class_room_test_questions WHERE test_ID = '.$xtest_ID.') over'
;
$query .= "  FROM `class_room_student` `rs`
LEFT JOIN `record_student_details` `rsd` ON `rsd`.`rsd_ID` = `rs`.`rsd_ID`
LEFT JOIN `ref_suffixname` `sn` ON `sn`.`suffix_ID`  = `rsd`.`rsd_ID`
LEFT JOIN `ref_sex` `sx` ON `sx`.`sex_ID` = `rsd`.`sex_ID`";


if (isset($_REQUEST['class_ID']) || isset($_REQUEST['section_ID'])) {
	$class_ID = $_REQUEST['class_ID'];
	$section_ID = $_REQUEST['section_ID'];
 	$query .= '  WHERE rs.class_ID  = '.$class_ID.' AND rs.section_ID  = '.$section_ID.' AND';

}
else{
	 $query .= ' WHERE';
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(crs_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR rsd_StudNum LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR rsd_FName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR rsd_MName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR rsd_LName LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR sex_Name LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY rsd.rsd_FName DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $room->runQuery($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
$i = 1;
foreach($result as $row)
{
	
		if($row["suffix"] =="N/A")
		{
			$suffix = "";
		}
		else
		{
			$suffix = $row["suffix"];
		}
		if($row["rsd_MName"] ==" " || $row["rsd_MName"] == NULL || empty($row["rsd_MName"]) )
		{
			$mname = " ";
		}
		else
		{
			$mname = $row["rsd_MName"].'. ';
		}
		$sub_array = array();
		$json_obj = "";
		// $json_obj = array();
		if(isset($row["json_score"])){
			 $json_score =  str_replace('&quot;', '"', $row["json_score"]);
			// echo "<pre>";
			$json_obj =json_decode($json_score,true);
		
			if (json_last_error()) {
			    die('Invalid JSON provided!');
			}

			$score = $json_obj["score"]."/".$row["over"];
		}
		else{
			$score = "No Score";
		}
		try {
		    $percent_over = (70 / 100) * $row["over"];
		
		    if($score >= $percent_over){
		    	$remarks = "Passed";
		    	$rmx = "Passed";
		    }
		    else if ($score == "No Score"){
		    	$remarks = "Not Yet Taken";
		    	$rmx = "NotYet";
		    }
		    else{
		    	$remarks = "Failed";
		    	$rmx = "Failed";
		    }

		} catch(DivisionByZeroError $e){
		   $remarks = "Failed";
		}
			catch(ErrorException $e) {
		    $remarks = "Failed";
		}
		if(isset($_REQUEST["filterx"])){
			if($_REQUEST["filterx"] == "All" || $_REQUEST["filterx"] == ""){

				$sub_array[] = $i;
				$sub_array[] = $row["rsd_StudNum"];
				$sub_array[] =  $row["rsd_FName"].' '.$mname.$row["rsd_LName"].' '.$suffix;
				$sub_array[] = $score;
				$sub_array[] = $remarks;
				$i++;
				$data[] = $sub_array;

			}
			if($_REQUEST["filterx"] == $rmx){

				$sub_array[] = $i;
				$sub_array[] = $row["rsd_StudNum"];
				$sub_array[] =  $row["rsd_FName"].' '.$mname.$row["rsd_LName"].' '.$suffix;
				$sub_array[] = $score;
				$sub_array[] = $remarks;
				$i++;
				$data[] = $sub_array;
			}

		}
		
	

		    // <a class="dropdown-item view"  id="'.$row["res_ID"].'">View</a>
		    //  <div class="dropdown-divider"></div>
	
}



$q = "SELECT * FROM `class_room_student`";
$filtered_rec = $room->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
