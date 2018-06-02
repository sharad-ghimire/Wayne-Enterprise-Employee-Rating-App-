<?php 

require_once("nocache.php");

session_start();

if(!$_SESSION["who"]){
	header("location: logoff.php");
}

if ($_SESSION["mode"] != 1) {   //Check access control
	header("location: unauth.php");
}


?>
<?php include("header.php"); ?>
<body>
  <p>Only staffs can access </p>
     
</body>
</html>