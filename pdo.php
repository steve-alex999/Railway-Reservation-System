<?php


require_once 'dbconfig.php';
 
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
 
try{
 // create a PostgreSQL database connection
 $pdo = new PDO($dsn);
 
 // display a message if connected to the PostgreSQL successfully
 if($pdo){
// echo "Connected to the <strong>$db</strong> database successfully!";
 }
}catch (PDOException $e){
 // report error message
 echo $e->getMessage();
}


/*try{
	$pdo = new PDO("pgsql:host='localhost';dbname='Project';
user='postgres';password='Mahi9@'");
	echo "Connected to the  database successfully!"
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	echo $e->getMessage();
}
*/
