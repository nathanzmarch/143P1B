<!DOCTYPE html>
<html>
<head>
	<title>Movie Information</title>
	<link href="styles.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<nav>
		<a href="pi1.php">Add a New Actor or Director</a>
		<a href="pi2.php">Add a New Movie</a>
		<a href="pi3.php">Add a Review Comment</a>
		<a href="pi4.php">Add an Actor to a Movie</a>
		<a href="pi5.php">Add a Director to a Movie</a>
		<a href="ps1.php">Search</a>
	</nav>

	<h1>Movie Information</h1><br>

	<?php
	if (!empty($_GET["id"])) {
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

		$query = "SELECT title, company, rating FROM Movie WHERE id={$_GET["id"]}";
		$rs = mysql_query($query, $db_connection);
		if (!$rs || !mysql_num_rows($rs)) {
			echo "Invalid movie ID.";
		}
		else {
			$row = mysql_fetch_row($rs);

			// Info
			echo "<section>";
			echo "<h2>Details</h2>";

			echo "<span>Title: </span><span>$row[0]</span><br>";
			echo "<span>Company: </span><span>$row[1]</span><br>";
			echo "<span>Rating: </span><span>$row[2]</span><br>";


			$query = "SELECT * FROM MovieDirector INNER JOIN Director ON did=id WHERE mid={$_GET["id"]}";
			$rs = mysql_query($query, $db_connection);
			if (!mysql_num_rows($rs)) echo "<span>Director: </span><span>N/A</span><br>";
			else {
				$row = mysql_fetch_row($rs);
				echo "<span>Director: </span><span>$row[4] $row[3]</span><br>";
			}

			$query = "SELECT genre FROM MovieGenre WHERE mid={$_GET["id"]}";
			$rs = mysql_query($query, $db_connection);
			echo "<span>Genre: </span>";

			if (!mysql_num_rows($rs)) echo "<span>N/A</span>";
			else {
				while ($movie_genre_row = mysql_fetch_row($rs)) {
					echo "<span>$movie_genre_row[0] </span>";
				}
			}
			echo "</section>";

			
			// Featured actors
			echo "<section>";
			echo "<h2>Featured Actors</h2>";

			$query = "SELECT first, last, role, aid FROM MovieActor MA INNER JOIN Actor A ON A.id=MA.aid WHERE MA.mid={$_GET["id"]}";
			$rs = mysql_query($query, $db_connection);
			if (!mysql_num_rows($rs)) {
				echo "No roles found.";
			}
			else {
				while ($movie_actor_row = mysql_fetch_row($rs)) {
					echo "<div>";
					echo "<a href=\"pb1.php?id={$movie_actor_row[3]}\">$movie_actor_row[0] $movie_actor_row[1]</a>";
					echo "<span> as $movie_actor_row[2]</span>";
					echo "</div>";
				}
				echo "</section>";
			}

			// User reviews
			echo "<section>";
			echo "<h2>User Reviews</h2>";

			$query = "SELECT AVG(rating), COUNT(rating) FROM Review R WHERE R.mid={$_GET["id"]}";
			$rs = mysql_query($query, $db_connection);
			$review_average_row = mysql_fetch_row($rs);
			if (!mysql_num_rows($rs) || !$review_average_row[1]) {
				echo "No reviews found.";
			}
			else {
				echo "<h4>Average score of {$review_average_row[0]} from {$review_average_row[1]} reviews.</h4>";

				$query = "SELECT name AS 'username', time, rating, comment FROM Review R WHERE R.mid={$_GET["id"]}";
				$rs = mysql_query($query, $db_connection);

				echo "<table>";

				// Column name row
				echo "<thead>";
				echo "<tr>";
				$i = 0;
				while ($i < mysql_num_fields($rs)) {
					$schema = mysql_fetch_field($rs);
					echo "<td> $schema->name </td>";
					$i++;
				}
				echo "</tr>";
				echo "</thead>";

				// Everything else
				echo "<tbody>";
				while ($row = mysql_fetch_row($rs)) {
					echo "<tr>";
					foreach ($row as $val) {
						echo "<td>";
						if ($val) echo "$val";
						else echo "N/A";
						echo "</td>";
					}
					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";
	?>
	<form action="pi3.php" method="post">
	    <input type="submit" name="addComment" value="Leave a review"/>
	</form>
	<?php

			}
			echo "</section>";

		}	

	}
	?>

	




</body>
</html>
