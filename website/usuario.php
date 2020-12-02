
<?php
// You'd put this code at the top of any "protected" page you create

// Always start this first
session_start();

if ( isset( $_SESSION['user_id'] ) &&  $_SESSION['user_rol'] == 0) {
   
} else {
    header("Location: ./login.php");
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content">
    <a href="./">Control del hogar</a>
    <a href="./usuario.php">Manejo de usuarios</a>
    <a href="./ambiente.php">Manejo de ambientes</a>
    <a href="./logout.php">Salir</a>
  </div>
</div>

 <center>
  <br>
  <div class="card_img">
   
    <div class="container">
      <h4><b><?php echo $_SESSION['user_name']; ?> </b></h4>
    </div>
  </div>
 <br><span style="font-size:30px;cursor:postr2booler" onclick="openNav()">&#9776;</span>
<br>
<br>
<div class="indexmain">
<?php


$host = "localhost";
$port = "5432";
$dbname = "domotica";
$user = "domo";
$password = "123456";
$pg_options = "--client_encoding=UTF8";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} options='{$pg_options}'";

?>

<button class="accordion">Nuevo Usuario</button>
        <div class="panel">
               <form action="./save_usuario.php" method="post">
		<p><input required type="text" placeholder="Nombre" name="nombre"><input required type="text" placeholder="Apellido" name="apellido">
		<input required type="text" placeholder="Nombre de usuario" name="usuario"><input required type="password" placeholder="Contraseña" name="clave">
		<button type="submit" style="width:100%" >Guardar</button></p>
		</form>
	</div>

<button class="accordion">Gestionar Usuarios</button>
        <div class="panel">
               
               <table>
		<tr>
			<th>Nombre Completo</th>
			<th>Nombre de usuario</th>
			<th>Acción</th>
		</tr>
		<?php
			$dbconn = pg_connect($connection_string);
			$result = pg_query($dbconn, "SELECT * FROM usuario where id != ".$_SESSION['user_id'].' and rol = 1');
			/*if (!$result) {
    				echo "An error occurred.\n";
    				exit;
			}*/
			$arr = pg_fetch_all($result);
        		for ($i=0; $i<sizeof($arr);$i++){
				echo '<tr><td>'.$arr[$i]['nombre'].' '.$arr[$i]['apellido'].'</td>';
				echo '<td>'.$arr[$i]['nombreusuario'].'</td>';
                		echo '<td><form action="./delete_usuario.php" method="post"><input style="display:none;" type="text" name="id" value="'.$arr[$i]['id'].'"><button type="submit">Eliminar</button></form></td></tr>';
        		}  

		?>
	       </table>
              
        </div>


</div>
</center>

<script>

// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
function openNav() {
  document.getElementById("myNav").style.height = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.height = "0%";
}
</script>
</body>
</html> 

