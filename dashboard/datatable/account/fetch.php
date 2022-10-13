<?php
require_once('../class.function.php');
$student = new DTFunction();  		 // Create new connection by passing in your configuration array


$query = '';
$output = array();
$query .= " 
SELECT 
*,
(case  
 
when (ua.lvl_ID = 1) 
then (SELECT UPPER(CONCAT(rsd.rsd_LName,', ',rsd.rsd_FName,' ',RIGHT(rsd.rsd_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_student_details rsd 
	  LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = rsd.suffix_ID
      WHERE rsd.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 2)  
then (SELECT UPPER(CONCAT(rid.rid_LName,', ',rid.rid_FName,' ',RIGHT(rid.rid_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_instructor_details rid 
	  LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = rid.suffix_ID
      WHERE rid.user_ID = ua.user_ID)
 
when (ua.lvl_ID = 3)  
then (SELECT UPPER(CONCAT(rad.rad_LName,', ',rad.rad_FName,' ',RIGHT(rad.rad_MName,1),'. ',
                          
                          (SELECT IF(rsn.suffix = 'NA',rsn.suffix,''))
                         
                         )) 
      FROM record_admin_details rad 
	  LEFT JOIN ref_suffixname rsn  ON rsn.suffix_ID = rad.suffix_ID
      WHERE rad.user_ID = ua.user_ID
     )
 
end)  fullname


";
$query .= " FROM `user_account`ua
LEFT JOIN `user_level` `ul` ON `ul`.`lvl_ID` = `ua`.`lvl_ID`";
if($_POST["length"] != -1)
{

 $query .= 'WHERE ua.lvl_ID  = "'.$_POST["length"].'" AND ';
}
else{

 $query .= 'WHERE   ';
}
if(isset($_POST["search"]["value"]))
{
 $query .= '( user_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR user_Name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR lvl_Name LIKE "%'.$_POST["search"]["value"].'%" )';
    
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY user_ID DESC ';
}


$statement = $student->runQuery($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	


	$sub_array = array();
	
		
		$sub_array[] = $row["user_ID"];
		$sub_array[] =  addslashes(ucwords(strtolower(htmlspecialchars($row["fullname"]))));
		$sub_array[] =  $row["user_Name"];
		$sub_array[] =  $row["lvl_Name"];
		$sub_array[] =  $row["user_Registered"];
		$sub_array[] = '
		<div class="btn-group" role="group" aria-label="Basic example">
		  <button type="button" class="btn btn-outline-primary btn-sm change"    id="'.$row["user_ID"].'">Change Pass</button>
		</div>
		';
		// <div class="dropdown-divider"></div>
		 // <a class="dropdown-item delete" id="'.$row["rad_ID"].'">Delete</a>
	$data[] = $sub_array;
}

$q = "SELECT * FROM `user_account`";
$filtered_rec = $student->get_total_all_records($q);

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	$filtered_rec,
	"data"				=>	$data
);
echo json_encode($output);



?>



        
