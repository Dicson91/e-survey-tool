<html>
<head>
<style>
* {
  box-sizing: border-box;
}
.tbl{
	width: 50%;
}

</style>
</head>
<body style="margin: 0px; font-family: Arial,Sans-serif;">
<?php include 'header.php'; ?>
<br><br>
<div class="content"><span id="errmes" style="color: red; font-size: 14px;"></span><br>
	<div style="padding: 10px; border-bottom: solid 1px #ccc;">
		<br>
		<table class="tbl">
			<tr>
				<td>
				Question:
				</td>
			</tr>
			<tr>
				<td><input type="text" id="quest" style="width: 100%; padding: 6px; border: solid 1px #ccc; border-radius: 4px;" /></td>
				<td style="width: 60px;"><input type="button" value="Add" name="add" onclick="addition();" style="cursor: pointer; padding: 6px; border: solid 1px #ccc;" /></td>
			</tr>
			<tr>
				<td>
				No.Of Options:
				</td>
			</tr>
			<tr>
				<td>
					<select id="optcnt" style="width: 100%; padding: 6px; border: solid 1px #ccc; border-radius: 4px;" onclick ="optcnt();">
						<option>Select</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>						
					</select>	
				
			</tr>
			<tr>
				<td id="createopts" style="width: 100%; padding: 6px;">
				</td>
			</tr>
		</table>
		
		<input type="button" value="test" onclick="updatequest(45,"felix");">
		
		<div id="sucsmsg" style="display: none; border: solid 1px #ccc; border-radius: 4px; padding: 10px; background color: green; color: white;"> Question added! </div>
	</div>
	<input type="button" onclick="questionsload();" value="Show">
	
	<div id="createopts"></div>
	<div id="tablearea"></div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
	function addition()
	{
		var qust=document.getElementById("quest").value;
		
		var optarr=document.getElementsByName('optns[]');
		var arr=[];
		for(var i=0; i<optarr.length; i++){ arr[i]=optarr[i].value; }
		var option = JSON.stringify(arr);
		if(qust !=""){
			$.ajax({
				url:"http://localhost/e-survey%20tool/api/questionsapi.php?qadd=1&qust="+qust+"&opts="+option,
				method:"GET",
				dataType:"json",
				cache: false,
				success:function(data){
					alert(data.message);
				}
			});
		}
		else{ document.getElementById("errmes").innerHTML="Please enter the Question!"; }
		
	}
	function questionsload(){
	
		$.ajax({
			url:"http://localhost/e-survey%20tool/api/questionallapi.php?qall=1",
			method:"GET",
			dataType:"json",
			cache: false,
			success:function(data){			
				for(var i=0; i<data.length; i++){
					document.getElementById('tablearea').innerHTML +='<input type="text" value="'+data[i][0]['question']+'" id="txt'+i+'"><input type="button" value="update" onclick="updatequest('+"'"+"txt"+i+"'"+","+data[i][0]['qid']+');"><br><br>';
					//alert(data[i][0]['question']+" ->"+data[i][0]['qid']);
					for(var j=0; j<data[i][1].length; j++)
					{
						document.getElementById('tablearea').innerHTML +='<div style="padding: 4px;"><input type="text" value="'+data[i][1][j]['options']+'" id="opt'+i+'"><input type="button" value="update" onclick="updateopt('+"'"+"opt"+i+"'"+","+data[i][1][j]['optid']+');"></div>';
						
					}
					document.getElementById('tablearea').innerHTML +='<br><hr><br>';
				}
			}
	});
	}
	questionsload();
	function optcnt(){
		var cnt = document.getElementById('optcnt').value;
		var htmlstr="";
		for(var i=1; i<=cnt; i++){
			htmlstr +='Option '+i+': <input type="text" name="optns[]" style="width:100%; padding:6px;"><br><br>';
		}
		document.getElementById('createopts').innerHTML=htmlstr;
	}
	
	
	function updatequest(ss,v)
	{
		alert(document.getElementById(ss).value+v);
	
	}
	function updateopt(optns,opid)
	{
		alert(document.getElementById(optns).value+opid);
	}
	</script>

<br><br>



<?php include 'footer.php'; ?>
</body>
</html>