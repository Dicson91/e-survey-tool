<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>
* {
  box-sizing: border-box;
}
.tbl{
	width: 50%;
}
.material-icons {
	vertical-align:-20%;
	cursor: pointer;
	}

</style>
</head>
<body style="margin: 0px; font-family: Arial,Sans-serif;">
<?php include 'header.php'; ?>
<br>
<div style="font-weight:bold; padding:6px">Questions</div>
	

<br>

	
	<div id="createopts"></div>
	<div id="tablearea"></div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update</h4>
      </div>	  
      <div class="modal-body">
			<div class="modal-body">
				Question:<br>
				<div id="questionarea">
				</div>
				Options:<br>
				<div id="answerarea">				
				</div>
				<div id="optionaddarea">				
				</div>
				<div style="padding:4px;">
					<input type="button" value="ADD OPTION" class="btn btn-default" id="addoption">
				</div>
        
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="reloadpage()">Close</button>
        <button type="button" class="btn btn-primary" onclick="updqusans()">Save changes</button>
      </div>
    </div>
	
	
  </div>
</div>


<?php include 'footer.php'; ?>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script>
function questionsload(){
	
		$.ajax({
			url:"http://localhost/e-survey%20tool/api/questionallapi.php?qall=1",
			method:"GET",
			dataType:"json",
			cache: false,
			success:function(data){	
				let htmlData = '';			
				for(var i=0; i<data.length; i++){					
					var resp = data[i][0]['response'];					
					htmlData += '<div style="padding:4px;">';
					htmlData += '<input type="hidden" value="'+data[i][0]['qid']+'" id="txt'+i+'">';					
					htmlData += '<h3>'+data[i][0]['question']+'</h3>';
					if(resp == 0)
					{
						htmlData += '<button onclick="editqus('+data[i][0]['qid']+')" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Edit</button>&nbsp;&nbsp;&nbsp;';
						htmlData += '<button onclick="delequs('+data[i][0]['qid']+')" class="btn btn-primary btn-lg">Delete</button></div>';
					}
					else
					{
						htmlData += '<button  class="btn btn-danger btn-lg disabeledit"  data-toggle="tooltip" data-placement="top" title="Already you got a response">Edit</button>&nbsp;&nbsp;&nbsp;';
						htmlData += '<button  class="btn btn-danger btn-lg disabeledit" data-toggle="tooltip" data-placement="top" title="Already you got a response">Delete</button></div>';
					}					
						document.getElementById('tablearea').innerHTML = htmlData;
						document.getElementById('tablearea').innerHTML +='<br><hr><br>';
						
						var tab = document.getElementById('tablearea');
						tab.addEventListener('DOMNodeInserted', function( event ) {
							$('.disabeledit').tooltip()
						}, false);
					
				}
			}
	});
	}
	questionsload();
	function editqus(qstnid) {
		$.ajax({
			url:"http://localhost/e-survey%20tool/api/questionallapi.php?qupdate=1&qid="+qstnid,
			method:"GET",
			dataType:"json",
			cache: false,
			success:function(data){	
			
				let htmlData = '';
				var htmlData1 = '';
					
					
					htmlData += '<div style="padding:4px;">';
					htmlData += '<input type="hidden" id="question" value="'+data['question'][0]['qid']+'">';
					htmlData += '<input type="text" data-prvquestion="'+data['question'][0]['question']+'" value="'+data['question'][0]['question']+'" id="questiontxt" style="padding:6px; width:100%;">';
					
					document.getElementById('questionarea').innerHTML = htmlData;
					
					for(var j=0; j<data.answer.length; j++)
					{
						
						htmlData1 += '<div style="padding: 4px;">';
						
						htmlData1 += '<input type="text" name="answer" data-ansid="'+data['answer'][j]['optid']+'" data-preve="'+data['answer'][j]['options']+'" value="'+data['answer'][j]['options']+'" id="'+data['answer'][j]['optid']+'" style="padding:6px; width:80%;">&nbsp;&nbsp;<i class="material-icons" id="'+data['answer'][j]['optid']+'" onclick="deleteopt(this)">delete</i></div>';
					}					
					document.getElementById('answerarea').innerHTML = htmlData1;
			}
	});
	}
	questionsload();
	function updqusans(){
		var questiondata = {};
		var qstnid = document.getElementById('question').value;
		var qstntxt = document.getElementById('questiontxt').value;
		var getquestion = document.getElementById('questiontxt').dataset.prvquestion;
		questiondata.qsnid=qstnid;
		if(qstntxt != getquestion){
			
			questiondata.qsntxt=qstntxt;
		}
		var getanswer = document.getElementsByName('answer');
		var ansarr = [];
		for(var i=0; i<getanswer.length; i++){
			var ansid = getanswer[i].dataset.ansid;
			var prvanstxt = getanswer[i].dataset.preve;
			var anstxt = getanswer[i].value;			
			if(prvanstxt != anstxt){
				ansarr.push({
				answerid: ansid,
				answertxt: anstxt
				})
			}
			
		}
		
		questiondata.anser = ansarr;	
	$.ajax({
			url:"http://localhost/e-survey%20tool/api/questionsubmitapi.php?qstnupdate=1",
			method:"POST",
			dataType:"json",
			cache: false,
			data: JSON.stringify(questiondata),
			success:function(data){	
				console.log(data)	
			}	
		})
		location.replace("http://localhost/e-survey%20tool/displayquestions.php")
	}
	
	$(document).ready(function(){
	$("#addoption").click(function(){
    $("#optionaddarea").append('<div style="padding:4px"><input type="text" name="answer" style="padding:6px; width:80%;">&nbsp;&nbsp;<i class="material-icons"  onclick="deleteopt(this)">delete</i></div>');
	
	
  });
  
});
	function deleteopt(elm){
		var optionid = {'optionid': $(elm).attr('id')};
		$(elm).parent().remove();
		$.ajax({
			url:"http://localhost/e-survey%20tool/api/questionsubmitapi.php?optdelete=1",
			method:"POST",
			dataType:"json",
			cache: false,
			data: JSON.stringify(optionid),
			success:function(data){	
				console.log(data)	
			}	
		})
	}
	function delequs(qsid){
		$.ajax({
			url:"http://localhost/e-survey%20tool/api/questionallapi.php?qesdelete=1&qid="+qsid,
			method:"GET",
			dataType:"json",
			cache: false,
			success:function(data){
				console.log(data)
			}
		})
	}
	function reloadpage(){
		location.reload();
	}
	$(function () {
	
})
</script>
</body>
</html>