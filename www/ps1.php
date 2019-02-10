<!DOCTYPE html>
<html>
<head>
	<title>Search for movie of actor information</title>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<h1 style="margin-top: 100px; margin-bottom: 0;">Search for movie of actor information</h1><br>
	<h5>Note: tables and fields are case sensitive.</h5>

	<form action="ps1.php" method="GET">
      Name:
      <input type="text" name="name" size=20 maxlength=20><br>
      <input type="submit" value="Submit" />
   </form>

   <br>
	 <h2>Actor Results</h2>
	<?php
	if($_GET["name"]) {
		// Connection init
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

		$name = split(" ", $_GET["name"]);
		$arrlength = count($name);

		$query = "SELECT * FROM Actor WHERE ";

		for($x = 0; $x < $arrlength; $x++) {
			if($x > 0) $query .= " and ";
		  $query .= "(first = '" . $name[$x] . "' or last = '" . $name[$x] . "')";
			if($x == $arrlength - 1) $query .= ";";
		}


    // Sanitizing inputs actually breaks string matching for some reason
    // $sanitized_query = mysql_real_escape_string($query, $db_connection);
    $rs = mysql_query($query, $db_connection);

		// Query handling
		if (!$rs) {
			echo $query;
			echo "<br>Invalid query or field. Please enter a valid SELECT query.";
		}
		else if (mysql_num_fields($rs)) {
				echo "<table border=1>";

				// Column name row
				echo "<tr>";
				$i = 0;
				while ($i < mysql_num_fields($rs)) {
					$schema = mysql_fetch_field($rs);
					echo "<td> $schema->name </td>";
					$i++;
				}
				echo "</tr>";

				// Everything else
				$found = 0;
				while ($row = mysql_fetch_row($rs)) {
					echo "<tr>";
					foreach ($row as $val) {
						echo "<td>";
						if ($val) echo "$val";
						else echo "N/A";
						echo "</td>";
					}
					echo "</tr>";
					$found++;
				}


				echo "</table>";
				if($found == 0){
					echo "No results matched this query.";
				}
			}

			mysql_close($db_connection);
		}

	?>
	<h2>Matched Movies</h2>
	<?php
	if($_GET["name"]) {
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
    // Sanitizing inputs actually breaks string matching for some reason
    // $sanitized_query = mysql_real_escape_string($query, $db_connection);
    $rs = mysql_query($query, $db_connection);

		// Query handling
		if (!$rs) {
			echo $query;
			echo "<br>Invalid query or field. Please enter a valid SELECT query.";
		}else if (mysql_num_fields($rs)) {
				echo "<table border=1>";

				// Column name row
				echo "<tr>";
				$i = 0;
				while ($i < mysql_num_fields($rs)) {
					$schema = mysql_fetch_field($rs);
					echo "<td> $schema->name </td>";
					$i++;
				}
				echo "</tr>";

				// Everything else
				$found = 0;
				while ($row = mysql_fetch_row($rs)) {
					echo "<tr>";
					foreach ($row as $val) {
						echo "<td>";
						if ($val) echo "$val";
						else echo "N/A";
						echo "</td>";
					}
					echo "</tr>";
					$found++;
				}

				echo "</table>";
				if($found == 0){
					echo "No results matched this query.";
				}
			}

			mysql_close($db_connection);
		}

	?>


</body>
</html>
