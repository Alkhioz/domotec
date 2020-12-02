
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
	$ambiente = $_POST["ambiente"];
	$categoria = $_POST["categoria"];
	$tipo = $_POST["t_actuador"];
	$nombre = $_POST["nombre"];
	$pin = $_POST["pin"];
	if(isset($nombre)){
		//$salt = substr ($correo,0,2);
                //$cifrada = crypt($_POST['clave'],$salt);
		$sql = "insert into actuador (idactuador, nombre, estado, tipo) values('{$pin}', '{$nombre}', 0, '{$tipo}');";
		$result = pg_query($dbconn, $sql);
		
		if(!$result){
  			echo pg_last_error($dbconn);
                        //echo "Error."
		} else {
			$sql = "insert into amb_cat_act values('{$ambiente}', '{$categoria}', '{$pin}');";
	                $result = pg_query($dbconn, $sql);
	
        	        if(!$result){
                	        echo pg_last_error($dbconn);
                       	 //echo "Error."
               		 } else {
                       		 header("Location: ./ambiente.php");
               		 }

			//header("Location: ./usuario.php");
		}
	}
}
pg_close($dbconn);
?>
