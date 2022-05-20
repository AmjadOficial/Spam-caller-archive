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
		<a class="active" href="home.php">Home</a>
        <a href="numberlist.php">Number List</a>
		<a href="new_entry.php">New Entry</a>
		<a href="dangerous.php">High Risk Numbers</a>
  		<a href="about.php">About</a>
 	</div>
    
    <div class="wrap">
        <form class="search" action="response.php" method = "get">
				<input type="text" class="searchTerm" name="search" placeholder="Which number called you?!" maxlength="14">
				<button type="submit" name="submit_form" class="searchButton" value="search">
					<i class="fa fa-search"></i>
				</button>
			
        </form>
    </div>
	<div class="errortext">
		<p>This number does not exist in the database. Would you like to make a new entry?</p>
			<form action="new_entry.php">
				<button class="searchButton yes" value="search">
								yes
				</button>
			</form>
			<form action="home.php">
				<button class="searchButton no">
								no
				</button>
			</form>
	
    </div>
	

	
</body>


</html>