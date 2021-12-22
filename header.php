<style>
.head-col1 {
  float: left;
  width: 60%;
  padding: 5px;
}
.head-col2 {
  float: left;
  width: 40%;
  padding: 10px;
  text-align: right;  
}
.head-row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
<?php
$usrid=isset($_COOKIE["uid"]) ? $_COOKIE["uid"] : 0;
?>
<div style="background-color: red;">
	<div class="head-row">
		<div class="head-col1">
			<h1 style="margin:0px; padding:0px; color:white;font-size:50px;">E-Survey</h1>
		</div>
		<div class="head-col2">			
			<p>
				<span style="color: white;">Hello, <?php echo $usrid; ?></span>
				<a href="#" style="text-decoration:none; color:white; font-weight:bold;">Logout</a>
			</p>
		</div>
	</div>
</div>