<?php
error_reporting(0);
@ini_set('display_errors', 0);

$aisle= $_POST[aisle];
$ean = $_POST[ean];
include('../connection.php');

$pdo = new PDO($server, $user, $password);

$sql = "SELECT count(*) FROM Stock WHERE Barcode = '".$ean."'";


$query = $pdo->prepare($sql);
$query->execute();
$number_of_rows = $query->fetchColumn();	

$sql = "SELECT * FROM Stock WHERE Barcode = '".$ean."'";

$query = $pdo->prepare($sql);
$query->execute();

 
if($number_of_rows == 1){ 
      for($i=0; $row = $query->fetch(); $i++){
		  $name = $row['Name of Item'];
		  $sqlUpdate = "UPDATE Stock SET WarehouseLocation = '".$aisle."' WHERE  Barcode = '".$ean."';";
		 
		 //echo $sqlUpdate.'<br/>';
		 $queryUpdate = $pdo->prepare($sqlUpdate);
			$queryUpdate->execute();
        echo "Product ".$name." was added to aisle".$aisle;
      }
}else if($number_of_rows > 1){
	for($i=0; $row = $query->fetch(); $i++){
		echo "Duplicated barcode<br/>";
        echo $i.") Product ".$row['Name of Item']." barcode: ".$ean."<br/>";
      }
}else{
	echo "Wrong barcode";
}
      unset($pdo);
      unset($query);
?>