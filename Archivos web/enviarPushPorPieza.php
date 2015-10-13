

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

		require("estructura.php");
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
//$result = mysql_query("SELECT *from t_solicitudes where activo=0");
$result = mysql_query("SELECT *from t_solicitudes where activo=1");
$nreg=mysql_num_rows($result);

echo "<table border='1'>";
echo "<th>No.";
echo "<th>Pieza ";
echo "<th>Marca ";
echo "<th>Modelo ";
echo "<th>A�0�9o";
//echo "<th>Duracion";
//echo "<th>Mejor Oferta";
//echo "<th> Utilidad (5-100)";


while($linea = mysql_fetch_array($result))
{
	$conteo++;
	$id=$linea["id"];
	$id_sol=$linea["id_solicitud"];
	$id_cliente=$linea["id_cliente"];
	
eregi('^([a-z]+)([0-9]+)$', $id_cliente, $arreglo);
$_strCliente= implode (  "&" , $arreglo );
  $arraynombre = explode('&', $_strCliente);
$_IDCLiente=$arraynombre[1] ."&". $arraynombre[2];
echo $id_sol;
	//obteniendo datos 
	$consulta=mysql_query("select *from $id_cliente where id='$id_sol' "); // actualiza la tabla del cliente
	$registro = mysql_fetch_array($consulta);
	$costo=$registro["costo"];
	$pieza=$registro["pieza"];
	$marca=$registro["marca"];
	$modelo=$registro["modelo"];		
	$annio=$registro["annio"];	
	
	
// mostrando en pantalla las opciones	
//llenando la tabla
echo "<tr>";
echo "<td> ".$conteo;
echo "<td>".  $id_sol;
echo "<td> ".$pieza;
echo "<td> ".$marca;
echo "<td> ".$modelo;
echo "<td> ".$annio;
echo "<form action='' method='POST' >";
echo "<td align='right'> <input type='text' value='Mensaje' name='send'";//Cambiar a al 
echo "<td> <input type='submit' value='Enviar Mensaje' name='enviarPush'>";
echo "<td> ". $_IDCLiente;
echo "<input type='hidden' value=$_IDCLiente  name='id_cliente'>";
echo "</form> ";

echo "</tr>";

	
}
echo "</table>";	
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
