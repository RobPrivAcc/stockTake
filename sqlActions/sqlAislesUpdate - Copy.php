<?php
error_reporting(0);
@ini_set('display_errors', 0);

$aisle= $_POST[aisle];
$ean = $_POST[ean];
$mode = $_POST[mode];

include('../connection.php');
$pdo = new PDO($server, $user, $password);

$sql = "SELECT count(*) FROM Stock
  inner join [ProductBarcodes] on Stock.[Name of Item] = ProductBarcodes.NameOfItem
  where ProductBarcodes.Barcode = '".$ean."'";
//$sql = "SELECT count(*) FROM Stock WHERE Barcode = '".$ean."'";


$query = $pdo->prepare($sql);
$query->execute();
$number_of_rows = $query->fetchColumn();	

$sql = "SELECT * FROM Stock
  inner join [ProductBarcodes] on Stock.[Name of Item] = ProductBarcodes.NameOfItem
  where ProductBarcodes.Barcode = '".$ean."'";

$query = $pdo->prepare($sql);
$query->execute();

switch ($mode){
	  case "update":
			if($number_of_rows == 1){ 
				  for($i=0; $row = $query->fetch(); $i++){
						if($row['WarehouseLocation'] == "-"){
							  $name = $row['Name of Item'];
							  $sqlUpdate = "UPDATE Stock SET WarehouseLocation = '".$aisle."' WHERE [Name of Item]  = '".$name."';";
							 $queryUpdate = $pdo->prepare($sqlUpdate);
								$queryUpdate->execute();
							echo "Product ".$name." was added to aisle ".$aisle;
						}else{
							  echo $row['WarehouseLocation'];
						}
				  }
			}else if($number_of_rows > 1){
				  for($i=0; $row = $query->fetch(); $i++){
					  echo "Duplicated barcode<br/>";
					  echo $i.") Product ".$row['Name of Item']." barcode: ".$ean."<br/>";
				  }
			}else{
				echo "Wrong barcode";
			}
	  break;

	  case "check":
	  	  		for($i=0; $row = $query->fetch(); $i++){
				  $table = "<TABLE>";
				  $table .= "<tr><TD class=\"text-center\"><strong>Product Name</strong></TD><TD>".$row['Name of Item']."</TD></TR>";
				  $table .= "<tr><TD class=\"text-center\"><strong>Barcode</strong></TD><TD>".$ean."</TD></TR>";
				  $table .= "<tr><TD class=\"text-center\"><strong>Location</strong></TD><TD>".$row['WarehouseLocation']."</TD></TR>";
				  $table .="</TABLE>";
			}
			echo $table;
	  break;

	  case "updateConfirm":
			$name = "";
			for($i=0; $row = $query->fetch(); $i++){
				  $name = $row['Name of Item'];
			}
	  	  		$sqlUpdate = "UPDATE Stock SET WarehouseLocation = '".$aisle."' WHERE  [Name of Item]  = ".$name."';";
							 
							  $queryUpdate = $pdo->prepare($sqlUpdate);
							  $queryUpdate->execute();
							  echo "Product ".$name." was moved to aisle ".$aisle;
	  break;
}
      unset($pdo);
      unset($query);
?>