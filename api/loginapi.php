<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if(isset($_GET['reg'])){
	include_once '../dbaccess.php';
	$email = isset($_GET['em']) ? $_GET['em'] :"";
	$pswd = isset($_GET ['pwd']) ? $_GET['pwd'] :"";
	$db_opt = new dboptions;
	$db_opt -> dblogin($email,$pswd);
}
http_response_code(201);
?>
