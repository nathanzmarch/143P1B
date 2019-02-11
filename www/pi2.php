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


	<h1>Add movie</h1>

	<section>
		<form action="pi2.php" method="POST">
			<div>
				<label>Title:</label>
				<input required type="text" name="title" size=20 maxlength=20>
			</div>
			
			<div>
				<label>Company:</label>
				<input type="text" name="company" size=20 maxlength=20>
			</div>

			<div>
				<label>Year:</label>
				<input required type="number" name="year" size=20 maxlength=20>
			</div>

			<div>
				<label>MPAA Rating:</label>
				<select required name="rating">
					<option value="G">G</option>
					<option value="PG">PG</option>
					<option value="PG-13">PG-13</option>
					<option value="R">R</option>
					<option value="NC-17">NC-17</option>
				</select>
			</div>

			<div id="genre-boxes">
				<label>Genre:</label>
				<div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Action">
						<label>Action</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Adult">
						<label>Adult</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Animation">
						<label>Animation</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Comedy">
						<label>Comedy</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Crime">
						<label>Crime</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Documentary">
						<label>Documentary</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Drama">
						<label>Drama</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Family">
						<label>Family</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Fantasy">
						<label>Fantasy</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Horror">
						<label>Horror</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Musical">
						<label>Musical</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Mystery">
						<label>Mystery</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Romance">
						<label>Romance</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Sci-Fi">
						<label>Sci-Fi</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Short">
						<label>Short</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Thriller">
						<label>Thriller</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="War">
						<label>War</label>
					</div>
					<div>
						<input type="checkbox" name="genre_list[]" value="Western">
						<label>Western</label>
					</div>
				</div>

			</div>

			<input type="submit" value="Submit" />
		</form>
	</section>
	

	<?php
	if (!empty($_POST["title"]) && !empty($_POST["year"]) && !empty($_POST["rating"])) {

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

		if (empty($_POST["company"])) $comp = "NULL";
        else $comp = "'{$_POST["company"]}'";

		$query = "INSERT INTO Movie (id, title, year, rating, company) VALUES ({$id}, '{$_POST["title"]}', {$_POST["year"]}, '{$_POST["rating"]}', {$comp});";

		$rs = mysql_query($query, $db_connection);
		// Query handling
		if (!$rs) {
			echo $query;
			echo "<h3>Invalid field(s).</h3>";
		}

		if (!empty($_POST['genre_list'])) {
			foreach ($_POST['genre_list'] as $selected) {
				$query = "INSERT INTO MovieGenre (mid, genre) VALUES ({$id}, '{$selected}')";
				$rs = mysql_query($query, $db_connection);
				if (!$rs) {
					echo $query;
					echo "<h3>Invalid genre(s).</h3>";
				}
			}
		}

		if (!$rs) {
			echo $query;
			echo "<h3>Invalid genre(s).</h3>";
		}
		else echo "<h3>Successfully added movie to database.";

		mysql_close($db_connection);
	}

	?>


</body>
</html>
