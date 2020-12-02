
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
		$sql = "delete from categoria where idcategoria = {$id} ;";
		$result = pg_query($dbconn, $sql);
		if(!$result){
  			echo pg_last_error($dbconn);
                        //echo "Error."
		} else {
			 $sql = "delete from amb_cat_act where id_categoria = {$id} ;";
                	$result = pg_query($dbconn, $sql);
                	if(!$result){
                        	echo pg_last_error($dbconn);
                        	//echo "Error."
               		} else {
                       	 //echo "Actualizacion exitosa.";
                                $sql = "delete from actuador where idactuador not in(select idactuador from actuador, amb_cat_act where idactuador = id_actuador)";
				pg_query($dbconn, $sql);
                        	header("Location: ./ambiente.php");
                	}

  			//echo "Actualizacion exitosa.";
			//header("Location: ./ambiente.php");
		}
	}
}
pg_close($dbconn);
?>
