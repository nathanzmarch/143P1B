<!DOCTYPE html>
<html>
<head>
	<title>Add Movie Director Relation</title>
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
		<a href="pi4.php">Add an Actor to a Movie</a>
		<a style="background-color: #4A8292; color: white;" href="pi5.php">Add a Director to a Movie</a>
		<a href="ps1.php">Search</a>
	</nav>

	<h1>Add Movie Director Relation</h1>
	<h5>Please wait while movies and Directors populate.</h5>

	<section>
		<form action="pi5.php" method="POST">
			<div>
				<label>Director:</label>
				<select required name="dirmenu">
					<option hidden disabled selected value> -- select an director -- </option>
					<?php
					$query = "SELECT id, CONCAT(first, \" \", last) FROM Director;";
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
				
			<input type="submit" value="Submit" />
		</form>
	</section>

	<?php
	if(!empty($_POST["dirmenu"]) && !empty($_POST["movmenu"])) {

		$query = "INSERT INTO MovieDirector VALUES('{$_POST["movmenu"]}', '{$_POST["dirmenu"]}');";
		$rs = mysql_query($query, $db_connection);

		// Query handling
		if (!$rs) echo "<h3>Unable to add movie Director relation.</h3>";
		else echo "<h3>Successfully added movie Director relation.</h3>";

		mysql_close($db_connection);
	}
	?>


</body>
</html>
