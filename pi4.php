<!DOCTYPE html>
<html>
<head>
	<title>Add Movie Actor Relation</title>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<h1 style="margin-top: 100px; margin-bottom: 0;">Add Movie Actor Relation</h1><br>
	<h5>Please wait while movies and actors populate.</h5>

	<form action="pi4.php" method="GET">
		Actor:
		<select name="actmenu">
			<?php
			if(isset($_GET["actmenu"])){
					echo "<option selected> " . $_GET["actmenu"];
			}else{
					echo "<option selected> --";
					$db_connection = mysql_connect("localhost", "cs143", "");
					mysql_select_db("CS143", $db_connection);
					$query = "SELECT CONCAT(first, \" \", last) FROM Actor;";
					$rs = mysql_query($query, $db_connection);

					if (!$rs) {
						echo $query;
						echo "<br>Could not obtain actor data.";
					}else{
						while ($row = mysql_fetch_row($rs)) {
							$temp = "<option> ";
							foreach ($row as $val) {
								if ($val) $temp .= $val;
							}
							echo "$temp";
						}
					}


			}

			?>
			</select><br>

			Role:
      <input type="text" name="role" size=20 maxlength=50><br>
			Movie:
			<select name="movmenu">
				<?php
				if(isset($_GET["movmenu"])){
						echo "<option selected> " . $_GET["movmenu"];
				}else{
						echo "<option selected> --";
						$db_connection = mysql_connect("localhost", "cs143", "");
						mysql_select_db("CS143", $db_connection);
						$query = "SELECT title FROM Movie;";
						$rs = mysql_query($query, $db_connection);

						if (!$rs) {
							echo $query;
							echo "<br>Could not obtain actor data.";
						}else{
							while ($row = mysql_fetch_row($rs)) {
								$temp = "<option> ";
								foreach ($row as $val) {
									if ($val) $temp .= $val;
								}
								echo "$temp";
							}
						}
				}


				?>
				</select><br>
      <input type="submit" value="Submit" />
   </form>

   <br>

	<?php
	if(!isset($_GET["actmenu"]) and !isset($_GET["movmenu"])){
	}else if(isset($_GET["actmenu"]) and isset($_GET["movmenu"])) {
		// Connection init
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

		// Grab query
		$name = split(" ", $_GET["actmenu"]);
		$query = "SELECT id FROM Actor WHERE first='$name[0]' and last='$name[1]';";
		// Sanitizing inputs actually breaks string matching for some reason
		// $sanitized_query = mysql_real_escape_string($query, $db_connection);
		$rs = mysql_query($query, $db_connection);
		$actid = 0;
    while ($row = mysql_fetch_row($rs)) {
      foreach ($row as $val) {
        if ($val) {
          $actid = $val;
          break;
        }
      }
    }

		// Grab query
		$query = "SELECT id FROM Movie WHERE title ='" . $_GET["movmenu"] . "';";
		// Sanitizing inputs actually breaks string matching for some reason
		// $sanitized_query = mysql_real_escape_string($query, $db_connection);
		$rs = mysql_query($query, $db_connection);
		$movid = 0;
    while ($row = mysql_fetch_row($rs)) {
      foreach ($row as $val) {
        if ($val) {
          $movid = $val;
          break;
        }
      }
    }
		// Grab query
		$query = "INSERT INTO MovieActor VALUES($movid, $actid, '" . $_GET["role"] ."');";
		// Sanitizing inputs actually breaks string matching for some reason
		// $sanitized_query = mysql_real_escape_string($query, $db_connection);
		$rs = mysql_query($query, $db_connection);

		// Query handling
		if (!$rs) {
			echo $query;
			echo "<br>Unable to add movie actor relation.";
		}
		else {
			echo "<br>Successfully added movie actor relation.";
			header("Refresh:0; url=pi4.php");
		}

		mysql_close($db_connection);
	}else{
		echo "<br>Invalid field. Please select an actor and movie.";
	}
	?>


</body>
</html>
