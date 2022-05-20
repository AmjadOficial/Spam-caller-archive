<?php
if (isset($_POST["commentsubmit"])) {
	$str = $_POST["calling_number"];
	
	$area = substr($str, 0, 4);
	$numba = substr($str, 4, 13);
	$review_danger = $_POST['rating3'];
	$message = $_POST['message'];
	$review_charge = $_POST['yes_no'];
	$review_name = $_POST['review_name'];
	$con = new PDO("mysql:host=localhost;dbname=numbers",'root','');
	$date = date("d/m/Y");
	
	$sth = $con->prepare("INSERT INTO reviews (`country_calling_code`,`calling_number`,`danger`,`review`,`is_charging`, `user_name`, `date`)
				VALUES ('$area','$numba', '$review_danger', '$message','$review_charge','$review_name', '$date')");
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	$sth = $con->prepare("UPDATE numbers SET last_call = '$date' WHERE (calling_number = '$numba' AND country_calling_code = '$area')");
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	$number_of_entries = 0;
	$sum_of_ratings = 0;
	
	$sth = $con->prepare("SELECT * FROM reviews WHERE (calling_number = '$numba' AND country_calling_code = '$area')");	
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	
	while ($row = $sth->fetch()){
		$sum_of_ratings += $row->danger;
		$number_of_entries++;
	}
	
	$mean_review_rating = $sum_of_ratings / $number_of_entries;
	
	$mean_review_rating = round($mean_review_rating, 1, PHP_ROUND_HALF_EVEN);
	
	$sth = $con->prepare("UPDATE numbers SET danger_rating = '$mean_review_rating' WHERE (calling_number = '$numba' AND country_calling_code = '$area')");
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	$number_of_entries = 0;
	$no_of_charging = 0;
	$no_of_not_charging = 0;
	
	$sth = $con->prepare("SELECT * FROM reviews WHERE (calling_number = '$numba' AND country_calling_code = '$area')");	
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	
	while ($row = $sth->fetch()){
		
		if($row->is_charging == true){ 
			$no_of_charging++; 
		}
		else{ 
			$no_of_not_charging++; 
		}
	}
	
	if($no_of_charging<$no_of_not_charging){
		$sth = $con->prepare("UPDATE numbers SET charging = '0' WHERE (calling_number = '$numba' AND country_calling_code = '$area')");
		$sth->setFetchMode(PDO:: FETCH_OBJ);
		$sth->execute();
	}
	else{
		$sth = $con->prepare("UPDATE numbers SET charging = '1' WHERE (calling_number = '$numba' AND country_calling_code = '$area')");
		$sth->setFetchMode(PDO:: FETCH_OBJ);
		$sth->execute();
	}
	
	header("Location: response.php?search=".$str."&submit_form=" );
}

?>