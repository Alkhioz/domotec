<?php
// select * from usuario where nombreusuario='rmendoza2368' and claveacceso='123456';

session_start();
$host = "localhost";
$port = "5432";
$dbname = "domotica";
$user = "domo";
$password = "123456";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";

if ( ! empty( $_POST ) ) {
    $dbconn = pg_connect($connection_string);
    

    if ( isset( $_POST['usuario'] ) && isset( $_POST['clave'] ) ) {
            $result = pg_query($dbconn, "SELECT id, nombreusuario, rol from usuario where nombreusuario='".$_POST['usuario']."' and claveacceso='".$_POST['clave']."'");
	    while ($row = pg_fetch_row($result)) {
		  $_SESSION['user_id'] = $row[0];
          	  $_SESSION['user_name'] = $row[1];
		  $_SESSION['user_rol'] = $row[2];
		}
            
    	/*if ( $_POST['usuario'] === "ale" && $_POST['clave'] === "123") {
    		$_SESSION['user_id'] = 1;
    	}*/
    }
    pg_close($dbconn);
}

if ( isset( $_SESSION['user_id'] ) ) {
    header("Location: ./");
} 

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DOMOTEC | Sistema de domotica</title>
<link rel="shortcut icon" href="icono.ico" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="./assets/css/main.css">

</head>
<body>
 <div class="info">
	<div class="info_imagen"></div>
	<div class="info_contenido">
		<center><p class="titulo">DOMOTEC</p>
		<p class="texto">Con esta solución informática controle de forma remota todos los ambientes de su hogar. Las distancias dejan de
                afectar, puede controlar los equipos de su hogar desde cualquier parte del mundo donde tenga acceso a interet.</p>
	<a href="#ingresar"><button>EMPEZAR</button></a><br>
	</center>
	</div>
</div>

	<div class="loginform" id="ingresar">
         
	  <form class="login animate" action="./login.php" method = "post">
            <br><br><div class="logotipo">
              <img src="logo.png" alt="logo" class="logo">
              <br><span class="letra_logo">DOMOTEC</span>
              <br><span class="descripcion_logo">Control inteligente del hogar</span>
            </div>

	    <div class="container">
	      <input type="text" placeholder="Nombre de usuario" name="usuario" required>
	      <input type="password" placeholder="contraseña" name="clave" required>
	      <button type="submit" class="boton_full">Ingresar</button>
	    </div>
	  </form>
	</div>


  </div>
<!--
<div class="price">
<br><p class="titulo">Precio Planes</p>
<div class="row">
  <div class="column">
    <div class="card">
      <div class="container">
        <h2>Sencillo</h2>
        <p class="cuota">Cuota mensual de suscripción 10$</p>
        <p>Permite el control de hasta 5 equipos</p>
        <p>Costo instalación 200$</p>
        <p><button class="boton_full">Ordenar</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <div class="container">
        <h2>Royale</h2>
        <p class="cuota">Cuota mensual de suscripción 40$</p>
        <p>Permite el control de hasta 15 equipos</p>
        <p>Costo instalación 300$</p>
        <p><button class="boton_full" >Ordenar</button></p>
      </div>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
      <div class="container">
        <h2>Platinum premium</h2>
        <p class="cuota">Cuota mensual de suscripción 10$</p>
        <p>Permite el control de hasta 45 equipos</p>
        <p>Costo instalación 1000$</p>
        <p><button class="boton_full">Ordenar</button></p>
      </div>
    </div>
  </div>
  
</div>
</div>
-->
</body>
</html>
