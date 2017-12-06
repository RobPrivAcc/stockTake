<?php
    error_reporting(0);
    @ini_set('display_errors', 0);
    
    include('../connection.php');
    
    $name = $_POST[name];


$pdo = new PDO($server, $user, $password);

$sql = "SELECT [ReStock Quantity] ,[Replenishment Amount] FROM Stock WHERE [Name of Item] = '".$name."'";

$query = $pdo->prepare($sql);
$query->execute();

$minMaxArray = array();

for($i=0; $row = $query->fetch(); $i++){
    
    $min = round($row['ReStock Quantity']);
    $max = round($row['Replenishment Amount']);
    $minMaxArray[] = $min;
    $minMaxArray[] = $max;
    
}
echo json_encode($minMaxArray);
//echo $min;
?>