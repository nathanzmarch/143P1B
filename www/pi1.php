<!DOCTYPE html>
<html>
<head>
    <title>Add actor or director</title>
    <link href="styles.css" media="screen" rel="stylesheet" type="text/css"/>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
    <nav>
        <a style="background-color: #a84c6c; color: white;" href="pi1.php">Add a New Actor or Director</a>
        <a href="pi2.php">Add a New Movie</a>
        <a href="pi3.php">Add a Review Comment</a>
        <a href="pi4.php">Add an Actor to a Movie</a>
        <a href="pi5.php">Add a Director to a Movie</a>
        <a href="ps1.php">Search</a>
    </nav>

    <h1>Add actor or director</h1>

    <section>
        <form action="pi1.php" method="GET">
            <div>
                <label>Type: </label>
                <select name="typemenu">
                    <option selected> Actor
                    <option> Director
                </select>
            </div>
            
            <div>
                <label>First Name: </label>
                <input type="text" name="fname" size=20 maxlength=20>
            </div>
            
            <div>
                <label>Last Name: </label>
                <input type="text" name="lname" size=20 maxlength=20>
            </div>
            
            <div>
                <label>Sex: </label>
                <select name="sexmenu">
                    <option selected> Male
                    <option> Female
                    <option> Other
                </select>
            </div>

            <div>
                <label>Date of Birth (YYYY-MM-DD): </label>
                <input type="text" name="dob" size=20 maxlength=20>
            </div>

            <div>
                <label>Date of Death (YYYY-MM-DD): </label>
                <input type="text" name="dod" value="NULL"size=20 maxlength=20>
            </div>
            
            <input type="submit" value="Submit" />
        </form>
    </section>

	<?php
	if($_GET["fname"] and $_GET["lname"]) {
		// Connection init
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

    // Get Max Id Query
    $query = "SELECT id FROM MaxPersonID";
    // Sanitizing inputs actually breaks string matching for some reason
    // $sanitized_query = mysql_real_escape_string($query, $db_connection);
    $rs = mysql_query($query, $db_connection);
    $curid = 0;
    while ($row = mysql_fetch_row($rs)) {
      foreach ($row as $val) {
        if ($val) {
          $curid = $val;
          break;
        }
      }
    }

    if($_GET["typemenu"] == "Actor"){
      // Grab query
  		$query = "INSERT INTO " . $_GET["typemenu"] . " VALUES (" . $curid . ", '" . $_GET["lname"] .
                "', '" . $_GET["fname"] . "', '" . $_GET["sexmenu"] . "', "
                . str_replace("-", "", $_GET["dob"]) . ", " . str_replace("-", "", $_GET["dod"]) . ");";
  		// Sanitizing inputs actually breaks string matching for some reason
  		// $sanitized_query = mysql_real_escape_string($query, $db_connection);
  		$rs = mysql_query($query, $db_connection);
    }else{
      $query = "INSERT INTO " . $_GET["typemenu"] . " VALUES (" . $curid . ", '" . $_GET["lname"] .
                "', '" . $_GET["fname"] . "', " . str_replace("-", "", $_GET["dob"])
                . ", " . str_replace("-", "", $_GET["dod"]) . ");";
  		// Sanitizing inputs actually breaks string matching for some reason
  		// $sanitized_query = mysql_real_escape_string($query, $db_connection);
  		$rs = mysql_query($query, $db_connection);
    }


		// Query handling
		if (!$rs) {
			echo $query;
			echo "<br>Invalid query or field. Please enter a valid SELECT query.";
		}
		else {
      // Get Max Id Query
      $query = "UPDATE MaxPersonID SET id = " . (((int)$curid) + 1) ;
      // Sanitizing inputs actually breaks string matching for some reason
      // $sanitized_query = mysql_real_escape_string($query, $db_connection);
      $rs = mysql_query($query, $db_connection);
      echo "Successfully added person to database.";
		}

    mysql_close($db_connection);
	}

	?>


</body>
</html>
