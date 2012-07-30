<?php
header('Content-type: text/html; charset=utf-8');
include 'connect_to_mysql.php';
$la = $_GET['la'];
$lo = $_GET['lo'];

$result_city = mysql_query("SELECT * FROM cities ORDER BY ABS(Latitude - '$la') + ABS(Longitude - '$lo') ASC;") or die();
$row_city = mysql_fetch_assoc($result_city);
$regionID = $row_city['RegionID'];
$countryID = $row_city['CountryID'];

$result_state = mysql_query("SELECT * FROM states WHERE regionid = '$regionID'") or die();
$row_state = mysql_fetch_assoc($result_state);
$result_country = mysql_query("SELECT * FROM country WHERE countryid = '$countryID'") or die();
$row_country = mysql_fetch_assoc($result_country);

echo $row_city['City'].", ".$row_state['code'].", ".$row_country['country'];

?>