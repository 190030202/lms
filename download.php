<?php 

require_once("../class.user.php");
$atchfile = new USER();
$attachment_ID = $_REQUEST["attachment_ID"]; 
$sqz = "SELECT * FROM `class_room_attachment` WHERE attachment_ID = $attachment_ID LIMIT 1";
$attchstatement = $atchfile->runQuery($sqz);
$radms = $attchstatement->execute();
$attchresult = $attchstatement->fetchAll();
foreach($attchresult as $row)
{
     $attachment_Data = $row["attachment_Data"];
     $attachment_MIME = $row["attachment_MIME"];
     $attachment_Name = json_decode($row["attachment_Name"]);
}

header('Content-Description: File Description');

header('Content-Type: $attachment_MIME');

header('Content-Disposition: attachment; filename=\''.$attachment_Name[1].'\'');

header('Content-Transfer-Encoding: binary');

header('Expires: 0');

header('Cache-Control: must-revalidate');

readfile($attachment_Data);

exit();
    