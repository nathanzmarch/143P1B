<!DOCTYPE html>
<html>
<head>
	<title>Actor Information</title>
	<link href="styles.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<nav>
		<a href="pi1.php">Add a New Actor or Director</a>
		<a href="pi2.php">Add a New Movie</a>
		<a href="pi3.php">Add a Review Comment</a>
		<a href="pi4.php">Add an Actor to a Movie</a>
		<a href="pi5.php">Add a Director to a Movie</a>
	</nav>

	<h1 style="margin-top: 100px; margin-bottom: 0;">Actor Information</h1><br>

	<?php
	if (isset($_GET["id"])) {
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

		$query = "SELECT * FROM Actor WHERE id={$_GET["id"]}";
		$rs = mysql_query($query, $db_connection);
		if (!$rs || !mysql_num_rows($rs)) {
			echo "Invalid actor ID.";
		}
		else {
			$row = mysql_fetch_row($rs);
			echo "<span>Name: </span><span>$row[2] $row[1]</span><br>";
			echo "<span>Sex: </span><span>$row[3]</span><br>";
			echo "<span>DOB: </span><span>$row[4]</span><br>";
			echo "<span>DOD: </span>";
			echo (empty($row[5]) ? "<span>N/A</span><br>" : "<span>$row[5]</span><br>");

			echo "<h2>Movie Roles</h2>";

			$query = "SELECT * FROM MovieActor WHERE aid={$_GET["id"]}";
			$rs = mysql_query($query, $db_connection);

			while ($movie_actor_row = mysql_fetch_row($rs)) {
				$movie_query = "SELECT * FROM Movie WHERE id={$movie_actor_row[0]}";
				$movie_rs = mysql_query($movie_query, $db_connection);
				$movie_row = mysql_fetch_row($movie_rs);

				echo "<span>{$movie_actor_row[2]}</span>";
				echo "<span>in</span>";
				echo "<a href=\"pb2.php?id={$movie_row[0]}\">{$movie_row[1]}</a><br>";
			}
		}	

	}
	?>




</body>
</html>
