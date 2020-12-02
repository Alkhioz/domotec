
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cliene Web | Improvisado</title>
</head>
<body>
	<center>
		<h1>WEBDUINO</h1>
		<h3>Panel de control remoto arduino super basico</h3>
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
		} else {
  			//echo "Actualizacion exitosa.<br>";
		}
	}
}


 if($dbconn){
 //   echo "Conectado a ". pg_host($dbconn); 
}else{
    echo "Error in connecting to database.";
}


$result = pg_query($dbconn, "SELECT * FROM actuador ORDER BY idactuador");
if (!$result) {
    echo "An error occurred.\n";
    exit;
}

$arr = pg_fetch_all($result);
pg_close($dbconn);
echo "<pre>";
	echo "<table><tr><th>PIN</th><th>NOMBRE</th><th>ESTADO</th><th>ACCION</th></tr>";
	for($i = 0; $i < sizeof($arr); $i++){
		if($arr[$i]['estado'] == '0'){
			$estado = "Apagado";
			$accion = "Encender";
			$v_accion = 1;
			$color = "green";
		}else if ($arr[$i]['estado'] == '1'){
                        $estado = "Encendido";
			$accion = "Apagar";
			$v_accion = 0;
			$color = "red";
		}
		echo "<tr><td><form action='/main.php' method='post' enctype='multipart/form-data'>";
		echo "<input name='pin' type='text' style='border: none;width: 10px;'  value='".$arr[$i]['idactuador']."' readonly></td>";
		echo "<td>".$arr[$i]['nombre']."</td><td>".$estado."</td>";
		echo "<td><button type='submit' name='estado' value='".$v_accion."' style='width: 100%;";
		echo " color: white; background-color: ".$color.";'>".$accion."</button></form></td></tr>";
	}
	echo "</table>";
echo "</pre>"; 
echo "<br />";
?>
<h4>Creado por <a href="https://github.com/Alkhioz/">Alkhioz</a> 2019.</h4>
</center>
</body>
</html> 
