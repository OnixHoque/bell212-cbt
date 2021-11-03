<!DOCTYPE html>
<html>

	<head>
	  <title>Bell-212 CBT - Admin Panel</title>
	  <link rel="stylesheet" type="text/css" href="semantic/semantic.min.css">
	  <!-- Standard Meta -->
	  <meta charset="utf-8" />
	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	  
	  <script src="js/jquery/jquery-3.4.1.min.js"></script>
	  <script src="semantic/semantic.min.js"></script>
	  <script src="js/crypto/crypto-core.js"></script>
	  <script src="js/crypto/sha256.js"></script>
	</head>
	
	<body>
	
		<div class="ui top red pointing menu">

			<div class="ui container" style="margin-top: 20px;">
			  <a href="index.html">
				<h2 class="ui header left aligned">
				  <img src="images/bell-logo2.jpg"></img>
				  <div class="content">
					Quiz
					<div class="sub header">Bell-212 CBT Module</div>
				  </div>
				</h2>
			  </a>
			  <!-- <p class="item" style="font-size: 1.20em;">Bell-212 Tutorial</p></p> -->

			</div>
		</div>

<?php

//if(isset($_POST['_SESSIONsede']) && $_POST['session_code']==_SESSION["code"]){
// print_r($_SESSION);


// $db = mysqli_connect("localhost", "root", "mysql", "cbt-db");
$db = mysqli_connect("localhost", "root", "", "cbt-db");

//$trade_id = $_POST['TRADE_ID'];
$trade_id = $_GET['type'];


$exp = mysqli_query($db, "SELECT QUESTION_COUNT FROM TRADES WHERE ID=".$trade_id);
$exp_count_row = mysqli_fetch_array($exp);
$expected_question_count = $exp_count_row['QUESTION_COUNT'];

//echo "Expected Question: ".$expected_question_count."<br>";

$questions = mysqli_query($db, "SELECT * FROM QUESTION_BANK WHERE TRADE_ID=".$trade_id." AND HIDDEN = 0 ORDER BY RAND() LIMIT ".$expected_question_count);
$question_count = mysqli_num_rows($questions);
//echo "Total found : ".$question_count;



if ($question_count < $expected_question_count)
{
  echo " WARNING! Not enough questions!"."<br>";
}

//$trade_name = mysqli_query($db, "SELECT TRADE_NAME FROM TRADES WHERE ID='".$trade_id."'");
//echo $trade_name;
//<h3 class='ui huge blue header'>".$trade_name."</h3>
else{

$i = 1;
echo "
<div class='' style='border-style: inset; margin:2% 20%;'>
<form action='' method='POST' id='quiz' class='ui form' style='padding: 5% 5%'>
	
	<div class='ui celled list'>";
	
$correct_answer = array();
while ($row = mysqli_fetch_array($questions)) { 
  //echo "<p>".$i.") ".$row['ID'].". ".$row['DESCRIPTION']."<br>";
  $correct_answer[$i-1] = $row['CORRECT_ANS'];
  echo "
	<div class='item' style='margin: 20px;'>
                
		<h3 class='ui big blue header'>  ".$row['DESCRIPTION']."</h3>
		
		<div class='field' style='margin: 5px;'>	
			<div class='ui radio checkbox'>
				<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-A' value='1'/>
				<label for='question-".$i."-answers-A'> ".$row['OPT_A']." </label>
			</div>
		</div>
		
		<div class='field' style='margin: 5px;'>	
			<div class='ui radio checkbox'>
				<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-B' value='2' />
				<label for='question-".$i."-answers-B'> ".$row['OPT_B']."</label>
			</div>
		</div>
		
		<div class='field' style='margin: 5px;'>	
			<div class='ui radio checkbox'>
				<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-C' value='3' />
				<label for='question-".$i."-answers-C'> ".$row['OPT_C']."</label>
			</div>
		</div>
		
		<div class='field' style='margin: 5px;'>	
			<div class='ui radio checkbox'>
				<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-D' value='4' />
				<label for='question-".$i."-answers-D'> ".$row['OPT_D']."</label>
			</div>
		</div>
                
    </div>
  ";
  
  $i++;
}

echo "
	
    <center>
		<button class='ui positive button' style='margin: 20px;padding: 15px; width=800px;' type='submit' name='submit' id='submit_button'>Submit Answers</button>
	</center>
	</div>
	</form>
</div>
";


$totalCorrect = 0;
$totalWrong = 0;

if(isset($_POST['submit']))
{
	$answer = array();
	for($i=0; $i< $question_count; $i=$i+1)
	{
		$index = "question-" . ($i+1) . "-answers";
		$answer[$i] = $_POST[$index];
	}

	$totalCorrect = 0;
	
	for ($j = 0; $j < $question_count; $j+=1) {
		//echo "$correct_answer[$j]"; 
		//echo "$answer[$j]"; 
		if ($correct_answer[$j] == $answer[$j]) { $totalCorrect++; }

	}
	$totalWrong=5-$totalCorrect; 

	//echo "<div id='results'>$totalCorrect / 5 correct</div>";
	echo "<script type='text/javascript'>
		  $(document).ready(function(){
		  $('#score_board').modal('show');
		});
		</script>";
	
}
echo "

	<div class='ui modal' id='score_board'>
			<!-- <i class='close icon'></i> -->

			<div class='header' style='text-align: center;'>Quiz Score</div>
			  
			<div class='results' style='margin:10px; padding:10px'>
				<p>Total questions: $expected_question_count</p>
				<p>Correct answer : $totalCorrect</p>
				<p>Wrong answer   : $totalWrong</p>
			</div>		  

		<div class='' style='display: none;border-top: 1px solid lightgrey;' id='savediv'>
			<form class='ui form' method='POST' style='margin:10px; padding:10px;'>
			
				<div class='required field column'>
					<label>Enter Name</label>
					<div class='ui input focus' style='width:100%'>
						<input type='text' id='' name='name'
							style='' class='form-control' placeholder='Name'>
					</div>
				</div>
				
				<div class='ui two column grid'>
					<div class='required field column'>
						<label>BAF ID</label>
						<div class='ui input focus' style=''>
							<input type='text' id='' name='op1'
									style='' class='form-control' placeholder='ID'>
						</div>
					</div>
			  
					<div class='required field column'>
						<label>Rank</label>
						<div class='ui input focus' style=''>
							<input type='text' id='' name='op2'
									style='' class='form-control' placeholder='rank'>
						</div>
					</div>		
				</div>
			</form>  
				<div class='' style='border-top: 1px solid lightgrey' id=''>
					<div class='ui positive button left floated' id='update' style='margin: 10px;'>Update</div>
					<div class='ui basic deny button right floated' id='' style='margin: 10px;'>Cancel</div>
				</div>
		</div>
		
		<div class='' style='border-top: 1px groove' id='prevdiv'>
			<div class='ui positive button left floated' id='save' style='margin: 10px;'>Save</div>
			<div class='ui basic deny button right floated' id='cancel' style='margin: 10px;'>Cancel</div>
		</div>
	</div>

	";

}

?>

<script type="text/javascript">
    document.getElementById("cancel").onclick = function () {
        location.href = "http://localhost/cbt/";
    };
	
	document.getElementById("save").onclick = function () {
        document.getElementById("savediv").style.display = "block";
		document.getElementById("save").innerHTML  = "Update";
		document.getElementById("prevdiv").style.display  = "none";
    };
	
</script>



	</body>
</html>
