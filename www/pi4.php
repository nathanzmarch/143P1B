<!DOCTYPE html>
<html>
<head>
	<title>Add Movie Actor Relation</title>
	<link href="styles.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<nav>
		<a href="pi1.php">Add a New Actor or Director</a>
		<a href="pi2.php">Add a New Movie</a>
		<a href="pi3.php">Add a Review Comment</a>
		<a style="background-color: #64758A; color: white;" href="pi4.php">Add an Actor to a Movie</a>
		<a href="pi5.php">Add a Director to a Movie</a>
		<a href="ps1.php">Search</a>
	</nav>

	<h1>Add Movie Actor Relation</h1><br>
	<h5>Please wait while movies and actors populate.</h5>

	<form action="pi4.php" method="POST">
		Actor:
		<select name="actmenu">
			<?php
			$db_connection = mysql_connect("localhost", "cs143", "");
			mysql_select_db("CS143", $db_connection);
			if(isset($_POST["actmenu"])){
					echo "<option selected> " . $_POST["actmenu"];
			}else{
					echo "<option selected> --";

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
				if(isset($_POST["movmenu"])){
						echo "<option selected> " . $_POST["movmenu"];
				}else{
						echo "<option selected> --";
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
	if(!isset($_POST["actmenu"]) and !isset($_POST["movmenu"])){
	}else if(isset($_POST["actmenu"]) and isset($_POST["movmenu"])) {

		// Grab query
		$name = split(" ", $_POST["actmenu"]);
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
		$query = "SELECT id FROM Movie WHERE title ='" . $_POST["movmenu"] . "';";
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
		$query = "INSERT INTO MovieActor VALUES($movid, $actid, '" . $_POST["role"] ."');";
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
