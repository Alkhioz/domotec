
<?php 

$host = "localhost";
$port = "5432";
$dbname = "domotica";
$user = "domo";
$password = "123456";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";


$dbconn = pg_connect($connection_string);

if(isset($_POST)){
	$id = $_POST["id"];
	if(isset($id)){
		$sql = "delete from usuario where id = {$id} ;";
		$result = pg_query($dbconn, $sql);
		if(!$result){
  			echo pg_last_error($dbconn);
                        //echo "Error."
		} else {
  			//echo "Actualizacion exitosa.";
			header("Location: ./usuario.php");
		}
	}
}
pg_close($dbconn);
?>
