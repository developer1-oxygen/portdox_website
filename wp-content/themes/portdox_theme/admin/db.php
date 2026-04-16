<?php
$servername = "localhost";   
$username = "uerxjzjsrf";         
$password = "ed3M34xWR5";              
$dbname = "uerxjzjsrf";    

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}


$pdo = '';
try 
{
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) 
{
   
    die("Connection failed: " . $e->getMessage());
}

?>
