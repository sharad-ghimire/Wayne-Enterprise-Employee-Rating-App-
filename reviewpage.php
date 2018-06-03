<?php 
include_once("nocache.php");
require_once("conn.php");
session_start();

if(!$_SESSION['who']) {
  header("location: logoff.php");
}

$sql = "SELECT firstname, surname from employee WHERE employee_id='{$_SESSION['who']}'";
$employee = $connection->query($sql)
     or die ('Problem with query: ' . $connection->error);
if ($employee->num_rows) {
    $user = $employee->fetch_assoc();
    $fName = $user["firstname"];
    $sName = $user["surname"];
  }
 
 
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

<?php include("navbar2.php"); ?>

  <div style="margin-left:50px;">
  <p>Current Date: <?php echo "Today is " . date("Y-m-d") . "<br>"; ?> </p>
  <p>Logged In User:<?php echo $fName." ". $sName;?></p>
 </div>
   <hr>
   
 <hr>
  
  
  <?php
  
  if($employees->num_rows) {
      $user= $employees->fetch_assoc();
     	echo "<div class='row'><div class='col'><div class='card-panel grey lighten-4'> 
     	 <h3>Employee Information Section</h3><ul><li>Employee ID: ".$user["employee_id"]."</li><li> Surname: ".$user["surname"]."</li>
    <li>First Name: ".$user["firstname"]."</li><li>Employment Mode: ".$user["employment_mode"]."</li></ul> <br> <br></div></div></div>";
  }

  ?>
<?php
 if($reviews->num_rows) {
     $rows = $reviews->fetch_assoc();
     echo "<div class='row'><div class='col'><div class='card-panel grey lighten-4'><h3>Rating Information Section: </h3><p><b>Rating for each criteria:</b><p><ul><li>Job Knowledge: ".$rows["job_knowledge"]."</li><li> Work Quality: ".$rows["work_quality"]."</li>
    <li>Iniative: ".$rows["initiative"]."</li><li>Communication: ".$rows["communication"]."</li><li>Dependability: ".$rows["dependability"]."</li></ul></div></div></div>";
    }
 ?> 



<?php
 if($reviewss->num_rows) {
    $rows = $reviewss->fetch_assoc();
     echo "<div class='row'><div class='col'><div class='card-panel grey lighten-4'>  <h3>Evaluation and Action Section: </h3><ul><li>Additional Comments: ".$rows["additional_comment"]."</li><li> Goals for employee: ".$rows["goals"]."</li>
    <li>Action Required: ".$rows["action"]."</li><li>Review Complete Date: ".$rows["date_completed"]."</li></ul></div></div></div>";
 }
?> 
 
<?php $connection->close(); ?>

</body>
</html>
