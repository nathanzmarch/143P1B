<!DOCTYPE html>
<html>
<head>
	<title>Add actor or director</title>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">
	<h1 style="margin-top: 100px; margin-bottom: 0;">Add actor or director</h1><br>
	<h5>Note: tables and fields are case sensitive.</h5>

	<form action="pi1.php" method="GET">
      Type:
      <select name="typemenu">
        <option selected> Actor
        <option> Director
      </select><br>
      First Name:
      <input type="text" name="fname" size=20 maxlength=20><br>
      Last Name:
      <input type="text" name="lname" size=20 maxlength=20><br>
      Sex:
      <select name="sexmenu">
        <option selected> Male
        <option> Female
        <option> Other
      </select><br>
      Date of Birth:
      <input type="text" name="dob" size=20 maxlength=20>
       YYYY-MM-DD
      <br>
      Date of Death:
      <input type="text" name="dod" value="NULL"size=20 maxlength=20>
       YYYY-MM-DD
      <br>
      <input type="submit" value="Submit" />
   </form>

   <br>

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
                . str_replace("-", "", $_GET["dob"]) . ", " . $_GET["dod"] . ");";
  		// Sanitizing inputs actually breaks string matching for some reason
  		// $sanitized_query = mysql_real_escape_string($query, $db_connection);
  		$rs = mysql_query($query, $db_connection);
    }else{
      $query = "INSERT INTO " . $_GET["typemenu"] . " VALUES (" . $curid . ", '" . $_GET["lname"] .
                "', '" . $_GET["fname"] . "', " . str_replace("-", "", $_GET["dob"])
                . ", " . $_GET["dod"] . ");";
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
