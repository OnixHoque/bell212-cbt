
<!DOCTYPE html>
<html>

<head>
  <title>Bell-212 CBT System</title>
  <link rel="stylesheet" type="text/css" href="semantic/datatables/dataTables.semanticui.min.css">
  <link rel="stylesheet" type="text/css" href="semantic/semantic.min.css">
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <script src="js/jquery/jquery-3.3.1.js"></script>
    <script src="js/datatables/jquery.dataTables.min.js"></script>
  <script src="js/datatables/dataTables.semanticui.min.js"></script>

<script src="semantic/semantic.min.js"></script>

  <!-- For showing alert 
  <script type="text/javascript" src="Jquery/Jquery3.js"></script>
  <script type="text/javascript" src="semantic-ui/semanticui.js"></script>
  <script type="text/javascript" src="Semantic-UI-Alert/Semantic-UI-Alert.js"></script>
  <link rel="stylesheet" type="text/css" href="semantic-ui/semanticui.css">
  <link rel="stylesheet" type="text/css" href="Semantic-UI-Alert/Semantic-UI-Alert.css"> -->


  <style>
  * {
    font-family: "Open Sans Regular";
    font-size: 1.01em;
  }

  .ui .button {
    font-family: "Open Sans Regular";

    font-size: 1.01em;
  }
  
  body {
    overflow: auto;
  }
  </style>

</head>

<body>


  <div class="ui top red pointing menu">

    <div class="ui container" style="padding-left: 70px;">
      <a href="admin_panel.php">
        <h2 class="ui header left aligned">
          <img src="images/bell-logo2.jpg"></img>
          <div class="content">
            Bell-212
            <div class="sub header">CBT Question Bank</div>
          </div>
        </h2>
      </a>
      <!-- <p class="item" style="font-size: 1.20em;">Bell-212 Tutorial</p></p> -->

    </div>
  </div>
  
		<button class="ui button green" id="addQuestionButton"
				style="margin-top: 10px;margin-bottom: 10px;padding: 15px; margin-left:15%" >
				<i class="add icon"></i>Add Question
				
		</button>

  <!-- <div class="ui segment"> -->
  <div class="ui grid">
    <div class="stretched row" style="height: 100vh; padding-left: 15%; padding-right: 15%;">
      <div class="column">
        <table id="example" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th style="width:70%">Question Title</th>
                <th style="text-align:center">Edit</th>
                <th style="text-align:center">Delete</th>
            </tr>
        </thead>
        <tbody>
		<?php
			// $db = mysqli_connect("localhost", "root", "mysql", "cbt-db");
			$db = mysqli_connect("localhost", "root", "", "cbt-db");

			$trade_id = $_GET['type'];
			
			
			$questions = mysqli_query($db, "SELECT * FROM QUESTION_BANK WHERE TRADE_ID=".$trade_id." AND HIDDEN = 0");
			$question_count = mysqli_num_rows($questions);
			
			
			while ($row = mysqli_fetch_array($questions)) { 
				echo "<tr>
							<td>".$row['DESCRIPTION']."</td>
							<td style='text-align:center'>
								<button class='mini ui button blue'
									id='edit".$row['ID']."'
									onclick = 'showUpdateModal(".$row['ID'].")'
									style=''
									type='edit' 
									name='edit'>
									Edit
								</button>
							</td>
							
							<td style='text-align:center'>
								<button class='mini ui button red'
									id='delete".$row['ID']."'
									style=''
									type='delete' 
									name='delete'>
									Delete
								</button>
								
							</td>
					</tr>";
			}
		?>
			<!--
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
            </tr>
			-->
        </tbody>
    </table>

      <!-- </div> -->
      </div>
</div>
</div>


<div class="ui modal" id="addQuestion">
<!-- <i class="close icon"></i> -->

  <div class="header" style="text-align: center;">
    Add Quiz Question
  </div>
<form class="ui form" method="POST">
  <div class="ui basic text segment" style="margin: 20px;">
	
	<div class="required field">
		<label>Paste Question</label>
		<textarea rows="2" class="form-control" id="ques" name="ques" ></textarea>
	</div>

	
	<div class="ui two column grid">
		<div class=" required field column">
			<label>Option 1</label>
			<div class="ui input focus" style="">
				<input type="text" id="op1" name="op1" 
						style="" class="form-control" placeholder="Paste Option 1">
			</div>
		</div>
	  
		<div class=" required field column">
			<label>Option 2</label>
			<div class="ui input focus" style="">
				<input type="text" id="op2" name="op2" 
						style="" class="form-control" placeholder="Paste Option 2">
			</div>
		</div>
	  
		<div class=" required field column">
			<label>Option 3</label>
			<div class="ui input focus" style="">
				<input type="text" id="op3" name="op3" 
						style="" class="form-control" placeholder="Paste Option 3">
			</div>
		</div>
	  
		<div class="required field column">
			<label>Option 4</label>
			<div class="ui input focus" style="">
				<input type="text" id="op4" name="op4" 
						style="" class="form-control" placeholder="Paste Option 4">
			</div>
		</div>
		
		<div class="required field eight wide">
			<label>Correct Answer</label>
			<select class="ui dropdown" name="ans">
				<option value="1">One</option>
				<option value="2">Two</option>
				<option value="3">Three</option>
				<option value="4">Four</option>
			</select>
		</div>
		
		<div class="required field eight wide">
			<label>Question Module</label>
			<select class="ui dropdown" name="type">
				<option value="1">Engine</option>
				<option value="2">Airframe</option>
				<option value="3">Electic Components</option>
				<option value="4">Instruments</option>
				<option value="5">Radio</option>
				<option value="6">Armaments</option>
			</select>
		</div>
		
	</div>
	<center>
		<button class="ui button red" 
				style="margin-top: 25px;padding: 15px;" 
				type="submit" 
				name="submit">
				<i class="add icon"></i>Create Question
				
		</button>
	</center>
	
  </div>
</form>
  
	
	<div class="actions">
		<div class="ui basic deny button">Cancel</div>
	</div>
</div>


<?php
 
if(isset($_POST['submit']))
{
	$ques = $_POST['ques'];
	$op1 = $_POST['op1'];
	$op2 = $_POST['op2'];
	$op3 = $_POST['op3'];
	$op4 = $_POST['op4'];
	$ans = $_POST['ans'];
	$tradeid = $_POST['type'];
	 
	if($ques!="" && $op1!="" && $op2!="" && $op3!="" && $op4!="" && $ans!="" && $tradeid!="")
	{
		$query = "INSERT INTO QUESTION_BANK (TRADE_ID,DESCRIPTION,OPT_A,OPT_B,OPT_C,OPT_D,CORRECT_ANS,HIDDEN)
		VALUES ('$tradeid','$ques','$op1','$op2','$op3','$op4','$ans','0')";
		$data = mysqli_query($db, $query);
		
		if($data)
		{
			//echo "Data inserted into database";
			
			echo"
			<div class='ui success message transition'>
				<i class='close icon'></i>
				<div class='header'>Data inserted successfully.</div>
			</div>";
		}
	}
	else
	{
		//echo "All fields are required.";
		
		echo"
			<div class='ui warning message transition ' >
				<i class='close icon'></i>
				<div class='header'>All fields are required.</div>
			</div>";
	}
}
?>

<script>

$(document).ready(function() {
    $('#example').DataTable();
} );

  $('#addQuestionButton').click(function(){
  $('#addQuestion').modal('show');
});

$('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
;

</script>

<script src="modifyQuizQues.js"></script>

</body>

</html>
