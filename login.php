<?php 
	include_once("nocache.php");
	
	$errorMessage = '';
	
	if(isset($_POST['submit'])) {
	  if(empty($_POST['id']) || empty($_POST['psw'])) {
	    $errorMessage = "Both ID and Password are required";
	  } else {
	    require_once("conn.php");  
	    
	    
	    $id = $connection->escape_string($_POST['id']);   //function that will clear out special char
	    $psw = $connection->escape_string($_POST['psw']);
	    
	    $hashedPassword = hash('sha256',$psw);
	    
	    $sql = "SELECT employee_id from employee where employee_id='$id' and password ='$hashedPassword'";
	    $rs = $connection->query($sql);
	   
	   
	    	    
	    if($rs->num_rows) { //If not zero they provided the correct details
	    	session_start(); //Now they are authenticated
	    	 
	    	
	    	$employee = $rs->fetch_assoc(); //only one match
	    	
	    	$_SESSION['who'] = $employee['employee_id']; 
	    	
	    	 $sql2 = "SELECT department_head from department where department_head='".$employee['employee_id']."'";
	         $rs2 = $connection->query($sql2);
	         $dep = $rs2->fetch_assoc();	
      	    	 if($dep['department_head'] == $employee['employee_id']) {
      	    	 	$_SESSION['mode'] = 1;
      	    	 }

	    	//Redirecting the user to the secure page
	        header('location: choosereview.php');
	    	
	    } else {
	    	$errorMessage = "Invalid Username and Password";
	    }
	  }
	}
?>

<?php include("header.php"); ?>

<body class="container">

    <h2 align="center">Wayne Enterprise</h2>

    <div class="row">
        <div class="col">
            <div class="card grey lighten-3">
                <div class="card-content">
                    <span class="card-title">Login Details</span>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <p style="color:red;">
                            <?php echo $errorMessage;?>
                        </p>
                        <label for="id">
                            <b>Employee ID</b>
                        </label>
                        <input type="text" placeholder="hd000003" name="id" required>
                        <label for="psw">
                            <b>Password</b>
                        </label>
                        <input type="password" placeholder="overi" name="psw" required>
                        <button class="btn-large deep-purple darken-3" type="submit" name="submit" style="display: block; margin: 0 auto;">Login</button>
                    </form>
                </div>
                <div class="card-action">

                    <p>The performance planning and review process is intended to assist supervisors to review the performance
                        of staff during a given period (at least annually) and develop agreed performance plans based on
                        workload agreements and the strategic direction of Wayne Enterprises. </p>

                    <p>
                        <b>The Performance Planning and Review System</b> covers both results (what was accomplished), and behaviours
                        (how those results were achieved). The most important aspect is what will be accomplished in the
                        future and how this will be achieved within a defined period. The process is continually working
                        towards creating improved performance and behaviours that align and contribute to the mission and
                        values of Wayne Enterprises</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>