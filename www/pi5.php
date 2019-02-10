<!DOCTYPE html>
<html>
<head>
	<title>Add Movie Director Relation</title>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<h1 style="margin-top: 100px; margin-bottom: 0;">Add Movie Director Relation</h1><br>
	<h5>Please wait while movies and Directors populate.</h5>

	<form action="pi5.php" method="POST">
		Director:
		<select name="actmenu">
			<?php
			$db_connection = mysql_connect("localhost", "cs143", "");
			mysql_select_db("CS143", $db_connection);
			if(isset($_POST["actmenu"])){
					echo "<option selected> " . $_POST["actmenu"];
			}else{
					echo "<option selected> --";
			}
      
      $query = "SELECT CONCAT(first, \" \", last) FROM Director;";
      $rs = mysql_query($query, $db_connection);

      if (!$rs) {
        echo $query;
        echo "<br>Could not obtain Director data.";
      }else{
        while ($row = mysql_fetch_row($rs)) {
          $temp = "<option> ";
          foreach ($row as $val) {
            if ($val) $temp .= $val;
          }
          echo "$temp";
        }
      }
			?>
			</select><br>

			Movie:
			<select name="movmenu">
				<?php
				if(isset($_POST["movmenu"])){
						echo "<option selected> " . $_POST["movmenu"];
				}else{
						echo "<option selected> --";

				}
        $query = "SELECT title FROM Movie;";
        $rs = mysql_query($query, $db_connection);

        if (!$rs) {
          echo $query;
          echo "<br>Could not obtain Director data.";
        }else{
          while ($row = mysql_fetch_row($rs)) {
            $temp = "<option> ";
            foreach ($row as $val) {
              if ($val) $temp .= $val;
            }
            echo "$temp";
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
		$query = "SELECT id FROM Director WHERE first='$name[0]' and last='$name[1]';";
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
		$query = "INSERT INTO MovieDirector VALUES($movid, $actid);";
		// Sanitizing inputs actually breaks string matching for some reason
		// $sanitized_query = mysql_real_escape_string($query, $db_connection);
		$rs = mysql_query($query, $db_connection);

		// Query handling
		if (!$rs) {
			echo $query;
			echo "<br>Unable to add movie Director relation.";
		}
		else {
			echo "<br>Successfully added movie Director relation.";
			header("Refresh:0; url=pi5.php");
		}

		mysql_close($db_connection);
	}else{
		echo "<br>Invalid field. Please select an Director and movie.";
	}
	?>


</body>
</html>
