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

<?php

//if(isset($_POST['_SESSIONsede']) && $_POST['session_code']==_SESSION["code"]){
// print_r($_SESSION);


$db = mysqli_connect("localhost", "root", "mysql", "cbt-db");

//$trade_id = $_POST['TRADE_ID'];
$trade_id = $_GET['type'];


$exp = mysqli_query($db, "SELECT QUESTION_COUNT FROM TRADES WHERE ID=".$trade_id);
$exp_count_row = mysqli_fetch_array($exp);
$expected_question_count = $exp_count_row['QUESTION_COUNT'];

echo "Expected Question: ".$expected_question_count."<br>";

$questions = mysqli_query($db, "SELECT * FROM QUESTION_BANK WHERE TRADE_ID=".$trade_id." AND HIDDEN = 0 ORDER BY RAND() LIMIT ".$expected_question_count);
$question_count = mysqli_num_rows($questions);
echo "Total found : ".$question_count;



if ($question_count < $expected_question_count)
{
  echo " WARNING! Not enough questions!"."<br>";
}

$i = 1;
echo "
<form action='' method='POST' id='quiz'>
<div class='ui celled list'>";
while ($row = mysqli_fetch_array($questions)) { 
  //echo "<p>".$i.") ".$row['ID'].". ".$row['DESCRIPTION']."<br>";
  
  echo "
	<div class='item' style='margin: 20px;'>
                
		<h3 class='ui big blue header'> ".$i.") ".$row['DESCRIPTION']."</h3>
		
		<div class='field' style='margin: 5px;'>	
			<div class='ui radio checkbox'>
				<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-A' value='1'/>
				<label for='question-".$i."-answers-A'>A) ".$row['OPT_A']." </label>
			</div>
		</div>
		
		<div class='field' style='margin: 5px;'>	
			<div class='ui radio checkbox'>
				<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-B' value='2' />
				<label for='question-".$i."-answers-B'>B) ".$row['OPT_B']."</label>
			</div>
		</div>
		
		<div class='field' style='margin: 5px;'>	
			<div class='ui radio checkbox'>
				<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-C' value='3' />
				<label for='question-".$i."-answers-C'>C) ".$row['OPT_C']."</label>
			</div>
		</div>
		
		<div class='field' style='margin: 5px;'>	
			<div class='ui radio checkbox'>
				<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-D' value='4' />
				<label for='question-".$i."-answers-D'>D) ".$row['OPT_D']."</label>
			</div>
		</div>
                
    </div>
  ";
  
  $i++;
}

echo "
	</div>
    <center>
		<button class='ui positive button' style='margin-top: 25px;padding: 15px; width=800px;' type='submit' name='submit'>Submit Quiz</button>
	</center>
";

if(isset($_POST['submit']))
{
	
	$answer1 = $_POST['question-1-answers'];
	$answer2 = $_POST['question-2-answers'];
	$answer3 = $_POST['question-3-answers'];
	$answer4 = $_POST['question-4-answers'];
	$answer5 = $_POST['question-5-answers'];
	echo $answer1;

	$totalCorrect = 0;
	
	while ($row = mysqli_fetch_array($questions)) {
		$i = 1;
		echo "hee";
		$answer = $_POST['question-$i-answers'];
		echo $answer;
		if ($answer == $row['CORRECT_ANS']) { $totalCorrect++; }
		
	}
	//if ($answer1 == "B") { $totalCorrect++; }
	//if ($answer2 == "A") { $totalCorrect++; }
	//if ($answer3 == "C") { $totalCorrect++; }
	//if ($answer4 == "D") { $totalCorrect++; }
	//if ($answer5) { $totalCorrect++; }
	//header('Refresh: 0; URL=http://localhost/cbt');
	echo "<div id='results'>$totalCorrect / 5 correct</div>";
}
?>

	</body>
</html>
