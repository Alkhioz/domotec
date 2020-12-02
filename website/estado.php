<?php 
//header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

$host = "localhost";
$port = "5432";
$dbname = "domotica";
$user = "domo";
$password = "123456";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";

$dbconn = pg_connect($connection_string);

$result = pg_query($dbconn, "SELECT idactuador, estado FROM actuador ORDER BY idactuador");
if (!$result) {
    echo "An error occurred.\n";
    exit;
}

$arr = pg_fetch_all($result);
pg_close($dbconn);
$Obj->data = $arr;
echo json_encode($Obj);
?>
