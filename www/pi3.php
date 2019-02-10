<!DOCTYPE html>
<html>
<head>
	<title>Add Comment</title>
	<link href="styles.css" media="screen" rel="stylesheet" type="text/css"/>
</head>

<?php 
$db_connection = mysql_connect("localhost", "cs143", "");
mysql_select_db("CS143", $db_connection);
?>

<body style="display: flex; flex-direction: column; align-items: center;">
	<nav>
		<a href="pi1.php">Add a New Actor or Director</a>
		<a href="pi2.php">Add a New Movie</a>
		<a style="background-color: #78647e; color: white;" href="pi3.php">Add a Review Comment</a>
		<a href="pi4.php">Add an Actor to a Movie</a>
		<a href="pi5.php">Add a Director to a Movie</a>
		<a href="ps1.php">Search</a>
	</nav>

	<h1>Add Comment</h1>

	<section>
		<form action="pi3.php" method="POST">
			<div>
				<label>Username:</label>
				<input required type="text" name="username" size=20 maxlength=20>
			</div>
			
			<div>
				<label>Movie:</label>
				<select required name="movie">
					<option hidden disabled selected value> -- select a movie -- </option>
					<?php
					$query = "SELECT id, title FROM Movie;";
					$rs = mysql_query($query, $db_connection);

					while ($row = mysql_fetch_row($rs)) {
						echo "<option value=\"{$row[0]}\">{$row[1]}</option>";
					}
					?>
				</select>
			</div>
			
			<div>
				<label>Rating:</label>
				<select required name="rating">
					<option hidden disabled selected value> -- select a rating -- </option>
					<option value="5">5 stars</option>
					<option value="4">4 stars</option>
					<option value="3">3 stars</option>
					<option value="2">2 stars</option>
					<option value="1">1 star</option>
				</select>
			</div>
			
			<div>
				<label>Comment:</label>
				<textarea required name="comment" rows="10" cols="50"></textarea>
			</div>
			
			<input type="submit" value="Submit" />
		</form>
	</section>
	

	<?php
	if (!empty($_POST["username"]) && !empty($_POST["movie"]) && !empty($_POST["rating"]) && !empty($_POST["comment"])) {

		$mysql_date_now = date("Y-m-d H:i:s");

		$query = "INSERT INTO Review (name, time, mid, rating, comment) VALUES ('{$_POST["username"]}', '{$mysql_date_now}', {$_POST["movie"]}, {$_POST["rating"]}, '{$_POST["comment"]}');";

		$rs = mysql_query($query, $db_connection);
		// Query handling
		if (!$rs) {
			echo $query;
			echo "<br>Invalid field(s).";
		}
		else echo "<h3>Successfully added comment to database.</h3>";

		mysql_close($db_connection);
	}
	?>

</body>
</html>
