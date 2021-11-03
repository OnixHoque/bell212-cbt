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

		<div class="ui tiny modal" id="successModal">
		<!-- <i class="close icon"></i> -->
			<i class="close icon" id="SuccessMessageClose"></i>
		  	<div class="ui positive message" style="margin: 1%" >
		  		<div class="header">
		   			Success! 
		  		</div>
		  		<p >Your score has been successfully added in the leaderboard!</p>
		  	</div>
		</div>

		<div class="ui tiny modal" id="failedModal">
		<!-- <i class="close icon"></i> -->
			<i class="close icon" id="failMessageClose"></i>
		  	<div class="ui negative message" style="margin: 1%" >
		  		<div class="header">
		   			Failed! 
		  		</div>
		  		<p >All fields are required!</p>
		  	</div>
		</div>

<?php

#*************************************CONNECTING THE SERVER STARTS************************************
#Defining the database connection variables
$serverName="127.0.0.1";
$username="root";
$password="";
$dbName="cbt-db";

#Creating the Connection
try{
    $pdo=new PDO ("mysql:host=$serverName; port=3306 ;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "Succussfully connected to the database<br>";
}catch (PDOException $exception){
    echo "@@@@Got this error in connection" . $exception->getMessage() . "\n"; 
}
#*************************************CONNECTING THE SERVER ENDS************************************
#$db = mysqli_connect("localhost", "root", "mysql", "cbt-db");


#****************DETERMINING THE EXPECTED NO OF QUESTIONS FOR THIS TRADE STARTS *****************
#trade id is specifying which trade is in consideration
$trade_id = $_GET['type'];
//global counter
# This global counter will be used to keep track of the number of correct answers
$totalCorrect = 0;
# This global counter will be used to keep track of the number of wrong answers
$totalWrong = 0;


$sql = "SELECT QUESTION_COUNT FROM TRADES WHERE ID=".$trade_id;
$stmt= $pdo->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$expected_question_count = $row['QUESTION_COUNT'];
#****************DETERMINING THE EXPECTED NO OF QUESTIONS FOR THIS TRADE ENDS *****************

#****************COLLECTING QUESTIONS FOR THIS TRADE STARTS *****************
# query for getting the questions for this trade
$sql ="SELECT * FROM QUESTION_BANK WHERE TRADE_ID=".$trade_id." AND HIDDEN = 0 ORDER BY RAND() LIMIT ".$expected_question_count;
$stmt= $pdo->prepare($sql);
$stmt->execute();

# Getting the count about how many questions have been returned by the query
$question_count = $stmt->rowCount();


#****************COLLECTING QUESTIONS FOR THIS TRADE ENDS *****************
echo "question count=".$question_count;
echo "expected question count=".$expected_question_count;
if ($question_count < $expected_question_count)
{
  //echo " WARNING! Not enough questions!"."<br>";
}

else{
	//echo "THERE ARE ENOUGH QUESTIONS <br>";
	
	// Counter for questions
	$i = 1;
	// $q = mysqli_fetch_array(mysqli_query($db, "SELECT TRADE_NAME FROM TRADES WHERE ID='".$trade_id."'"));
	// $trade_name = $q['TRADE_NAME'];

	# Getting the trade name starts
	$sql ="SELECT TRADE_NAME FROM TRADES WHERE ID='".$trade_id."'";
	$stmt= $pdo->prepare($sql);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$trade_name = $row['TRADE_NAME'];		
	# Getting the trade name ends

	# *******************printing the quiz header starts*****************#
	echo "
		<center>
			<h3 class='ui huge blue header'>".$trade_name." Quiz</h3>
		</center>
		<div class='' style='border-style: inset; margin:2% 20%;'>
		<form action='' method='POST' id='quiz' class='ui form' style='padding: 2% 10%'>
		<div class='ui celled list'>
	";
	# *******************printing the quiz header ends*****************#

	# seems like an array to collect the correct answers
	$correct_answer = array();
	#****************AGAINCOLLECTING QUESTIONS FOR THIS TRADE STARTS *****************
	# query for getting the questions for this trade
	$sql ="SELECT * FROM QUESTION_BANK WHERE TRADE_ID=".$trade_id." AND HIDDEN = 0 ORDER BY RAND() LIMIT ".$expected_question_count;
	$stmt= $pdo->prepare($sql);
	$stmt->execute();	
	#****************AGAIN COLLECTING QUESTIONS FOR THIS TRADE ENDS *****************
	# This while loop will be used to get out one question at a time
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
		//echo "<p>".$i.") ".$row['ID'].". ".$row['DESCRIPTION']."<br>";
		$correct_answer[$i-1] = $row['CORRECT_ANS'];
		
		// Something related to display based on the value of i 
		if($i==1){
			echo "<div class='item' id='item-".$i."'  style='display:block'>";
		}else{
			echo "<div class='item' id='item-".$i."'  style='display:none'>";
		}

		// Printing out a mcq question starts 
		// In the following echo function
		// Radio buttons have been printed based on the collected question
		echo "
                <p>Question $i out of $expected_question_count</p>
				<h3 class='ui big red header'>  ".$row['DESCRIPTION']."</h3>
				<div class='ui divided selection list'>
					<div class='item field' style='margin: 2%;'>	
						<div class='ui radio checkbox'>
							<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-A' value='1'/>
							<label for='question-".$i."-answers-A'> ".$row['OPT_A']." </label>
						</div>
					</div>
				
					<div class='item field' style='margin: 2%;'>	
						<div class='ui radio checkbox'>
							<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-B' value='2' />
							<label for='question-".$i."-answers-B'> ".$row['OPT_B']."</label>
						</div>
					</div>
				
					<div class='item field' style='margin: 2%;'>	
						<div class='ui radio checkbox'>
							<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-C' value='3' />
							<label for='question-".$i."-answers-C'> ".$row['OPT_C']."</label>
						</div>
					</div>
					
					<div class='item field' style='margin: 2%;'>	
						<div class='ui radio checkbox'>
							<input type='radio' name='question-".$i."-answers' id='question-".$i."-answers-D' value='4' />
							<label for='question-".$i."-answers-D'> ".$row['OPT_D']."</label>
						</div>
					</div>
				</div>
				";
		// Printing out a mcq question ends
		if($i == $expected_question_count){
		// if the value of i has reached the expected number of questions, then the SUBMIT button will be printed
		// using this block
		// Here a post request will be made with all the answers provided so far
			echo "
					<button 
						class='ui positive button right floated' 
						style='margin: 2%;padding: 2% 5%;' 
						type='submit' name='submit' id='submit_button'>Submit Answers
					</button>
					</div> 
					</div>
				</form>
			</div>
			";
		}else{
		// otherwise the button next question will be printed and the user will continue giving the exam	
			echo "
				<button 
					class='ui purple button right floated'
					type='button'
					style='padding: 2% 5%;'
					onclick='next(".$i.")'>Next Question
				</button>
			</div> 
			";
		}
		// Incrementing the counter of questions
		$i++;
	}
}

	// *******************************CODE FOR PROCESSING THE SUBMIT POST request starts***************************//
	if(isset($_POST['submit']))
	{
		echo "THe following was posted !!!<br>";
		print_r($_POST);
		
		# Collecting the user's answers from the POST array
		$answer = array();		
		for($k=0; $k< $question_count; $k=$k+1)
		{
			$index = "question-" . ($k+1) . "-answers";
			if(!empty($_POST[$index] ))
			{
				$answer[$k] = $_POST[$index];
			}
		}

		# $totalCorrect variable is storing how many questions were answered correctly
		for ($j = 0; $j < $question_count; $j+=1) {
			if(!empty($correct_answer[$j]) && !empty($answer[$j]))
			{
				if ($correct_answer[$j] == $answer[$j]) { $GLOBALS["totalCorrect"]++; }
			}
		}

		# Calculating how many questions were wrongly answered
		$totalWrong= $expected_question_count - $totalCorrect; 
		
		# Something related to UI I suppose
		echo "<script type='text/javascript'>
			  $(document).ready(function(){
			  $('#score_board').modal({ closable: false}).modal('show');});
			</script>";
	}
	//Result of this block: These values have been calculated
	// totalWrong 
	// totalCorrect
    // *******************************CODE FOR PROCESSING THE SUBMIT POST request ends***************************//
	
	// *******************************CODE FOR PROCESSING THE UPDATE BUTTON POST request starts***************************//
	
	// This update post request was sent with the following data:
	// name, bafID, rank, totalCorrectCount

	if(isset($_POST['update']))
	{
		
		date_default_timezone_set('Asia/Dhaka');
		$date = date('Y-m-d H:i:s');
		$name = $_POST['name'];
		$bafID = $_POST['bafID'];
		$rank = $_POST['rank'];
		$tc = $_POST['totalCorrectCount'];
		
		if($name!="" && $bafID!="" && $rank!="")
		{
		// Data is being inserted if the above 3 fields are not blankk
			try {
				$sql = "INSERT INTO LEADERBOARD (TRADE_ID,TIME,BAF_NO,PERSON_NAME,RANK,CORRCET_ANS_COUNT,TOTAL_QUESTION_COUNT) VALUES ('$trade_id','$date','$bafID','$name','$rank','$tc','$expected_question_count')";
				$stmt= $pdo->prepare($sql);
				$stmt->execute();	
				echo "Success!";
				// The try block will successfully run if no error occurs and data is inserted
			} catch (PDOException $e) {
				echo "The following error has occurred <br>";
				echo "".$e;
			}					
			echo "<script> $('#successModal').modal({closable: false}).modal('show'); </script>";			
		}else{
			echo "<script> $('#failedModal').modal({closable: false}).modal('show'); </script>";
		}

	}

?>

<div class='ui tiny modal' id='score_board'>
		<!-- <i class='close icon'></i> -->

		<div class='header' style='text-align: center;'>Quiz Score</div> 

		<div class='ui tiny horizontal statistics' style='margin-left: 35%;'>
		  <div class='statistic'>
		    <div class='value'>  <?php echo $expected_question_count ?></div>
		    <div class='label'>Total questions</div>
		  </div>
		  <div class='statistic' style='margin-top: -2%;'>
		    <div class='value'> <?php echo $totalCorrect ?></div>
		    <div class='label'>Correct answer</div>
		  </div>
		  <div class='statistic' style='margin-top: -2%;'>
		    <div class='value'> <?php echo $totalWrong?></div>
		    <div class='label'>Wrong answer</div>
		  </div>
		</div> 

	<div class='' style='display: none;border-top: 1px solid lightgrey;' id='savediv'>
		<form class='ui form' method='POST' style='margin:2%; padding:2%;' id='saveForm'>
		
			
			<input type='hidden' id='totalCorrectCount' name='totalCorrectCount' style='' class='form-control' value='<?php echo $totalCorrect?>'>

			<div class='required field column'>
				<label>Enter Name</label>
				<div class='ui input focus' style='width:100%'>
					<input type='text' id='name' name='name'
						style='' class='form-control' placeholder='Name'>
				</div>
			</div>
			
			<div class='ui two column grid'>
				<div class='required field column'>
					<label>BAF ID</label>
					<div class='ui input focus' style=''>
						<input type='text' id='bafID' name='bafID'
								style='' class='form-control' placeholder='ID'>
					</div>
				</div>
			
				<div class='required field column'>
					<label>Rank</label>
					<div class='ui input focus' style=''>
						<input type='text' id='rank' name='rank'
								style='' class='form-control' placeholder='rank'>
					</div>
				</div>		
			</div>
				<div class='' style='border-top: 1px solid lightgrey;'>
				<button 	
					class='ui positive button left floated' 
					id='update' 	
					type='submit' 
					name='update'
					style='margin: 10px;'>Update
				</button>
				<div 
					class='ui basic deny button right floated' 
					onclick='form_cancel()'
					style='margin: 10px;'>Cancel
				</div>
			</div>
		</form>  

	</div>
	
	<div class='' style='border-top: 1px groove' id='prevdiv'>
		<div class='ui positive button left floated' id='save' type='button' style='margin: 10px;' onclick='save_info()'>Save</div>
		<div class='ui basic deny button right floated' onclick='form_cancel()' style='margin: 10px;'>Cancel</div>
	</div>
</div>

<script type="text/javascript">

	
	function save_info() {
        document.getElementById("savediv").style.display = "block";
		document.getElementById("save").innerHTML  = "Update";
		document.getElementById("prevdiv").style.display  = "none";
    };
   
   function form_cancel() {
		location.href = "http://localhost/cbt/";
   };

//    $("#quiz").on('submit', function(){
// 	   location.href = "http://localhost/cbt/";
//    		$('#score_board').show();
// 	});

   function next(id)
   {
	   hideDiv = "item-" + id;
	   showDiv = "item-" + (id+1);
	   document.getElementById(showDiv).style.display = "block";
	   document.getElementById(hideDiv).style.display  = "none";
   };
	

	$('#SuccessMessageClose').on('click', function() {
    	$('#successModal').modal('hide');
    	location.replace("http://localhost/cbt/");
  	});

  	$('#failMessageClose').on('click', function() {
    	$('#failedModal').modal('hide');
    	location.replace("http://localhost/cbt/");
    	
  	});


</script>

</body>
</html>
