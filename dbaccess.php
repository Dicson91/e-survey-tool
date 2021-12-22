<?php
class dboptions
{	
	function dbinsert($email,$username,$dob,$address,$password,$snino){
		try{
			include 'dbconfig.php';
			$query = $conn->prepare( "SELECT email FROM useraccount WHERE email = :email");
			$query->bindParam(':email', $email );
			$query->execute();
			if($query->rowCount() > 0 ){ echo json_encode(array("message" => "Email already exist!")); }
			else{
				$stmt = $conn->prepare("INSERT INTO useraccount (email, username, dob, address, password, snino ) VALUES (:email, :username, :dob, :address, :password, :snino)");
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':username', $username);
				$stmt->bindParam(':dob', $dob);
				$stmt->bindParam(':address', $address);
				$stmt->bindParam(':password', $password);
				$stmt->bindParam(':snino', $snino);
				$stmt->execute();
				echo json_encode(array("message" => "success"));
			}			
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
	
	function dblogin($email,$password){
		try{
			include 'dbconfig.php';
			$query = $conn->prepare( "SELECT email,uid,password FROM useraccount WHERE email = :email AND password =:psw");
			$query->bindParam(':email', $email );
			$query->bindParam(':psw', $password );
			$query->execute();
			if($query->rowCount() > 0 ){
				$row = $query->fetch(PDO::FETCH_ASSOC);
				//setcookie("usrnm",$row['username'], time() + 7776000);
				echo json_encode(array("message" => "login","usrid" => $row['uid']));
			}
			else{ echo json_encode(array("message" => "Invalid!")); }
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
	
	function dbdelete($id){
		try
		{
			include 'dbconfig.php';
			$stmt = $conn->prepare("DELETE FROM useraccount WHERE uid=?")-> execute([$id]);
			echo "Record Deleted";
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
	
	function db_question_add($quest,$opts){
		try{
			$lstid=0;
			include 'dbconfig.php';
			$stmt = $conn->prepare("INSERT INTO questions_tbl (question) VALUES (:questn)");
			$stmt->bindParam(':questn', $quest);
			$stmt->execute();
			$lstid=$conn->lastInsertId();
			$cnt=0;
			foreach($opts as $op){
				$stmts = $conn->prepare("INSERT INTO options_tbl(qid,options,count) VALUES (:qid,:optns,:cnt)");
				$stmts->bindParam(':qid', $lstid);
				$stmts->bindParam(':optns', $op);
				$stmts->bindParam(':cnt', $cnt);
				$stmts->execute();
			}
			echo json_encode(array("message" => "Added!"));
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
	
	function db_question_all(){
		try{
			$questall=Array();
			include 'dbconfig.php';
			$query = $conn->prepare( "SELECT * FROM questions_tbl WHERE qid NOT IN(SELECT qid FROM userquest WHERE uid=4)");
			$query->execute();
			if($query->rowCount() > 0 ){
				while($row = $query->fetch(PDO::FETCH_ASSOC)){
					$optionsarr=Array();
					$query1 = $conn->prepare( "SELECT optid,options FROM options_tbl WHERE qid='".$row['qid']."'");
					$query1->execute();
					if($query1->rowCount() > 0 ){
						while($row1 = $query1->fetch(PDO::FETCH_ASSOC)){
							$optionsarr []=$row1;
						}
					}
					$questall[]=Array($row,$optionsarr);
				}
			}
			echo json_encode($questall);
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
	
	function db_option_submit($optids,$qid,$uid){
		try{
			include 'dbconfig.php';
			foreach($optids as $ops){
				$stmts = $conn->prepare("UPDATE options_tbl SET count=count+1 WHERE optid=:opts");
				$stmts->bindParam(':opts', $ops);
				$stmts->execute();
			}
			/*foreach($qid as $qi){
				$stmtad = $conn->prepare("INSERT INTO userquest (uid,qid) VALUES (:usrid, :questid)");
				$stmtad->bindParam(':usrid', $uid);
				$stmtad->bindParam(':questid', $qi);
				$stmtad->execute();
			}*/
			foreach($qid as $q){
				$stmtad = $conn->prepare("UPDATE questions_tbl SET response=1 WHERE qid=:questid");				
				$stmtad->bindParam(':questid', $q);
				$stmtad->execute();
			}
			echo json_encode(array("message" => "Submitted!"));
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
	function db_question_update($qid,$qstntxt,$optionarr){
		$cnt=0;
		try{
			include 'dbconfig.php';			
				$stmts = $conn->prepare("UPDATE questions_tbl SET question = :qsn WHERE qid=:qsnid");
				$stmts -> bindParam (':qsn',$qstntxt);
				$stmts -> bindParam (':qsnid',$qid);
				//$stmts->bindParam(':opts', $ops);
				echo count($optionarr);
				//die(123);
				if($qstntxt != ''){
				$stmts->execute();
				}
			for ($i=0; $i< count($optionarr); $i++){
				$stmtad = $conn->prepare("UPDATE options_tbl SET options = :optxt WHERE optid = :opid AND qid = :qsnid");
				$optid = isset($optionarr[$i]) ? $optionarr[$i]:"";
				$i++;
				$opttxt = isset($optionarr[$i]) ? $optionarr[$i]:"";
				$stmtad->bindParam(':opid', $optid);
				$stmtad->bindParam(':optxt', $opttxt);
				$stmtad -> bindParam (':qsnid',$qid);
				//$stmtad->bindParam(':cnt', $cnt);
				if($optid != ''){				
					$stmtad ->execute();					
				}
				else{
					//die(1234);
					$stmtad = $conn->prepare("INSERT INTO options_tbl(qid,options,count) VALUES (:qsnid,:optxt,:cnt)");
					$stmtad -> bindParam (':qsnid',$qid);
					$stmtad->bindParam(':optxt', $opttxt);
					$stmtad->bindParam(':cnt', $cnt);
					$stmtad ->execute();
				}
				//$i++;
			}
			echo json_encode(array("message" => "Updated!"));
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
	function get_question($qsid){
		try{
			include 'dbconfig.php';
			$stmtad = $conn->prepare("SELECT * FROM questions_tbl WHERE qid = '".$qsid."'");			
			$stmtad->execute();
			$result = $stmtad->fetchAll(PDO::FETCH_ASSOC);
			$stmts = $conn->prepare("SELECT optid,options FROM options_tbl WHERE qid='".$qsid."'");
			$stmts->execute();
			$ansresult = $stmts->fetchAll(PDO::FETCH_ASSOC);
				
			
			echo json_encode(array("question" => $result, "answer" => $ansresult));
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
	function delete_question($qsid){
		try{
			include 'dbconfig.php';
			$stmtdelqes = $conn->prepare("DELETE FROM questions_tbl WHERE qid = :qsnid");
			$stmtdelqes -> bindParam (':qsnid',$qsid);
			$stmtdelqes->execute();
			$stmtdelopt = $conn->prepare("DELETE FROM options_tbl WHERE qid = :qsnid");		
			$stmtdelopt -> bindParam (':qsnid',$qsid);
			$stmtdelopt->execute();
			echo "Record Deleted";		
			}
		catch(EXCEPTION $e){ echo "error: ".$e; }	
	}
function db_option_delete($optid){
		try
		{
			include 'dbconfig.php';
			$stmt = $conn->prepare("DELETE FROM options_tbl WHERE optid=?")-> execute([$optid]);
			echo "Record Deleted";
		}
		catch(EXCEPTION $e){ echo "error: ".$e; }
	}
}
?>
  