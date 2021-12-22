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
	$name = isset($_GET['nam']) ? $_GET['nam'] :"";
	$dob = isset($_GET['bday']) ? $_GET['bday'] :"";
	$address = isset($_GET['adres']) ? $_GET['adres'] :"";
	$pswd = isset($_GET ['pwd']) ? $_GET['pwd'] :"";
	$nino = isset($_GET['sni']) ? $_GET['sni'] :"";
	$db_opt = new dboptions;
	$db_opt -> dbinsert($email,$name,$dob,$address,$pswd,$nino);
}
http_response_code(201);
?>
