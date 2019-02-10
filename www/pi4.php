<!DOCTYPE html>
<html>
<head>
	<title>Add Movie Actor Relation</title>
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
		<a href="pi3.php">Add a Review Comment</a>
		<a style="background-color: #64758A; color: white;" href="pi4.php">Add an Actor to a Movie</a>
		<a href="pi5.php">Add a Director to a Movie</a>
		<a href="ps1.php">Search</a>
	</nav>

	<h1>Add Movie Actor Relation</h1>
	<h5>Please wait while movies and actors populate.</h5>

	<section>
		<form action="pi4.php" method="POST">
			<div>
				<label>Actor:</label>
				<select required name="actmenu">
					<option hidden disabled selected value> -- select an actor -- </option>
					<?php
					$query = "SELECT id, CONCAT(first, \" \", last) FROM Actor;";
					$rs = mysql_query($query, $db_connection);

					while ($row = mysql_fetch_row($rs)) {
						echo "<option value=\"{$row[0]}\">{$row[1]}</option>";
					}
					?>
				</select>
			</div>

			<div>
				<label>Movie:</label>
				<select required name="movmenu">
					<option hidden disabled selected value> -- select an movie -- </option>
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
				<label>Role:</label>
				<input required type="text" name="role" size=20 maxlength=50><br>
			</div>
				
			<input type="submit" value="Submit" />
		</form>
	</section>
	
	<?php
	if(!empty($_POST["actmenu"]) && !empty($_POST["movmenu"]) && !empty($_POST["role"])) {
		
		$query = "INSERT INTO MovieActor VALUES('{$_POST["movmenu"]}', '{$_POST["actmenu"]}', '{$_POST["role"]}');";
		$rs = mysql_query($query, $db_connection);
		if (!$rs) echo "<h3>Unable to add movie actor relation.</h3>";
		else echo "<h3>Successfully added movie actor relation.</h3>";

		mysql_close($db_connection);
	}
	?>


</body>
</html>
