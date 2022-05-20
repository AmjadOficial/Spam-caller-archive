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
		<a href="new_entry.php">New Entry</a>
		<a href="dangerous.php">High Risk Numbers</a>
  		<a href="about.php">About</a>
	</div>
</body>
</html>


<?php
$con = new PDO("mysql:host=localhost;dbname=numbers",'root','');

if (isset($_GET["submit_form"])) {
	$str = $_GET["search"];
	$area = substr($str, 0, 4);
	$numba = substr($str, 4, 13);
	$cell = substr($str, 0, 10);
	$space = substr($str, 10, 13);
	$stringlen = strlen($str);
	$sth = $con->prepare("SELECT * FROM numbers WHERE (calling_number = '$numba' AND country_calling_code = '$area') OR (calling_number = '$cell' AND $stringlen = 10)");
	
	$sth->setFetchMode(PDO:: FETCH_OBJ);
	$sth->execute();
	
	if ($row = $sth->fetch()) {
		?><br><br><br>
		<table class="num_table">
			<thead>
				<tr>
					<th>Country</th>
					<th>Calling Number</th>
					<th>Danger Rating (0-5)</th>
					<th>Last Call Date</th>
					<th>Charging</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo $row->country_calling_code;?></td>
					<td><?php echo $row->calling_number;?></td>
					<td><?php echo $row->danger_rating;?></td>
					<td><?php if ($row->last_call!="NULL") echo $row->last_call; else echo "-";?></td>
					<td><?php if ($row->charging) echo "Yes"; else echo "No";?></td>
				</tr>
			</tbody>
		</table>
<?php	
		$area = $row->country_calling_code;
		$numba = $row->calling_number;
		
		
		$sth = $con->prepare("SELECT * FROM reviews WHERE (calling_number = '$numba' AND country_calling_code = '$area')");
		$sth->setFetchMode(PDO:: FETCH_OBJ);
		$sth->execute();

		while ($row = $sth->fetch()){
			echo"<div class =\"box rbox\">";
				 echo "<div class=\"review_details\"> Reviewer Name: "; 
				 echo $row->user_name."<br> Danger rate: ";
				 echo $row->danger." &nbsp&nbsp&nbsp&nbsp  Did it charge you? : ";
				 if ($row->is_charging) {echo "Yes &nbsp&nbsp&nbsp&nbsp  Date of call: ";} else {echo "No &nbsp&nbsp&nbsp&nbsp Date of call: ";}
				 echo $row->date."</div>";
				 echo "<p class= \"comment\">";
				 echo $row->review;
				 echo "</p>";
			echo"</div>";
		}
		
		echo "<div class =\"box lbox\">
				<form method = \"post\" action = \"submitcomment.php\">
					<h3>Name:</h3> <input type = 'text' class='searchTermc' name = 'review_name' placeholder = 'Your name' required>
					
					<h3>Danger rating:</h3>

					    <div class='rating-group'>
					        <input disabled checked class='rating__input rating__input--none' name='rating3' id='rating3-none' value='0' type='radio'>
					        <label aria-label='1 star' class='rating__label' for='rating3-1'><i class='rating__icon rating__icon--star fa fa-exclamation-triangle'></i></label>
					        <input class='rating__input' name='rating3' id='rating3-1' value='1' type='radio'>
					        <label aria-label='2 stars' class='rating__label' for='rating3-2'><i class='rating__icon rating__icon--star fa fa-exclamation-triangle'></i></label>
					        <input class='rating__input' name='rating3' id='rating3-2' value='2' type='radio'>
					        <label aria-label='3 stars' class='rating__label' for='rating3-3'><i class='rating__icon rating__icon--star fa fa-exclamation-triangle'></i></label>
					        <input class='rating__input' name='rating3' id='rating3-3' value='3' type='radio'>
					        <label aria-label='4 stars' class='rating__label' for='rating3-4'><i class='rating__icon rating__icon--star fa fa-exclamation-triangle'></i></label>
					        <input class='rating__input' name='rating3' id='rating3-4' value='4' type='radio'>
					        <label aria-label='5 stars' class='rating__label' for='rating3-5'><i class='rating__icon rating__icon--star fa fa-exclamation-triangle'></i></label>
					        <input class='rating__input' name='rating3' id='rating3-5' value='5' type='radio'>
					    </div>

					<h3>Did this call charge you?</h3>

						<div class='yn-group'>
							<input type='radio' name='yes_no' value='1' checked>Yes</input>
							
							
							<input type='radio' name='yes_no' value='0'>No</input>
							
					    </div>

					<h3>Leave your feedback about this number below:</h3><textarea class='searchTermc' name = 'message' placeholder='Your feedback...'></textarea><br>
					
					<input type=\"hidden\" name=\"calling_number\" value=" .$area.$numba. ">
					
					<button type = 'submit' name ='commentsubmit' class='searchButton sub'>Submit</button>
				</form>
			</div>";		
			?><?php
	}
	else {
		header ("Location: error.php");
		exit;
	}
}?>