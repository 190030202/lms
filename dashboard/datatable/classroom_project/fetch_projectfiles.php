<?php
require_once('../class.function.php');
$room = new DTFunction();  		 // Create new connection by passing in your configuration array
session_start();

$query = '';
$output = array();
$query .= "SELECT 
`crs`.`crs_ID`,
`rsd`.`rsd_ID`,
`rsd`.`rsd_StudNum`,
`rsd`.`rsd_FName`,
`rsd`.`rsd_MName`,
`rsd`.`rsd_LName`,
`sn`.`suffix`,
`sx`.`sex_Name`,
`crs`.`status_ID`,
(
    SELECT `crpa`.`attachment_Name` FROM `class_room_project` `crp` 
    LEFT JOIN `class_room_project_attachment` `crpa` ON `crpa`.`proj_ID` = `crp`.`proj_ID`
    WHERE `crp`.`proj_ID` = ".$_REQUEST['proj_ID']." AND `crp`.`section_ID`  = ".$_REQUEST['section_ID']." AND `crpa`.`user_ID` = `rsd`.`user_ID`
) `proj_SubFileName`,
(
    SELECT `crpa`.`attachment_MIME` FROM `class_room_project` `crp` 
    LEFT JOIN `class_room_project_attachment` `crpa` ON `crpa`.`proj_ID` = `crp`.`proj_ID`
    WHERE `crp`.`proj_ID` = ".$_REQUEST['proj_ID']." AND  `crp`.`section_ID`  = ".$_REQUEST['section_ID']." AND `crpa`.`user_ID` = `rsd`.`user_ID` 
) `proj_SubFileMime`,
(
    SELECT `crpa`.`attachment_Data` FROM `class_room_project` `crp` 
    LEFT JOIN `class_room_project_attachment` `crpa` ON `crpa`.`proj_ID` = `crp`.`proj_ID`
    WHERE `crp`.`proj_ID` = ".$_REQUEST['proj_ID']." AND  `crp`.`section_ID`  = ".$_REQUEST['section_ID']." AND `crpa`.`user_ID` = `rsd`.`user_ID` 
) `proj_SubFileData`,
(
    SELECT `crpa`.`attachment_ID` FROM `class_room_project` `crp` 
    LEFT JOIN `class_room_project_attachment` `crpa` ON `crpa`.`proj_ID` = `crp`.`proj_ID`
    WHERE `crp`.`proj_ID` = ".$_REQUEST['proj_ID']." AND  `crp`.`section_ID`  = ".$_REQUEST['section_ID']." AND `crpa`.`user_ID` = `rsd`.`user_ID` 
) `proj_SubFileID`
";

$query .= " FROM `class_room_student` `crs`
LEFT JOIN `record_student_details` `rsd` ON `rsd`.`rsd_ID` = `crs`.`rsd_ID`
LEFT JOIN `ref_suffixname` `sn` ON `sn`.`suffix_ID` = `rsd`.`suffix_ID`
LEFT JOIN `ref_sex` `sx` ON `sx`.`sex_ID` = `rsd`.`sex_ID`

";

if (isset($_REQUEST['classroom_ID']) ||  isset($_REQUEST['section_ID']) ||  isset($_REQUEST['proj_ID'])) {
	$classroom_ID = $_REQUEST['classroom_ID'];
	$section_ID = $_REQUEST['section_ID'];
 	$query .= '  WHERE `crs`.`class_ID` =  '.$classroom_ID.'  AND crs.section_ID  = '.$section_ID.' AND';
 	
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
	$query .= 'ORDER BY rsd_LName ASC ';
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
$xz1d = 1;
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
	
		
		$proj_SubFileName = json_decode($row["proj_SubFileName"]);

		$dl = 'href="data:'.$row["proj_SubFileMime"].';base64,'.base64_encode($row['proj_SubFileData']).'"';
		$dlx = 'data:'.$row["proj_SubFileMime"].';base64,'.base64_encode($row['proj_SubFileData']).'';


		$sub_array[] = $xz1d;
		// $sub_array[] = $row["crs_ID"];
		$sub_array[] = $row["rsd_StudNum"];
		$sub_array[] =  addslashes(ucwords(strtolower(htmlspecialchars($row["rsd_LName"]).', '.$row["rsd_FName"].' '.$mname.' '.$suffix)));
		$sub_array[] = $row["sex_Name"];
		$sub_array[] = $proj_SubFileName[0];
		if($proj_SubFileName[0] == NULL){
			$sub_array[] = '';
		}
		else{
			
		$sub_array[] = '
		<a class="btn btn-outline-success btn-sm "  '.$dl.' download="">Download</a>';
		}
		
		$xz1d++;
		

	$data[] = $sub_array;
}
if (isset($_REQUEST['classroom_ID'])) {
	$classroom_ID = $_REQUEST['classroom_ID'];
 	$q = 'SELECT * FROM `class_room_student`  WHERE `class_ID` =  '.$classroom_ID.' ';
 	
}
else{
	$q = "SELECT * FROM `class_room_student`";
}

$filtered_rec = $room->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
