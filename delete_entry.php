
<?php

	$str = $_GET["todelete"];
	echo $str;
	$area = substr($str, 0, 4);
	$numba = substr($str, 4, 13);
	
	$con = new PDO("mysql:host=localhost;dbname=numbers",'root','');
	$sth = $con->prepare("DELETE FROM numbers WHERE (calling_number = '$numba' AND country_calling_code = '$area')");	
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	$sth = $con->prepare("DELETE FROM reviews WHERE (calling_number = '$numba' AND country_calling_code = '$area')");	
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	

	header("Location: numberlist.php" );
?>