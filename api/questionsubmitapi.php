<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$json = file_get_contents("php://input");
$data = json_decode($json);
//print_r($data);
//die('123');
if(isset($_GET['qsub'])){
	include_once '../dbaccess.php';
	$opts=json_decode($_GET['optids']);
	$qid=json_decode($_GET['qid']);
	$uid=$_GET['uid'];
	$db_opt = new dboptions;
	$db_opt -> db_option_submit($opts,$qid,$uid);	
}
if(isset($_GET['qstnupdate'])){
	include_once '../dbaccess.php';
	//$opts=json_decode($_GET['optids']);
	$optionarr = '';
	$optionarr1 = array();	
	$qid= isset($data-> qsnid) ? $data-> qsnid: "";
	$qstntxt= isset($data-> qsntxt) ? $data-> qsntxt: "";
	$optionarr = $data -> anser;	
	foreach ($optionarr as $optarr){
		$optid = isset($optarr -> answerid) ? $optarr -> answerid: "";
		$opttxt = isset($optarr -> answertxt) ? $optarr -> answertxt: "";		
		array_push($optionarr1,$optid,$opttxt);			
	}
	$db_opt = new dboptions;
	//print_r($optionarr1);
	//die(123);
	$db_opt -> db_question_update($qid,$qstntxt,$optionarr1);
}
if(isset($_GET['optdelete'])){
	include_once '../dbaccess.php';
	$optid = $data-> optionid;	
	$db_opt = new dboptions;
	$db_opt -> db_option_delete($optid);	
}
http_response_code(201);
?>