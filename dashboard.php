<html>
<style>
* {
  box-sizing: border-box;
}
</style>
<body style="margin: 0px; font-family: Arial,Sans-serif;">
<?php include 'header.php'; ?>
<br><br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$.ajax({
			url:"http://localhost/e-survey%20tool/api/questionallapi.php?qall=1",
			method:"GET",
			dataType:"json",
			cache: false,
			success:function(data){			
				for(var i=0; i<data.length; i++){
					document.getElementById('tablearea').innerHTML +='<span style="font-size: 14px; font-weight: bold;">'+(i+1)+'.'+data[i][0]['question']+'</span><br><br>';
					//alert(data[i][0]['question']+" ->"+data[i][0]['qid']);
					for(var j=0; j<data[i][1].length; j++)
					{
						document.getElementById('tablearea').innerHTML +='<div style="padding: 4px;"><input type="radio" name="rdo'+i+'[]" value="'+data[i][1][j]['optid']+'" id="rd'+data[i][1][j]['optid']+'" onclick="document.getElementById('+"'txt"+i+"'"+').value='+data[i][1][j]['optid']+'; document.getElementById('+"'qst"+i+"'"+').value='+data[i][0]['qid']+';"><label for="rd'+data[i][1][j]['optid']+'" style="cursor: pointer;">'+data[i][1][j]['options']+'</label></div>';
						
					}
					document.getElementById('tablearea').innerHTML +='<input type="hidden" id="txt'+i+'" name="getopts[]">';
					document.getElementById('tablearea').innerHTML +='<input type="hidden" id="qst'+i+'" name="getquest[]">';
					document.getElementById('tablearea').innerHTML +='<br><hr><br>';
				}
			}
	});
	
	function submt()
	{
		var optarr=document.getElementsByName('getopts[]');
		var arr=[];
		for(var i=0; i<optarr.length; i++){
			if(optarr[i].value !=""){ arr[i]=optarr[i].value; }
		}
		var option = JSON.stringify(arr);
		
		
		var questarr=document.getElementsByName('getquest[]');
		var arr1=[];
		for(var i=0; i<questarr.length; i++){
			if(questarr[i].value !=""){ arr1[i]=questarr[i].value; }
		}
		var quest = JSON.stringify(arr1);
		var ustid="<?php echo $usrid; ?>";
		$.ajax({
			url:"http://localhost/e-survey%20tool/api/questionsubmitapi.php?qsub=1&optids="+option+"&qid="+quest+"&uid="+ustid,
			method:"GET",
			dataType:"json",
			cache: false,
			success:function(data){
				alert(data.message)
			}
		});
	}
</script>
<div style="margin-left: 100px; margin-right: 100px; padding: 40px; border: solid 1px #ccc; border-radius: 4px;">
	<h2>Consultation</h2>
	<hr><br>
	<div id="tablearea"></div>
	<center>
		<input type="button" onclick="submt();" value="Submit" style="padding: 10px; background-color: blue; color: white; cursor: pointer; border-radius: 4px; border: none; width: 200px;">
	</center>
</div>
<br><br>
<?php include 'footer.php'; ?>



</body>
</html>