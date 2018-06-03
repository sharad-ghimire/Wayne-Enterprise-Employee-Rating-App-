<?php 
require_once("nocache.php");
session_start();
if(!$_SESSION["who"]) {
   header("location: logoff.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include("header.php"); ?>
<?php include("navbar.php");?>
<body>
<h1>Unauthorized Access</h1>
<p>Yo have tried to access a restricted page. </p>
<p> Only <strong>AUTHORIZED</strong> are allowed to access this page. </p>

<p>If you are an authorized user, Please <a href="login.php">Login</a> Again.</p>
	

</body>
</html>