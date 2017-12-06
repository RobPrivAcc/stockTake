<?php
error_reporting(0);
@ini_set('display_errors', 0);

$aisle= $_POST[aisle];
$ean = $_POST[ean];
$mode = $_POST[mode];

include('../classes/classSum.php');
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
							//echo "Product ".$name." was added to aisle ".$aisle;
							echo "<div class='alert alert-success text-center' role='alert'><strong>".$name."</strong> was added to aisle <strong>".$aisle."</strong></div>";
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
				echo "<div class='alert alert-danger text-center' role='alert'>EAN: ".$ean." is wrong.</p>";
			}
	  break;

	  case "check":
		if($number_of_rows > 0){
			for($i=0; $row = $query->fetch(); $i++){
			
			//$saleHistory = new summaryClass();
			$saleHistory = new summaryClass($server, $user, $password);
				
			  $table = "<TABLE class='table table-condensed'>";
			  //$table = "<tbody class = 'table-striped'>";
			  $table .= "<tr><TD><strong>Name</strong></TD><TD>".$row['Name of Item']."</TD></TR>";
			  $table .= "<tr><TD><strong>Barcode</strong></TD><TD>".$ean."</TD></TR>";
			  $table .= "<tr><TD><strong>Location</strong></TD><TD>".$row['WarehouseLocation']."</TD></TR>";
			  $table .= "<tr><TD><strong>selling Price </strong></TD><TD>&euro;".round($row['Selling Price'],2)."</TD></TR>";
			  $table .= "<tr><TD></TD><TD></TD></TR>";
			  $table .= "<tr><TD><strong>Sold in 7 days</strong></TD><TD>".$saleHistory->getSeven($row['Name of Item'])."</TD></TR>";
			  $table .= "<tr><TD><strong>Sold in 14 days</strong></TD><TD>".$saleHistory->getFourteen($row['Name of Item'])."</TD></TR>";
			  $table .= "<tr><TD><strong>Sold in last month</strong></TD><TD>".$saleHistory->getMonth($row['Name of Item'])."</TD></TR>";
			  //$table .="</tbody>";
			  $table .="</TABLE>";
			}
			echo $table;
		}else if($number_of_rows == 0){
			echo "<div class='alert alert-danger text-center' role='alert'>EAN: ".$ean." is wrong.</p>";
		}
	  break;

	  case "updateConfirm":
			$name = "";
			for($i=0; $row = $query->fetch(); $i++){
				  $name = $row['Name of Item'];
			}
			if(isset($name)){
	  	  		$sqlUpdate = "UPDATE Stock SET WarehouseLocation = '".$aisle."' WHERE  [Name of Item]  = '".$name."';";
							 
							  $queryUpdate = $pdo->prepare($sqlUpdate);
							  $queryUpdate->execute();
							 //echo $sqlUpdate;
							  
							  echo "<div class='alert alert-success text-center' role='alert'><strong>".$name."</strong> was moved to aisle <strong>".$aisle."</strong></div>";
			}else{
				echo "<div class='alert alert-danger text-center' role='alert'><strong>".$ean."</strong> was moved to aisle <strong>".$aisle."</strong></div>";
			}
	  break;
}
      unset($pdo);
      unset($query);
?>