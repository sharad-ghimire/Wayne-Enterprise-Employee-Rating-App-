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
 
$sql_review = "SELECT * from review WHERE employee_id='{$_SESSION['who']}' ORDER BY review_year DESC ";
$reviews = $connection->query($sql_review)
     or die ('Problem with query: ' . $connection->error);

 ?>
<?php include("header.php"); ?>

<body>
    <?php include("navbar.php"); ?>

    <div style="margin-left:50px;">
        <p>Current Date:
            <?php echo "Today is " . date("Y-m-d") . "<br>"; ?> </p>

        <p>Logged In User:
            <?php 
  if ($employee->num_rows) {
    $user = $employee->fetch_assoc();
    echo $user["firstname"]. " " .$user["surname"];
  }
    ?>
        </p>
    </div>
    <hr>

    <div class="container">

        <?php
$counter = 0;
 if($reviews->num_rows>0) {
   echo  "<div class='row'>";
     while($rows = $reviews->fetch_assoc()) {
       $counter++;
     	echo "<div clas='col'><h6 class='header'> Review Number : " .$counter." </h6><div class='card-panel grey lighten-4'> 
     	<h4><a href='reviewpage.php?reviewid=".$rows["review_id"]."'>".$rows["review_year"]."</a></h4><br> Review Id: ".$rows["review_id"]."<br> Completion: ".$rows["completed"]." <br> <br></div></div>";
     }
 echo "</div>";
 } else { 
 	echo "No reviews for you budddy!!";
 }
?>


            <?php 
if(isset($_SESSION['mode'])) { ?>
            <hr>
            <h5>Summary of all performace reviews of your employees</h5>
            <?php 
$sql_super = "SELECT firstname, surname FROM employee WHERE supervisor_id='{$_SESSION['who']}'";
$super = $connection->query($sql_super);
if($super->num_rows>0) {
    while($super_value = $super->fetch_assoc()) {
    echo "Review for: ".$super_value['firstname']." ".$super_value['surname']."<br>
    <br> <a href='finalisereview.php?reviewid=".$rows["review_id"]."'>Year: ".$rows["review_year"]."<br>";
    
    }
}
?>
  <?php } ?>

 <?php  $connection->close(); ?>

    </div>
</body>

</html>