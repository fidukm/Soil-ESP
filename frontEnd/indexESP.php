<!DOCTYPE html>
<html lang= "en">
<html>
    <head>
        <title> Plant ESP: Your Home Soil Reader</title>
        <link rel = "stylesheet" type="text/css" href="style.css">
    </head>
    <body class="mainBody">
        <h1 class="header" > Soil ESP </h1>
        <h4 class="welcomeText"> Welcome to Soil ESP's online web application! <br>
            To select a Soil ESP device, click on one of the options below.
        </h4>
        
        <div class="outerBox" id="obox">

			<?php
				$DatabaseAccess = parse_ini_file('database.ini');
				$serverName = $DatabaseAccess['serverName'];
				$connectionOptions = array (
					"database" => $DatabaseAccess['database'],
					"uid" => $DatabaseAccess['uid'],
					"pwd" => $DatabaseAccess['pwd']
				);
			
				$conn = sqlsrv_connect($serverName, $connectionOptions);
				if ($conn === false) {
					echo "Could not connect.\n";
					die(print_r(sqlsrv_errors(), true));
				}
			
				/* Set up and execute the query. */
				$sql = "SELECT * FROM esp8266;";
				$stmt = sqlsrv_query($conn, $sql);
			
				# Loop through all results one row at a time
				while ($result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
				{
					echo "<form action='indexMain.php' method='post'>
							<button type='submit' class='sensorButton' name='esp' value='"
								.$result["esp_id"]."'>".$result["esp_id"]."<br>".$result["description"].
							"</button>
						</form>";
				}
			
				sqlsrv_free_stmt($stmt);
				sqlsrv_close($conn);
			
			?>
        </div> 
        
        <form action="downloadcsv.php" method="post">
            <input type="submit" value="Export Data">
        </form>

    </body>

    
</html>