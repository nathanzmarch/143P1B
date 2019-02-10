<!DOCTYPE html>
<html>
<head>
	<title>Add movie</title>
	<link href="styles.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<nav>
		<a href="pi1.php">Add a New Actor or Director</a>
		<a style="background-color: #965573; color: white;" href="pi2.php">Add a New Movie</a>
		<a href="pi3.php">Add a Review Comment</a>
		<a href="pi4.php">Add an Actor to a Movie</a>
		<a href="pi5.php">Add a Director to a Movie</a>
		<a href="ps1.php">Search</a>
	</nav>


	<h1>Add movie</h1><br>

	<form action="pi2.php" method="POST">
		<label>Title:</label>
		<input type="text" name="title" size=20 maxlength=20><br>

		<label>Year:</label>
		<input type="number" name="year" size=20 maxlength=20><br>

		<label>MPAA Rating:</label>
		<select name="rating">
			<option hidden disabled selected value> -- select a rating -- </option>
			<option value="G">G</option>
			<option value="PG">PG</option>
			<option value="PG-13">PG-13</option>
			<option value="R">R</option>
			<option value="NC-17">NC-17</option>
		</select><br>

		<label>Company:</label>
		<input type="text" name="company" size=20 maxlength=20><br>

		<br>
		<input type="submit" value="Submit" />
	</form>
	<br>

	<?php
	if (isset($_POST["title"], $_POST["year"], $_POST["rating"], $_POST["company"])) {

		// Connection init
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

		// Get unique id
		$id = 1;
		while (true) {
			$sql = "SELECT id FROM Movie WHERE id=$id";
			if (mysql_num_rows(mysql_query($sql)) <= 0) break;
			$id++;
		}

		$query = "INSERT INTO Movie (id, title, year, rating, company) VALUES ({$id}, '{$_POST["title"]}', {$_POST["year"]}, '{$_POST["rating"]}', '{$_POST["company"]}');";

		$rs = mysql_query($query, $db_connection);
		// Query handling
		if (!$rs) {
			echo $query;
			echo "<br>Invalid field(s).";
		}
		else echo "Successfully added movie to database.";

		mysql_close($db_connection);
	}

	?>


</body>
</html>
