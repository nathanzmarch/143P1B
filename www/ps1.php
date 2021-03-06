<!DOCTYPE html>
<html>
<head>
	<title>Search for a movie or actor</title>
	<link href="styles.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<nav>
		<a href="pi1.php">Add a New Actor or Director</a>
		<a href="pi2.php">Add a New Movie</a>
		<a href="pi3.php">Add a Review Comment</a>
		<a href="pi4.php">Add an Actor to a Movie</a>
		<a href="pi5.php">Add a Director to a Movie</a>
		<a style="background-color: #3c8d99; color: white;" href="ps1.php">Search</a>
	</nav>

	<h1>Search for a movie or actor</h1>

	<section>
		<form action="ps1.php" method="GET">
			<div>
				<label style="color: #434343;">Name: </label>
				<input required type="text" name="name" size=20 maxlength=20>
			</div>

			<input type="submit" value="Submit" />
		</form>
	</section>


	<?php
	if(!empty($_GET["name"])) {
		// Connection init
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

		$name = split(" ", $_GET["name"]);
		$arrlength = count($name);

		$query = "SELECT * FROM Actor WHERE ";

		for($x = 0; $x < $arrlength; $x++) {
			if($x > 0) $query .= " and ";
		  $query .= "(first LIKE '%" . $name[$x] . "%' or last LIKE '%" . $name[$x] . "%')";
			if($x == $arrlength - 1) $query .= ";";
		}
    // Sanitizing inputs actually breaks string matching for some reason
    // $sanitized_query = mysql_real_escape_string($query, $db_connection);
    $rs = mysql_query($query, $db_connection);

		// Query handling
		if (!$rs) {
			echo "<h3>No results matched this query.</h3>";
		}
		else if (mysql_num_fields($rs)) {
				echo "<h2>Actor Results</h2>";

				if (!mysql_num_rows($rs)) echo "<h3>No results matched this query.</h3>";
				else {
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
							if ($val) {
								if ($row[0] == $val || $row[1] == $val || $row[2] == $val) {
									echo "<a href=\"pb1.php?id={$row[0]}\">{$val}</a>";
								}
								else echo "$val";
							}
							else echo "N/A";
							echo "</td>";
						}
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
				}
			}

			mysql_close($db_connection);
		}

	?>

	<?php
	if(!empty($_GET["name"])) {
		// Connection init
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

		$name = split(" ", $_GET["name"]);
		$arrlength = count($name);

		$query = "SELECT * FROM Movie WHERE ";

		for($x = 0; $x < $arrlength; $x++) {
			if($x > 0) $query .= " and ";
		  $query .= "title LIKE '%" . $name[$x] . "%'";
			if($x == $arrlength - 1) $query .= ";";
		}
	    $rs = mysql_query($query, $db_connection);

		// Query handling
		if (!$rs) {
			echo "<h3>No results matched this query.</h3>";
		}
		else if (mysql_num_fields($rs)) {
				echo "<h2>Matched Movies</h2>";

				if (!mysql_num_rows($rs)) echo "<h3>No results matched this query.</h3>";
				else {

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
					$found = 0;
					while ($row = mysql_fetch_row($rs)) {
						echo "<tr>";
						foreach ($row as $val) {
							echo "<td>";
							if ($row[0] == $val || $row[1] == $val) {
								echo "<a href=\"pb2.php?id={$row[0]}\">{$val}</a>";
							}
							else echo "$val";
							echo "</td>";
						}
						echo "</tr>";
					}
					echo "</tbody>";

					echo "</table>";
				}
			}

			mysql_close($db_connection);
		}

	?>


</body>
</html>
