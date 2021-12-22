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
.dropdown
{
	padding:9px;
	border-radius:5px;
	border: solid 1px #ccc;
	width:100%;	
}
</style>
</head>
<body style="font-family:arial,sans-serif; margin: 0px;">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
<script>

function UserAction(){
	var email = document.getElementById('email').value;
	var name = document.getElementById('fname').value;
	var brthdy = document.getElementById('dt').value;
	var brthmnth = document.getElementById('mnth').value;
	var brthyr = document.getElementById('yr').value;
	var adres = document.getElementById('adrs').value;
	var pswd = document.getElementById('pwd').value;
	var repswd = document.getElementById('repwd').value;
	var snino = document.getElementById('snino').value;
	var dob = brthyr+"-"+brthmnth+"-"+brthdy;
	
	document.getElementById('email').style.border= email == "" ? "solid 1px red" : "solid 1px #ccc";
	document.getElementById('fname').style.border= name == "" ? "solid 1px red" : "solid 1px #ccc";
	document.getElementById('dt').style.border= brthdy == 0 ? "solid 1px red" : "solid 1px #ccc";
	document.getElementById('mnth').style.border= brthmnth == 0 ? "solid 1px red" : "solid 1px #ccc";
	document.getElementById('yr').style.border= brthyr == "" ? "solid 1px red" : "solid 1px #ccc";
	document.getElementById('adrs').style.border= adres == "" ? "solid 1px red" : "solid 1px #ccc";
	document.getElementById('pwd').style.border= pswd == "" ? "solid 1px red" : "solid 1px #ccc";
	document.getElementById('repwd').style.border= repswd == "" ? "solid 1px red" : "solid 1px #ccc";
	document.getElementById('snino').style.border= snino == "" ? "solid 1px red" : "solid 1px #ccc";
	
	if(email != "" & name != "" & brthdy != 0 & brthmnth != 0 & brthyr != "" & adres != "" & pswd != "" & repswd != "" & snino != "")
	{
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
		{
			if(snino.length == 16 ){
				if(pswd == repswd){
					if(pswd.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/)){					
						$.ajax({
							url:"http://localhost/e-survey%20tool/api/registerapi.php?reg=1&em="+email+"&nam="+name+"&bday="+dob+"&adres="+adres+"&pwd="+pswd+"&sni="+snino,
							method:"GET",
							dataType:"json",
							cache: false,
							success:function(data){
								if(data.message=="success"){
									window.location.href = 'http://localhost/e-survey%20tool/home.php';
								}
								else{ document.getElementById('errmsg').innerHTML=data.message; }
								
							}
						});
					}
					else{ document.getElementById('errpswd').innerHTML= "Password should contains uppercase,lowercase and number"; }
				}
				else{ document.getElementById('errpswd').innerHTML= "Your Password Mismatched!"; }
			}
			else{ document.getElementById('errsni').innerHTML= "SNI no should be 16-digit"; }
		}
		else
		{
			document.getElementById('erremail').innerHTML= "You have entered an invalid email address!";
		}
	}
}
function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    console.log(`Scan result: ${decodedText}`, decodedResult);
}

var html5QrcodeScanner = new Html5QrcodeScanner(
	"reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>
<?php include 'header.php'; ?>
<br><br>
<div class="form-row">
	<div class="form-col1">
		<img src="images/survey.png" width="100%">
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
	<center><span style="font-size:18px;">User Registration</span></center><br>
		<form method="post">
			<div style="font-size:14px; color:red;" id="errmsg"></div>
			<div style="border: solid 1px #ccc; padding:20px; border-radius:5px;">
				Email ID:<br>
				<input type="email" id="email" class="txtbox"><br>
				<div style="color:red; font-size:12px; height:22px;" id="erremail"></div>
				Full Name:<br>
				<input type="text" id="fname" class="txtbox"><br><br>
				Date Of Birth:<br>
				<table width="100%">
					<tr>
						<td>
							<select id="dt" class="dropdown">
								<option>dd</option>
								<option value="01">01</option>
								<option>02</option>
								<option>03</option>
								<option>04</option>
								<option>05</option>
								<option>06</option>
								<option>07</option>
								<option>08</option>
								<option>09</option>
								<option>10</option>
								<option>11</option>
								<option>12</option>
								<option>13</option>
								<option>14</option>
								<option>15</option>
								<option>16</option>
								<option>17</option>
								<option>18</option>
								<option>19</option>
								<option>20</option>
								<option>21</option>
								<option>22</option>
								<option>23</option>
								<option>24</option>
								<option>25</option>
								<option>26</option>
								<option>27</option>
								<option>28</option>
								<option>29</option>
								<option>30</option>
								<option>31</option>
							</select>
						</td>
						<td>
							&nbsp;/
						</td>
						<td >
							<select id="mnth" class="dropdown">
								<option>mm</option>
								<option>01</option>
								<option>02</option>
								<option>03</option>
								<option>04</option>
								<option>05</option>
								<option>06</option>
								<option>07</option>
								<option>08</option>
								<option>09</option>
								<option>10</option>
								<option>11</option>
								<option>12</option>								
							</select>
						</td>
						<td>
							&nbsp;/
						</td>
						<td>
							<input type="text" id="yr" class="txtbox" placeholder="yyyy">
						</td>
					</tr>
				</table><br>				
				Home Address:<br>
				<input type="text" id="adrs" class="txtbox"><br><br>
				Password:<br>
				<input type="password" id="pwd" class="txtbox"><br>
				<span style="font-size:12px; color:#999;">Atleast One Upper Lower and Number</span>
				<div style="color:red; font-size:12px; height:22px;" id="errpswd"></div>
				Re-Enter Password:<br>
				<input type="password" id="repwd" class="txtbox"><br><br>
				SNI No:<br>
				<input type="text" id="snino" class="txtbox"><br>
				<div style="color:red; font-size:12px; height:22px;" id="errsni"></div>
				<div id="qr-reader" style="width: 600px"></div>
				<input type="button" value="Register" class="btn" onclick="UserAction();"><br><br>
			</div>
		</form>
	</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
