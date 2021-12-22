<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['qadd'])){
	include_once '../dbaccess.php';
	$quest = isset($_GET['qust']) ? $_GET['qust'] :"";
	$opts=json_decode($_GET['opts']);
	$db_opt = new dboptions;
	$db_opt -> db_question_add($quest,$opts);
}
http_response_code(201);
?>