
<?php
// You'd put this code at the top of any "protected" page you create

// Always start this first
session_start();

if ( isset( $_SESSION['user_id'] ) ) {
   
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
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<link rel="manifest" href="./manifest.json" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="./assets/css/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>


<div id="myNav" class="overlay">
<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
<div class="overlay-content">


<?php

if($_SESSION['user_rol'] == 0){
echo '<a href="./">Control del hogar</a>';
echo '<a href="./usuario.php">Manejo de usuarios</a>';
echo '<a href="./ambiente.php">Manejo de ambientes</a>';
}
?>
<a href="./logout.php">Salir</a>
</div>
</div>



 <center>
  <br>
  <div class="card_img">
  <!--  <img src="./assets/img/ale.jpg" alt="Avatar" style="width:100%"> -->
    <div class="container">
      <h4><b><?php echo $_SESSION['user_name']; ?> </b></h4>
    </div>
  </div>
 <br>

<span style="font-size:30px;cursor:postr2booler" onclick="openNav()">&#9776;</span><br><br>


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

	<div class="tab">

<?php

$dbconn = pg_connect($connection_string);

$result = pg_query($dbconn, "SELECT * FROM hambiente");
if (!$result) {
    echo "An error occurred.\n";
    exit;
}
$arr = pg_fetch_all($result);
        for ($i=0; $i<sizeof($arr);$i++){
                echo '<button class="tablinks" onclick="openCity(event, \''.$arr[$i]['nombre'].'\')" id="defaultOpen">'.$arr[$i]['nombre'].'</button>';
        }
	echo '</div>';
        for ($i=0; $i<sizeof($arr);$i++){
                echo '<div id="'.$arr[$i]['nombre'].'" class="tabcontent">';

		$result = pg_query($dbconn, "SELECT idcategoria, nombre FROM categoria join amb_cat_act on id_categoria = idcategoria and id_ambiente =".$arr[$i]['idhambiente'].' group by idcategoria');
		if (!$result) {
    			echo "An error occurred.\n";
    			//exit;
		}
		$arr2 = pg_fetch_all($result);
		for ($j=0; $j<sizeof($arr2);$j++){
                        
                	//echo $arr2[$j]['nombre'];
			echo '<button class="accordion"> '.$arr2[$j]['nombre'].'</button>';
			echo '<div class="panel">';
                        //echo ':s';
			$result = pg_query($dbconn, 'select idactuador, nombre, tipo,estado from actuador join amb_cat_act on id_categoria = '.$arr2[$j]['idcategoria'].' and id_ambiente = '.$arr[$i]['idhambiente'].' and idactuador = id_actuador');
                	/*if (!$result) {
                        	echo "An error occurred.\n";
                        	exit;
                	}*/
                	$arr3 = pg_fetch_all($result);
			for ($k=0; $k<sizeof($arr3);$k++){	
				if($arr3[$k]['tipo'] == 2){
					echo '<div class="slidecontainer">';
                 	 		echo '<span>'.$arr3[$k]['nombre'].' </span>';
                  			echo '<input type="range" min="0" max="100" value="'.$arr3[$k]['estado'].'" class="slider" id="'.$arr3[$k]['nombre'].'">';
                			echo '</div>';
			  	}else if($arr3[$k]['tipo'] == 1){
					echo '<p><span>'.$arr3[$k]['nombre'].' </span>';
			                echo '<label class="switch">';
					if($arr3[$k]['estado'] == 0){
						echo '<input type="checkbox" id="'.$arr3[$k]['nombre'].'">';
					}else if($arr3[$k]['estado'] == 1){
						echo '<input type="checkbox" id="'.$arr3[$k]['nombre'].'" checked="true">';
					}
                  			echo '<span class="slider2 round"></span></label></p>';
				}
			}
			echo '</div>';
     		 }

		echo '</div>';
        }

?>


</div>
</center>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

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

function str2bool(st) {
  if(st){
  	return 1;
  }else{
  	return 0;
  }
}
function enviar(pin, estado){
	$.ajax({
	    type: 'POST',    
	    url:'http://liriodelirante.com:8080/cambiar.php',
            dataType : "html",
	    contentType: "application/x-www-form-urlencoded",
	    data:'pin='+pin+'&estado='+estado,
	    success: function(msg){
		//alert('wow' + msg);
	    }
	  });
}

<?php
$result = pg_query($dbconn, "SELECT * FROM hambiente");
$arr4 = pg_fetch_all($result);
for ($i=0; $i<sizeof($arr4);$i++){
        $result = pg_query($dbconn, "SELECT idcategoria, nombre FROM categoria join amb_cat_act on id_categoria = idcategoria and id_ambiente =".$arr4[$i]['idhambiente'].' group by idcategoria');
        $arr5 = pg_fetch_all($result);
	for ($j=0; $j<sizeof($arr5);$j++){
		$result = pg_query($dbconn, 'select idactuador, nombre, tipo from actuador join amb_cat_act on id_categoria = '.$arr5[$j]['idcategoria'].' and id_ambiente = '.$arr4[$i]['idhambiente'].' and idactuador = id_actuador');
                $arr6 = pg_fetch_all($result);
		for ($k=0; $k<sizeof($arr6);$k++){
				if($arr6[$k]['tipo']==1){
			        echo 'document.getElementById("'.$arr6[$k]['nombre'].'").oninput = function(){';
				echo ' console.log(this.checked);  enviar('.$arr6[$k]['idactuador'].', str2bool(this.checked));} ';
				} else if($arr6[$k]['tipo']==2){
				echo ' document.getElementById("'.$arr6[$k]['nombre'].'").oninput = function(){';
                                echo ' console.log(this.value);  enviar('.$arr6[$k]['idactuador'].', this.value);} ';
				}
				echo " \n ";
                        }
	}
}

//echo 'intermitencia.oninput{';
  //enviar(47, this.value);
//echo 'console.log("prueba");';
pg_close($dbconn);
?>

/*intermitente.oninput = function() {
  enviar(47, this.value);
  console.log(this.value);
}
enviar(48, str2bool(this.checked))*/




/* $.getJSON("./estado.php", function(result){
      for (x=0;x<result.data.length;x++){
        	console.log(result.data[x].idactuador);
                if(result.data[x].idactuador == 44 && result.data[x].estado == 1){
			estufa.checked = true;
		}
		if(result.data[x].idactuador == 45 && result.data[x].estado == 1){
			lavadora.checked = true;
		}
		if(result.data[x].idactuador == 49 && result.data[x].estado == 1){
			fbano.checked = true;
		}
                if(result.data[x].idactuador == 46 && result.data[x].estado == 1){
			smtv.checked = true;
		}
                if(result.data[x].idactuador == 48 && result.data[x].estado == 1){
			luz_principal.checked = true;
		}
                if(result.data[x].idactuador == 47 && result.data[x].estado > 0){
			intermitente.value = result.data[x].estado;
		}
	}
    });*/
</script>
</body>
</html> 

