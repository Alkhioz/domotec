
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
	$nombre = $_POST["nombre"];
	$descripcion = $_POST["descripcion"];
	if(isset($nombre)){
		//$salt = substr ($correo,0,2);
                //$cifrada = crypt($_POST['clave'],$salt);
		$sql = "insert into hambiente (nombre, descripcion) values('{$nombre}', '{$descripcion}');";
		$result = pg_query($dbconn, $sql);
		if(!$result){
  			echo pg_last_error($dbconn);
                        //echo "Error."
		} else {
  			echo "Actualizacion exitosa.";
			header("Location: ./ambiente.php");
		}
	}
}
pg_close($dbconn);
?>
