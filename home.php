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
        <form class="search"  method = "GET" action = "response.php">
				<input type="text" name="search" class="searchTerm" placeholder="Which number called you?!" maxlength="14">
				<button type="submit" name="submit_form" class="searchButton">
					<i class="fa fa-search"></i>
				</button>
        </form>
    </div>
</body>


</html>

