<?php
require_once('../class.function.php');
$student = new DTFunction();  		 // Create new connection by passing in your configuration array


$query = '';
$output = array();
$query .= " 
SELECT  * 
";
$query .= " FROM `ref_section` `rs`";


if (isset($_REQUEST['classroom_ID'])) {
	$classroom_ID = $_REQUEST['classroom_ID'];
 	$query .= '  WHERE `rs`.`class_ID` =  '.$classroom_ID.' AND';
 	
}
else{
	 $query .= ' WHERE';
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(section_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR class_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR section_Name LIKE "%'.$_POST["search"]["value"].'%" )';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY section_ID ASC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $student->runQuery($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	

		$sub_array = array();
	
		
		$sub_array[] = $row["section_ID"];
		$sub_array[] =  $row["section_Name"];
		$sub_array[] = '
		<div class="btn-group" role="group" aria-label="Basic example">
		  <button type="button" class="btn btn-info btn-sm view"  id="'.$row["section_ID"].'">View</button>
		  <button type="button" class="btn btn-primary btn-sm edit"  id="'.$row["section_ID"].'">Edit</button>
		
		</div>
		';
		// <div class="dropdown-divider"></div>
		 // <a class="dropdown-item delete" id="'.$row["rsd_ID"].'">Delete</a>
	$data[] = $sub_array;
}

$q = "SELECT * FROM `ref_section`";
$filtered_rec = $student->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
