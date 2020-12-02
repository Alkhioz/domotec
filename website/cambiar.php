
<?php 

$host = "localhost";
$port = "5432";
$dbname = "domotica";
$user = "domo";
$password = "123456";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";


$dbconn = pg_connect($connection_string);

$pin = "";
$estado = "";
if(isset($_POST)){
	$pin = $_POST["pin"];
	$estado = $_POST["estado"];
	if(isset($pin) && isset($estado)){
		$sql = "update actuador set estado = '{$estado}' where idactuador = {$pin};";
		$result = pg_query($dbconn, $sql);
		if(!$result){
  			echo pg_last_error($dbconn);
                        //echo "Error."
		} else {
  			echo "Actualizacion exitosa.";
		}
	}
}
pg_close($dbconn);
?>
