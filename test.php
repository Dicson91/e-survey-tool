<?php
$questall=Array();
include 'dbconfig.php';
		$optionsarr=Array();
		//
		$query1 = $conn->prepare("SELECT DISTINCT q.question,op.optid,op.options FROM options_tbl op INNER JOIN questions_tbl q ON op.qid=q.qid");
		$query1->execute();
		if($query1->rowCount() > 0 ){
			while($row1 = $query1->fetch(PDO::FETCH_GROUP | PDO::FETCH_ASSOC)){
				$optionsarr []=$row1;
			}
		}
echo json_encode($optionsarr);
//print_r(array($questarr => $optionsarr));
?>