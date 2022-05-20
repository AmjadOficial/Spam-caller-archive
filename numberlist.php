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
 		<a class="active" href="numberlist.php">Number List</a>
		<a href="new_entry.php">New Entry</a>
		<a href="dangerous.php">High Risk Numbers</a>
  		<a href="about.php">About</a>
	</div>
	

	
</body>


</html>

<?php
	$con = new PDO("mysql:host=localhost;dbname=numbers",'root','');

	$sth = $con->prepare("SELECT * FROM numbers");
	
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	
	while ($row = $sth->fetch()){
		?>
		
		<br><br><br>
		<table class="num_table">
			<thead>
				<tr>
					<th>Country</th>
					<th>Calling Number</th>
					<th>Danger Rating (0-5)</th>
					<th>Last Call Date</th>
					<th>Charging</th>
					<th>
					
					<button type="submit"  class="searchButton eye" onclick = "window.location='<?php echo "response.php?search=".$row->country_calling_code.$row->calling_number."&submit_form="; ?>'">
						<i class="fa fa-eye"></i>
					</button>
					
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $row->country_calling_code; ?></td>
					<td><?php echo $row->calling_number; ?></td>
					<td><?php echo $row->danger_rating; ?></td>
					<td><?php if ($row->last_call!="NULL") echo $row->last_call; else echo "-"; ?></td>
					<td><?php if ($row->charging) echo "Yes"; else echo "No"; ?></td>
					
					<td><button type="submit" class="searchButton trash" onclick = "window.location='delete_entry.php?todelete=<?php echo $row->country_calling_code.$row->calling_number; ?>'">
						<i class="fa fa-trash"></i>
					</button></td>
				</tr>
			</tbody>
		</table>
		
		<?php
	}
die;
header('Location: error.php');
exit;
?>
