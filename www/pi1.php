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
        <form action="pi1.php" method="POST">
            <div>
                <label>Type:</label>
                <select required name="typemenu">
                    <option selected> Actor
                    <option> Director
                </select>
            </div>
            
            <div>
                <label>First Name:</label>
                <input required type="text" name="fname" size=20 maxlength=20>
            </div>
            
            <div>
                <label>Last Name:</label>
                <input required type="text" name="lname" size=20 maxlength=20>
            </div>
            
            <div>
                <label>Sex:</label>
                <select required name="sexmenu">
                    <option selected>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>

            <div>
                <label>Date of Birth (YYYY-MM-DD):</label>
                <input required type="text" name="dob" size=20 maxlength=20>
            </div>

            <div>
                <label>Date of Death (YYYY-MM-DD):</label>
                <input type="text" name="dod" size=20 maxlength=20>
            </div>
            
            <input type="submit" value="Submit" />
        </form>
    </section>

	<?php
	if (isset($_POST["fname"], $_POST["lname"], $_POST["sexmenu"])) {
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);

        $query = "SELECT id FROM MaxPersonID";
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


        if (empty($_POST["dod"])) $dod = "NULL";
        else $dod = "'{$_POST["dod"]}'";

        if($_POST["typemenu"] == "Actor"){

          // Grab query
      		$query = "INSERT INTO " . $_POST["typemenu"] . " VALUES (" . $curid . ", '" . $_POST["lname"] .
                    "', '" . $_POST["fname"] . "', '" . $_POST["sexmenu"] . "', "
                    . str_replace("-", "", $_POST["dob"]) . ", " . $dod . ")";
      		$rs = mysql_query($query, $db_connection);
        }
        else {
          $query = "INSERT INTO " . $_POST["typemenu"] . " VALUES (" . $curid . ", '" . $_POST["lname"] .
                    "', '" . $_POST["fname"] . "', " . str_replace("-", "", $_POST["dob"])
                    . ", " . str_replace("-", "", $_POST["dod"]) . ");";
      		$rs = mysql_query($query, $db_connection);
        }


        // Query handling
        if (!$rs) {
            echo $query;
        	echo "<h3>Invalid field(s). Please check your entries.";
        }
        else {
            // Get Max Id Query
            $query = "UPDATE MaxPersonID SET id = " . (((int)$curid) + 1) ;
            $rs = mysql_query($query, $db_connection);
            echo "Successfully added person to database.";
        }

        mysql_close($db_connection);
	}

	?>


</body>
</html>
