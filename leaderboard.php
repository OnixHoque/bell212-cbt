
<!DOCTYPE html>
<html>

<head>
  <title>Bell-212 CBT Leaderboard</title>
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
      <a href="index.html">
        <h2 class="ui header left aligned">
          <img src="images/bell-logo2.jpg"></img>
          <div class="content">
            Leaderboard
            <div class="sub header">Bell-212 Hel CBT</div>
          </div>
        </h2>
      </a>
      <!-- <p class="item" style="font-size: 1.20em;">Bell-212 Tutorial</p></p> -->

    </div>
  </div>


<?php

//...
$conn = mysqli_connect("localhost", "root", "", "cbt-db");
// $conn = mysqli_connect("localhost", "root", "mysql", "cbt-db");
// 
// Create connection
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

?>

  <div class="ui container" style="width: 80%">
  <!-- <div class="ui grid"> -->



    <!-- <div class="stretched row" style="height: 100vh; padding-left: 15%; padding-right: 15%;"> -->

      <!-- <div class="column"> -->

        <div class="ui top attached tabular menu">
          <a class="active item" data-tab="first">Engine</a>
          <a class="item" data-tab="second">Airframe</a>
          <a class="item" data-tab="third">Electric Components</a>
          <a class="item" data-tab="fourth">Instruments</a>
          <a class="item" data-tab="fifth">Radio</a>
          <a class="item" data-tab="sixth">Armaments</a>
        </div>
        <div class="ui bottom attached tab segment active" data-tab="first">
        

        <table id="table1" class="ui celled selectable table" style="width:100%; text-align: center; cursor: pointer;">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>BAF No.</th>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
          
          <?php
          
          $sql = "SELECT * FROM leaderboard where trade_id=1";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()){

              echo "<tr>";
              echo "<td>".$row["TIME"]."</td>";
              echo "<td>".$row["BAF_NO"]."</td>";
              echo "<td>".$row["RANK"]."</td>";
              echo "<td>".$row["PERSON_NAME"]."</td>";

              $cor = (int)$row["CORRCET_ANS_COUNT"];
              $tot = (int)$row["TOTAL_QUESTION_COUNT"];

              if ($tot != 0)
                echo "<td>".round($cor/$tot*100,2)."%</td>";
              else
                echo "<td>0%</td>";
              echo "<td>".$row["CORRCET_ANS_COUNT"]." correct out of ".$row["TOTAL_QUESTION_COUNT"]."</td>";
              echo "</tr>";
          }
        }
         // $conn->close(); 

          ?>
        
        </tbody>
    </table>

        </div>
        <div class="ui bottom attached tab segment" data-tab="second">
          <table id="table2" class="ui celled selectable table" style="width:100%; text-align: center; cursor: pointer;">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>BAF No.</th>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            
            <?php
          
          $sql = "SELECT * FROM leaderboard where trade_id=2";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()){

              echo "<tr>";
              echo "<td>".$row["TIME"]."</td>";
              echo "<td>".$row["BAF_NO"]."</td>";
              echo "<td>".$row["RANK"]."</td>";
              echo "<td>".$row["PERSON_NAME"]."</td>";

              $cor = (int)$row["CORRCET_ANS_COUNT"];
              $tot = (int)$row["TOTAL_QUESTION_COUNT"];
              if ($tot != 0)
                echo "<td>".round($cor/$tot*100,2)."%</td>";
              else
                echo "<td>0%</td>";
              echo "<td>".$row["CORRCET_ANS_COUNT"]." correct out of ".$row["TOTAL_QUESTION_COUNT"]."</td>";
              echo "</tr>";
          }
        }
         //$conn->close(); 

          ?>

        </tbody>
    </table>
        </div>
        <div class="ui bottom attached tab segment" data-tab="third">
          <table id="table3" class="ui celled selectable table" style="width:100%; text-align: center; cursor: pointer;">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>BAF No.</th>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
          
          $sql = "SELECT * FROM leaderboard where trade_id=3";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()){

              echo "<tr>";
              echo "<td>".$row["TIME"]."</td>";
              echo "<td>".$row["BAF_NO"]."</td>";
              echo "<td>".$row["RANK"]."</td>";
              echo "<td>".$row["PERSON_NAME"]."</td>";

              $cor = (int)$row["CORRCET_ANS_COUNT"];
              $tot = (int)$row["TOTAL_QUESTION_COUNT"];
              if ($tot != 0)
                echo "<td>".round($cor/$tot*100,2)."%</td>";
              else
                echo "<td>0%</td>";
              echo "<td>".$row["CORRCET_ANS_COUNT"]." correct out of ".$row["TOTAL_QUESTION_COUNT"]."</td>";
              echo "</tr>";
          }
        }
         //$conn->close(); 

          ?>
        </tbody>
    </table>
        </div>
        <div class="ui bottom attached tab segment" data-tab="fourth">
          <table id="table4" class="ui celled selectable table" style="width:100%; text-align: center; cursor: pointer;">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>BAF No.</th>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
          
          $sql = "SELECT * FROM leaderboard where trade_id=4";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()){

              echo "<tr>";
              echo "<td>".$row["TIME"]."</td>";
              echo "<td>".$row["BAF_NO"]."</td>";
              echo "<td>".$row["RANK"]."</td>";
              echo "<td>".$row["PERSON_NAME"]."</td>";

              $cor = (int)$row["CORRCET_ANS_COUNT"];
              $tot = (int)$row["TOTAL_QUESTION_COUNT"];
              if ($tot != 0)
                echo "<td>".round($cor/$tot*100,2)."%</td>";
              else
                echo "<td>0%</td>";
              echo "<td>".$row["CORRCET_ANS_COUNT"]." correct out of ".$row["TOTAL_QUESTION_COUNT"]."</td>";
              echo "</tr>";
          }
        }
         //$conn->close(); 

          ?>
        </tbody>
    </table>
        </div>
        <div class="ui bottom attached tab segment" data-tab="fifth">
          <table id="table5" class="ui celled selectable table" style="width:100%; text-align: center; cursor: pointer;">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>BAF No.</th>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
          
          $sql = "SELECT * FROM leaderboard where trade_id=5";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()){

              echo "<tr>";
              echo "<td>".$row["TIME"]."</td>";
              echo "<td>".$row["BAF_NO"]."</td>";
              echo "<td>".$row["RANK"]."</td>";
              echo "<td>".$row["PERSON_NAME"]."</td>";

              $cor = (int)$row["CORRCET_ANS_COUNT"];
              $tot = (int)$row["TOTAL_QUESTION_COUNT"];
              if ($tot != 0)
                echo "<td>".round($cor/$tot*100,2)."%</td>";
              else
                echo "<td>0%</td>";
              echo "<td>".$row["CORRCET_ANS_COUNT"]." correct out of ".$row["TOTAL_QUESTION_COUNT"]."</td>";
              echo "</tr>";
          }
        }
         //$conn->close(); 

          ?>

        </tbody>
    </table>
        </div>
        <div class="ui bottom attached tab segment" data-tab="sixth">
          <table id="table6" class="ui celled selectable table" style="width:100%; text-align: center; cursor: pointer;">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>BAF No.</th>
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
          
          $sql = "SELECT * FROM leaderboard where trade_id=6";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()){

              echo "<tr>";
              echo "<td>".$row["TIME"]."</td>";
              echo "<td>".$row["BAF_NO"]."</td>";
              echo "<td>".$row["RANK"]."</td>";
              echo "<td>".$row["PERSON_NAME"]."</td>";

              $cor = (int)$row["CORRCET_ANS_COUNT"];
              $tot = (int)$row["TOTAL_QUESTION_COUNT"];
              if ($tot != 0)
                echo "<td>".round($cor/$tot*100,2)."%</td>";
              else
                echo "<td>0%</td>";
              echo "<td>".$row["CORRCET_ANS_COUNT"]." correct out of ".$row["TOTAL_QUESTION_COUNT"]."</td>";
              echo "</tr>";
          }
        }
         $conn->close(); 

          ?>

        </tbody>
    </table>
        </div>

        

      <!-- </div> -->
      </div>
</div>


<!-- Table end -->
<!-- </div> -->

<script>

$(document).ready(function() {
    $('#table1').DataTable();
    $('#table2').DataTable();
    $('#table3').DataTable();
    $('#table4').DataTable();
    $('#table5').DataTable();
    $('#table6').DataTable();
} );

$('.menu .item')
  .tab()
;
</script>

</body>

</html>