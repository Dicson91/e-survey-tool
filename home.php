<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}
.form-col1 {
  float: left;
  width: 60%;
  padding-left: 40px;
  padding-right: 40px;
  
}
.form-col2 {
  float: left;
  width: 40%;
  padding-left: 40px;
  padding-right: 40px;
  border-left: solid 1px #ccc;
}

.form-row:after {
  content: "";
  display: table;
  clear: both;
}
.btn
{
	border: solid 1px #ccc;
	border-radius: 5px;
	background-color: blue;
	color: white;
	padding: 10px;
	width: 100%;
	cursor: pointer;
	font-weight:bold;
	font-size:16px;
}
.txtbox
{
	width:100%;
	padding:10px;
	border-radius:5px;
	border: solid 1px #ccc;
}
</style>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function loginvalid(){
	var userid = document.getElementById('userid').value;
	var paswd = document.getElementById('pwd').value;
	if(userid != "" & paswd !="")
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(userid))
		{
			$.ajax({
				url:"http://localhost/e-survey%20tool/api/loginapi.php?reg=1&em="+userid+"&pwd="+paswd,
				method:"GET",
				dataType:"json",
				cache: false,
				success:function(data){
					if(data.message=="login"){
					
					var now = new Date();
					var time = now.getTime();
					var expireTime = time + 1000*36000;
					now.setTime(expireTime);
					document.cookie = 'uid='+data.usrid+';expires='+now.toUTCString()+';path=/';
					
						window.location.href = 'http://localhost/e-survey%20tool/dashboard.php?u='+data.usrid;
					}
					else{ document.getElementById('errmsg').innerHTML=data.message; }
				}
			});
		}
		else
		{
			alert("You have entered an invalid email address!");
		}
		//document.getElementById('myform').submit();
	}
	else if(userid == "" & paswd !="")
	{
		document.getElementById('userid').style.border="solid 1px red";
		document.getElementById('pwd').style.border="solid 1px #ccc";
		document.getElementById('erruser').innerHTML ="Enter the user id";
	}
	else if(userid != "" & paswd =="")
	{
		document.getElementById('userid').style.border="solid 1px #ccc";
		document.getElementById('pwd').style.border="solid 1px red";
		document.getElementById('errpswd').innerHTML ="Enter the Password";
	}
	else if(userid == "" & paswd =="")
	{
		document.getElementById('userid').style.border="solid 1px red";
		document.getElementById('pwd').style.border="solid 1px red";
		document.getElementById('erruser').innerHTML ="Enter the user id";
		document.getElementById('errpswd').innerHTML ="Enter the Password";
	}
}

</script>
<body style="font-family:arial,sans-serif; margin: 0px;">
<?php include 'header.php'; ?>
<br><br>
<div class="form-row">
	<div class="form-col1">
		<!-- <img src="images/survey.png" width="100%">-->
		<br>
		<p>
			Climate change and global warming affect all regions around the world, and the Valley of Shangri-La is not
			an exception. Shangri-La City Council has committed to reducing greenhouse gas emissions such as CO2 and
			N2O from transport. It plans to introduce SLEZ (Shangri-L Low Emission Zone) to the city by the end of 2022
			and install more electric vehicle charging stations.
			The Shangri-La City Council has decided to open public consultation on its plans to implement SLEZ, and the
			residents are being asked to offer their opinions on the detail and the proposed boundaries of SLEZ.
		</p>
	</div>
	<div class="form-col2">
		<form id="myform">
			<div style="border: solid 1px #ccc; padding:20px; border-radius:5px;">
				User ID:<br>
				<input type="text" id="userid" class="txtbox"><br>
				<div style="color:red; font-size:12px; height:20px;" id="erruser"></div>
				Password:<br>
				<input type="password" id="pwd"  class="txtbox"><br>
				<div style="color:red; font-size:12px; height:20px;" id="errpswd"></div>
				<input type="button" value="Sing In" class="btn" onclick="loginvalid();"><br><br>
				<span style="font-size:12px;">If you are a new user please </span> <a href="" style="font-size:12px;">Register</a><span style="font-size:12px;"> here </span>
			</div>
		</form>
	</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>