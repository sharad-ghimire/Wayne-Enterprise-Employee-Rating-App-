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
          <form method="post"  onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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

           <input type="number" value="<?php echo $row['job_knowledge']; ?>" name="job_knowledge" id="job_knowledge" min="1" max="5">
           <label for="work_quality"><b>Work Quality</b></label>
           <input type="number" value="<?php echo $row['work_quality']; ?>" name="work_quality" id="work_quality" min="1" max="5">  
           
           
           <label for="initiative"><b>Initiative</b></label>
           <input type="number" value="<?php echo $row['initiative']; ?>" name="initiative" id="initiative" min="1" max="5">  
           
           
           <label for="communication"><b>Communication</b></label>
           <input type="number" value="<?php echo $row['communication']; ?>" name="communication"  id="communication" min="1" max="5"> 
           
           <label for="dependability"><b>Dependability</b></label>
           <input type="number" value="<?php echo $row['dependability']; ?>" name="dependability" id="dependability" min="1" max="5" >  
           
           <br>
           <br>
           <h5>Evaluation and Action Section</h5>
           <label for="additional_comment"><b>Additional Comments</b></label>
           <input type="text" value="<?php echo $row['additional_comment']; ?>" name="additional_comment" id="additional_comment">
           <label for="goals"><b>Goals for Employee</b></label><span><?php if(isset($goalsErr)){ echo $goalsErr; }?></span>
           <input type="text" value="<?php echo $row['goals']; ?>" name="goals" id="goals">
           <label for="action"><b>Action Required</b></label>
           <span id="actionspan"></span>
           <input type="text" value="<?php echo $row['action']; ?>" name="action" id="action" >
       
         
           
           <br>
           <br>
           <h5> Verification Section</h5>
           <p>Thank you for taking part in your Performance Review. This review is an important aspect of the development of our organisation and itsprofits and of you as a valued employee. </p> <br>
          <p><b>By electronically signing this form, you confirm that you have discussed this review in detail with your supervisor.</b> <i>The fine print: Signing this form does not necessarily indicate that you agree with this evaluation.
           If you do not agree with this evaluationplease feel free to find another job outside of Wayne Enterprises.</i> </p>
       	 <br>
       	 
       	 <input type="checkbox" id="checkboxid"><label for="checkboxid">Tick to agree</label>
       	   <br> <br>
           <button /* onclick="window.location.href='ratingupdate.html'"*/ class="btn-large deep-purple darken-3" type="submit" name="save" style="margin-left: 50px;">Save</button>
           
           <button /* onclick="window.location.href='ratingupdate.html'" */ class="btn-large grey darken-3" type="submit" name="submit" style="margin-left: 50px;">Submit</button>
           
           </form>
       </div>
    </div>
  </div>
</div>

<?php
 }
}
?>

<script type="text/javascript">
function validateForm() {
var x, action;

    x = document.getElementById("action").value;

    // If x is Not a Number or less than zeroor greater than 19 or N
    if (isNaN(x) || x < 0  || x > 19 || x !== 'N') {
        action= "Input not valid";
    } else {
        action= "Input OK";
    }
    document.getElementById("actionspan").innerHTML = action;
}

</script>



<?php
if(isset($_POST['submit'])){

  $goals=trim($_POST["goals"]);
  $goalsErr = "";
  
  if(!preg_match( "/ ^[a-zA-Z0-9!-,._ ]*$ /" , $goals)) {
     $goalsErr = "only  contain  alphanumeric characters,  spaces,hyphens, commas,  and exclamation marks";
  }

 
}
?>


<?php
if(isset($_POST['save'])){
	$job_knowledge = $_POST['job_knowledge'];
	$work_quality= $_POST['work_quality'];
	$initiative= $_POST['initiative'];
	$communication= $_POST['communication'];
	$dependability= $_POST['dependability'];
	
	$additional_comment= $_POST['additional_comment'];
	$goals= $_POST['goals'];
	$action= $_POST['action'];
	
	$sql_update = "UPDATE review SET job_knowledge = '$job_knowledge', 
			work_quality= '$work_quality',
			initiative= '$initiative',
			communication= '$communication',
			dependability= '$dependability',
			additional_comment= '$additional_comment',
			action= '$action',
			goals= '$goals' WHERE review_id='".$_GET['reviewid']."' ";
	
	$getit= $connection->query($sql_update);
	
	
	echo "Updated data successfully\n";
}
?>

     
</body>
</html>