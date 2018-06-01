<?php 
include_once("nocache.php");
require_once("conn.php");
session_start();
$sql = "SELECT * from employee WHERE employee_id='{$_SESSION['who']}'";
$employee = $connection->query($sql)
     or die ('Problem with query: ' . $connection->error);
 
$sql_review = "SELECT * from review WHERE review_id='".$_GET['reviewid']."' ";
$reviews = $connection->query($sql_review)
     or die ('Problem with query: ' . $connection->error);
 
 $sqls = "SELECT * from employee WHERE employee_id='{$_SESSION['who']}'";
$employees = $connection->query($sqls)
     or die ('Problem with query: ' . $connection->error);
 
$sql_reviews = "SELECT * from review WHERE review_id='".$_GET['reviewid']."' ";
$reviewss = $connection->query($sql_reviews)
     or die ('Problem with query: ' . $connection->error);
?>
<?php include("header.php"); ?>

<body>


  <nav style="float:right;">
     <a href="login.php">Login</a> |
     <a href="logoff.php">Log Off</a> |
     <a href="choosereview.php">Choose Review</a> |
  </nav>
  
  <h3>Current Date: <?php echo "Today is " . date("Y-m-d") . "<br>"; ?> </h3>
  
  <p>Logged In User:
  <?php 
  if ($employee->num_rows) {
    $user = $employee->fetch_assoc();
    echo $user["firstname"]. " " .$user["surname"];
  }
   ?></p>
   
   
  <hr>
  
  
  <h3>Employee Information Section</h3>
  <?php
 if($employees->num_rows) {
    $user= $employees->fetch_assoc();
    echo "<ul><li>Employee ID: ".$user["employee_id"]."</li><li> Surname: ".$user["surname"]."</li>
    <li>First Name: ".$user["firstname"]."</li><li>Employment Mode: ".$user["employment_mode"]."</li></ul>";
  }
  ?>
  <hr>
  
<h3>Rating Information Section: </h3>
<p>Rating for each criteria:<p>
<?php
 if($reviews->num_rows) {
     $rows = $reviews->fetch_assoc();
     echo "<ul><li>Job Knowledge: ".$rows["job_knowledge"]."</li><li> Work Quality: ".$rows["work_quality"]."</li>
    <li>Iniative: ".$rows["initiative"]."</li><li>Communication: ".$rows["communication"]."</li><li>Dependability: ".$rows["dependability"]."</li></ul>";
    }
 ?> 

   <hr>
  <h3>Evaluation and Action Section: </h3>
<?php
 if($reviewss->num_rows) {
    $rows = $reviewss->fetch_assoc();
     echo "<ul><li>Additional Comments: ".$rows["additional_comment"]."</li><li> Goals for employee: ".$rows["goals"]."</li>
    <li>Action Required: ".$rows["action"]."</li><li>Review Complete Date: ".$rows["date_completed"]."</li></ul>";
 }
?> 
 
<?php $connection->close(); ?>

</body>
</html>
