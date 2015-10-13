<?php ob_start(); ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Control de subastas</title>
	<?php
		require("cabeceras.php");
	?>
</head>
<body>
	<?php
		require("estructura.php");
	?>   
  
<?php

require 'autoload.php';  //Es el archivo que nos perimte acceder a la insfraestructura de parse
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;


 //Se inicializa parse
ParseClient::initialize('bFJ9w2UrSrhYMMmIDQUGvSzkVLcAXesZcskm2gYw', 'Ca3UwLI0pNPTumGD4tgYAcXr2RHo5fKPfNFbhvAj', 'BWiEHPsKpxwPh6xN3zsNvZzmWisPvob7faV0e2xS');
	  
	if(isset($_POST['enviar_Push']))  //VERIFICA SI SE PRESIONO EL BOTON
		 {
       //  echo "Enviando";
				 enviarPush();

		 }
		 else
		 {

		 }
#Nos imprime los usuarios en una tabla con su respectivo botón
function imprimirUsuarios()
{
$userQuery = ParseUser::query();
$userQuery->notEqualTo("username","tUKgzMsZ09LbLIIdwSZyIH1PVcu24aEcMpxcWH4A");
$results = $userQuery->find();
#Cuantos resultados recibio de la base de datos de parse
//echo "Successfully retrieved " . count($results) . " scores.<br>"; 
// Do something with the returned ParseObject values
for ($i = 0; $i < count($results); $i++) {
  $object = $results[$i];
  //echo $object->getObjectId() . ' - ' . $object->get('username');
  $_strUsuario=$object->get('username');
  $_strUsuarioTO=$object->getObjectId();
  $arraynombre = explode('&', $_strUsuario);
 echo "<tr>";
 echo "<td>".$arraynombre[0] ."</td>";
 echo "<form action='' method='POST' >";
 echo "<td align='right'> <input type='text' value='Mensaje' name='send'>"."</td>";
 echo "<td> <input type='submit' value='Enviar Mensaje' name='enviar_Push'>"."</td>";
 echo "</tr>"; 
 echo "<input type='hidden' value=$_strUsuario name='nombreUsuario'>";
 echo "</form> ";
  /*
 echo '<'.'input type='.'"submit"'. 'value="'. $object->get('username').'"';
 echo "<input type='hidden' value=$costo  name='costo'>";
 echo "<br>";
*/
}
}

/**
Envia la notificacion a cierto usuario
**/
function enviarPush()
{
  $_strName=$_POST['nombreUsuario'];;
  $_strMenssage=$_POST['send'];

  
	// Find users near a given username
$userQuery = ParseUser::query();
$userQuery->equalTo("username", $_strName);

// Find devices associated with these users
$pushQuery = ParseInstallation::query();
$pushQuery->matchesQuery('Usuarios', $userQuery);



// Send push notification to query
ParsePush::send(array(
  "where" => $pushQuery,
  "data" => array(
    "alert" => "$_strMenssage"
  )
));

}

function probar()
{
$testObject = ParseObject::create("TestObject");
$testObject->set("foo", "bar");
$testObject->save();
}



?>

<html>
 <head>
  <title>Prueba de PHP</title>
  <?php
		require("cabeceras.php");
	?>
 </head>
 <body>
   		require("estructura.php");
   <table>
 <?php imprimirUsuarios(); ?>
 </table>
 </body>
 <?php ob_end_flush(); ?> 
</html>

