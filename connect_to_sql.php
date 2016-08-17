<?php

// Set the database access information as constants.
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'root');
DEFINE ('DB_HOST', 'localhost:3306');
DEFINE ('DB_NAME', 'apartments_db');

// Make the connnection, select the database and assign the connection script the $dbc.
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

?>
