<?php
$connection = new mysqli('localhost', 'twa321', 'twa321pb', 'performancereview321');
if ($connection->connect_error) {    
	exit("Failed to connect to database " . $connection->connect_error); 
}
?>