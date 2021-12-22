<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if(isset($_GET['qall'])){
	include_once '../dbaccess.php';
	$db_opt = new dboptions;
	$db_opt ->db_question_all();
}
if(isset($_GET['qupdate'])){
	include_once '../dbaccess.php';
	$qsid = isset($_GET['qid']) ? $_GET['qid'] :"";
	$db_opt = new dboptions;
	$db_opt ->get_question($qsid);
}
if(isset($_GET['qesdelete'])){
	include_once '../dbaccess.php';
	$qsid = isset($_GET['qid']) ? $_GET['qid'] :"";
	$db_opt = new dboptions;
	$db_opt ->delete_question($qsid);
}
http_response_code(201);
?>