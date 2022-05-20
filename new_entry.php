<html>

<head>
	<title>SpamCallers</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
</head>

<body>
	<div class="tit" onclick="window.location='home.php'">
        <h1>Spam Caller Archive</h1>
    </div>
    
	<div class = "bar">
		<a href="home.php">Home</a>
        <a href="numberlist.php">Number List</a>
		<a class="active" href="new_entry.php">New Entry</a>
		<a href="dangerous.php">High Risk Numbers</a>
  		<a href="about.php">About</a>
 	</div>
    
    <div class="wrap">
        <form class="search"  method = "get">
				<input type="text" name="country_code_field" class="searchTermcc" placeholder="Country Code Example: 0030" maxlength="4" required>
				<input type="text" name="search"  class="searchTermccc" placeholder="Caller Number Example: 6913625436"  maxlength="10" required>
				<button type="submit" name="submit_number" class="searchButton">
					<i class="fa fa-plus"></i>
				</button>
        </form>
    </div>
</body>


</html>


<?php
try {
	$con = new PDO("mysql:host=localhost;dbname=numbers",'root','');

	if (isset($_GET["submit_number"])) {
		$country_calling_code =  $_GET["country_code_field"];
		$calling_number = $_GET["search"];
		echo $country_calling_code . $calling_number;
		
		$sth = $con->prepare("INSERT INTO numbers (`country_calling_code`,`calling_number`,`danger_rating`,`last_call`,`charging`) VALUES ('$country_calling_code','$calling_number', 'NULL','NULL','NULL')");
		$sth->setFetchMode(PDO:: FETCH_OBJ);
		$sth->execute();
		
		header("Location: response.php?search=".$calling_number."&submit_form=" );
		exit;
	}
}
catch (PDOException $e) { header("Location: response.php?search=".$calling_number."&submit_form=" );  exit;}
?>