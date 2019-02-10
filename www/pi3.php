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
	<h1 style="margin-top: 100px; margin-bottom: 0;">Add Comment</h1><br>

	<form action="pi3.php" method="POST">
		<label>Username:</label>
		<input type="text" name="username" size=20 maxlength=20><br>

		<label>Movie:</label>
		<select name="movie">
			<option hidden disabled selected value> -- select a movie -- </option>
			<?php
			$query = "SELECT id, title FROM Movie;";
			$rs = mysql_query($query, $db_connection);

			while ($row = mysql_fetch_row($rs)) {
				echo "<option value=\"{$row[0]}\">{$row[1]}</option>";
			}
			?>
		</select><br>

		<label>Rating:</label>
		<select name="rating">
			<option hidden disabled selected value> -- select a rating -- </option>
			<option value="5">5 stars</option>
			<option value="4">4 stars</option>
			<option value="3">3 stars</option>
			<option value="2">2 stars</option>
			<option value="1">1 star</option>
		</select><br>

		<label>Comment:</label>
		<textarea name="comment" rows="40" cols="50"></textarea><br>

		<br>
		<input type="submit" value="Submit" />
	</form>
	<br>

	<?php
	if (isset($_POST["username"], $_POST["movie"], $_POST["rating"], $_POST["comment"])) {

		$mysql_date_now = date("Y-m-d H:i:s");

		$query = "INSERT INTO Review (name, time, mid, rating, comment) VALUES ('{$_POST["username"]}', '{$mysql_date_now}', {$_POST["movie"]}, {$_POST["rating"]}, '{$_POST["comment"]}');";

		$rs = mysql_query($query, $db_connection);
		// Query handling
		if (!$rs) {
			echo $query;
			echo "<br>Invalid field(s).";
		}
		else echo "Successfully added comment to database.";

		mysql_close($db_connection);
	}
	?>

</body>
</html>
