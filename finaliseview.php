<?php 
include_once("nocache.php");
require_once("conn.php");
session_start();

if(!$_SESSION['who']) {
  header("location: logoff.php");
}

if ($_SESSION["mode"] != 1) {   //Check access control
	header("location: unauth.php");
}

$errorMessage = "";


$sql = "SELECT firstname, surname from employee WHERE employee_id='{$_SESSION['who']}'";
$employee = $connection->query($sql)
     or die ('Problem with query: ' . $connection->error);
 
$sql_review = "SELECT * from review WHERE review_id='".$_GET['reviewid']."'";
$reviews = $connection->query($sql_review)
     or die ('Problem with query: ' . $connection->error);

 ?>
<?php include("header.php"); ?>

<body>
    <?php include("navbar2.php"); ?>

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


<?php 
if($reviews->num_rows>0) {
	while($row = $reviews->fetch_assoc()) {
?>

<div class="row" >
  <div class="col">
     <div class="card grey lighten-3">
       <div class="card-content">
         <span class="card-title">Review Details</span>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  	   <p style="color:red;"><?php echo $errorMessage;?></p>
  	   
  	   
  	   <h5>Employee Infromation Section</h5>
  	   
  	   <label for="id"><b>Employee ID</b></label>
           <input type="text" value="<?php echo $row['employee_id']; ?>" name="id" readonly>
           
           
           <?php 
           	$sqls = "SELECT * from employee WHERE employee_id='".$row['employee_id']."'";
		$empl = $connection->query($sqls)  or die ('Problem with query: ' . $connection->error);
		if($empl->num_rows>0) {
			while($emp= $empl->fetch_assoc()) {
           ?>
           
           
           
           
           <label for="fname"><b>Family Name</b></label>
           <input type="text" value="<?php echo $emp['surname']; ?>" name="fname" readonly>
           <label for="gname"><b>Given Name</b></label>
           <input type="text" value="<?php echo $emp['firstname']; ?>" name="gname" readonly>
           
           <?php 
           	$sqlss = "SELECT * from job WHERE job_id='".$emp['job_id']."'";
		$emp_job = $connection->query($sqlss)  or die ('Problem with query: ' . $connection->error);
		if($emp_job->num_rows) {
			$emp_jobs = $emp_job->fetch_assoc()
           ?>
           
           <label for="jtitle"><b>Job Title</b></label>
           <input type="text" value="<?php echo $emp_jobs['job_title']; ?>" name="jtitle" readonly>
           
           <?php
           }
           
           ?>
           
           <label for="emode"><b>Employement Mode</b></label>
           <input type="text" value="<?php echo $emp['employment_mode']; ?>" name="emode" readonly>
           
           <?php 
           	$sqlsss = "SELECT * from department WHERE department_id='".$emp['department_id']."'";
		$emp_dep = $connection->query($sqlsss)  or die ('Problem with query: ' . $connection->error);
		if($emp_dep->num_rows) {
			$emp_deps = $emp_dep->fetch_assoc()
           ?>
           
           
           
           <label for="dname"><b>Department Name</b></label>
           <input type="text" value="<?php echo $emp_deps['department_name']; ?>" name="dname" readonly>
           
           <?php } ?>
           <label for="ryear"><b>Review Year</b></label>
           <input type="text" value="<?php 
           	$a = ['2016', '2017', '2018'];
           	$b= $a[mt_rand(0, count($a) - 1)];
           	echo $b; 
           	?>" name="ryear" readonly>
           
           
           <?php
           }
           }
           ?>
           <br>
           <br>
           <h5>Rating Infromation Section [1-5]</h5>
           <label for="job_knowledge"><b>Job Knowledge</b></label>

           <input type="text" value="<?php echo $row['job_knowledge']; ?>" name="job_knowledge" >
           <label for="work_quality"><b>Work Quality</b></label>
           <input type="text" value="<?php echo $row['work_quality']; ?>" name="work_quality" >
           
           
           <label for="initiative"><b>Initiative</b></label>
           <input type="text" value="<?php echo $row['initiative']; ?>" name="initiative" >
           
           
           <label for="communication"><b>Communication</b></label>
           <input type="text" value="<?php echo $row['communication']; ?>" name="communication" >
           
           <label for="dependability"><b>Dependability</b></label>
           <input type="text" value="<?php echo $row['dependability']; ?>" name="dependability" >
           
           <br>
           <br>
           <h5>Evaluation and Action Section</h5>
           <label for="additional_comment"><b>Additional Comments</b></label>
           <input type="text" value="<?php echo $row['additional_comment']; ?>" name="additional_comment" >
           <label for="goals"><b>Goals for Employee</b></label>
           <input type="text" value="<?php echo $row['goals']; ?>" name="goals" >
           <label for="action"><b>Action Required</b></label>
           <input type="text" value="<?php echo $row['action']; ?>" name="action" >
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           <br>
           <br>
           <h5> Verification Section</h5>
           <p>Thank you for taking part in your Performance Review. This review is an important aspect of the development of our organisation and itsprofits and of you as a valued employee. </p> <br>
          <p><b>By electronically signing this form, you confirm that you have discussed this review in detail with your supervisor.</b> <i>The fine print: Signing this form does not necessarily indicate that you agree with this evaluation.
           If you do not agree with this evaluationplease feel free to find another job outside of Wayne Enterprises.</i> </p>
       	 <br>
       	 
       	 <input type="checkbox" id="checkboxid"><label for="checkboxid">Tick to agree</label>
       	   <br> <br>
           <button onclick="window.location.href='/page2'">Continue</button>
           <button class="btn-large deep-purple darken-3" type="submit" name="save" style="margin-left: 50px;">Save</button>
         
           <button class="btn-large deep-purple darken-3" type="submit" name="submit" style="margin-left: 50px;">Submit</button>
           </form>
       </div>
    </div>
  </div>
</div>

<?php
 }
}
?>

     
</body>
</html>