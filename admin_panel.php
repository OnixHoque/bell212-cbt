<?php
include("connection.php");
error_reporting();

session_start();

//$pin = $row['PINCODE'];

//if(isset($_POST['_SESSIONsede']) && $_POST['session_code']==_SESSION["code"]){
// print_r($_SESSION);

if(isset($_SESSION["code"])){
		//echo "Welcome Admin!";
    }else{
        echo "Unautorized Login!";
        header("Location: 404.html");
    }

?>


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
  .ui.red.vertical.stretched.menu .item:hover{
    background-color: #DB4437 !important;
    color: white !important;
  }

  a > div > p {
    color: black;
  }
  .ui.fluid.card:hover *{
    background-color: #DB4437;
    color: white !important;
  }

  /*body {
    background-color: white; /*Default bg, similar to the background's base color*/
    background-image: url("images/helicopter-background.png");

    background-position: right bottom; /*Positioning*/
    background-size: 100%;
    background-repeat: no-repeat; /*Prevent showing multiple background images*/
  }*/



  </style>

</head>

<body>


  <div class="ui top red pointing menu">

    <div class="ui container" style="margin-top: 20px; padding-left: 70px;">
      <a href="index.html">
        <h2 class="ui header left aligned">
          <img src="images/bell-logo2.jpg">
          <div class="content">
            System Settings
            <div class="sub header">Bell-212 CBT Module</div>
          </div>
        </h2>
      </a>
      <!-- <p class="item" style="font-size: 1.20em;">Bell-212 Tutorial</p></p> -->

    </div>

    <div class="right menu" style="padding-right: 60px;">
      <div class="ui grid">
        <div class="row"></div>
        <div class="row">
          <div class="ui red button" id="adminlogout">
            Logout
          </div>
        </div>
        <div class="row"></div>
      </div>
    </div>
  </div>

  <div class="ui grid">
    <div class="stretched row" style="height: 80vh; padding-top: 3% ">
      <div class="one wide column"></div>
      <div class="five wide column">
        <div class="ui basic text segment">
        	
          <div class="ui red vertical stretched menu" style="cursor: pointer; width: 100%;">
            <a class="item" style="background: white;" id="questionBank">
              <p style="font-size: 110%;" ><strong>Question Bank</strong></p>
              <p style="text-align: justify;">Modify the list of questions, answers and related settings.</p>
            </a>
            <a class="item">
              <p style="font-size: 110%;"><strong>Change Password</strong></p>
              <p style="text-align: justify;">Change the pincode to improve security.</p>
            </a>
            <a class="item" id="btnSetting">
              <p style="font-size: 110%;"><strong>Quiz Settings</strong></p>
              <p style="text-align: justify;">Modify quiz related settings.</p>
            </a>
          </div>
        </div>

      </div>
      <!-- <div class="eleven wide column">
      <div class="ui grid">
      <div class="row" style=""></div>
      <div class="row">
      <div class="one wide column">
    </div>
    <div class="fourteen wide column">

    <img src="images/helicopter-background.png" />
  </div>


</div>
</div>



</div> -->
</div>
</div>

  <!-- Question Module Select Modal content -->
  
  
<div class="ui modal" id="quizpanel">
  <!-- <i class="close icon"></i> -->
  <div class="header" style="text-align: center;">
    Select Quiz Topic
  </div>  
  <div class="ui basic text segment" style="margin: 20px;">
    <div class="ui three column grid">
      <div class="column">
        <a class="ui fluid card" style="height: 150px;" href="questionBank.php?type=1">
          <div class="fluid content">
            <p class="header">Engine</p>
            <p>Topics include Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper orci id porttitor vestibulum.</p>
          </div>
        </a>
      </div>
      <div class="column">
        <a class="ui fluid card" style="height: 150px;" href="questionBank.php?type=2">
          <div class="fluid content">
            <p class="header">Airframe</p>
            <p>Topics include Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper orci id porttitor vestibulum.</p>
          </div>
        </a>
      </div>
      <div class="column">
        <a class="ui fluid card" style="height: 150px;" href="questionBank.php?type=3">
          <div class="fluid content">
            <p class="header">Electric Components</p>
            <p>Topics include Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper orci id porttitor vestibulum.</p>
          </div>
        </a>
      </div>
      <div class="column">
        <a class="ui fluid card" style="height: 150px;" href="questionBank.php?type=4">
          <div class="fluid content">
            <p class="header">Instruments</p>
            <p>Topics include Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper orci id porttitor vestibulum.</p>
          </div>
        </a>
      </div>
      <div class="column">
        <a class="ui fluid card" style="height: 150px;" href="questionBank.php?type=5">
          <div class="fluid content">
            <p class="header">Radio</p>
            <p>Topics include Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper orci id porttitor vestibulum.</p>
          </div>
        </a>
      </div>
      <div class="column">
        <a class="ui fluid card" style="height: 150px;" href="questionBank.php?type=6">
          <div class="fluid content">
            <p class="header">Armaments</p>
            <p>Topics include Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper orci id porttitor vestibulum.</p>
          </div>
        </a>
      </div>
    </div>

  </div>
  <!-- End of Contents -->
  
    <div class="actions">
    <div class="ui basic deny button">
      Close
    </div>
  </div>
</div>



<!-- Setting modal --> 

<div class="ui modal" id="settingModal">
<!-- <i class="close icon"></i> -->

  <div class="header" style="text-align: center;">
    Add Quiz Question
  </div>
<form class="ui form" method="POST">
  <div class="ui basic text segment" style="margin: 20px;">
	
	<div class="ui two column grid">

		<div class="required field column">
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
		
		<div class=" required field column">
			<label>Number of Questoins</label>
			<div class="ui input focus" style="">
				<input type="text" id="op1" name="op1" 
						style="" class="form-control" placeholder="Number of Questoins">
			</div>
		</div>
		
	</div>
  </div>
</form>
  
	
	<div class="actions">
		<div class="ui positive button left floated" id="save">Save</div>
		<div class="ui basic deny button">Cancel</div>
	</div>
</div>


<!-- Setting modal --> 




<script>

$("#adminlogout").click(function(){
    $('#adminlogout').addClass('loading');
  	var finish = $.post("controller/session_destroy.php", {}, function(data){
      window.location.href = "index.html";
    });
  });
  
  $('#questionBank').click(function(){
  $('#quizpanel').modal('show');
});

  $('#btnSetting').click(function(){
  $('#settingModal').modal('show');
});



</script>

</body>

</html>
