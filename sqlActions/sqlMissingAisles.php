<?php
error_reporting(0);
@ini_set('display_errors', 0);

include('../connection.php');
include('../classes/classAisles.php');
$pdo = new PDO($server, $user, $password);

$orderNo = $_POST[orderNo];

$sql = "SELECT [Pkey]
      ,[OrderNo]
      ,[RepSub].[Quantity]
      ,[Nameofitem]
      ,[RepSub].[Barcode]
      ,[TypeOfItem]
      ,[RepSub].[SubType]
      ,[RepSub].[CodeSup]
      ,[RepSub].[PackSize]
      ,[CurrentQuantity]
      ,[TotalCheckedQuantity]
	  ,WarehouseLocation
	  ,[Selling Price]
  FROM [RepSub] 
  inner join Stock on Stock.[Name of Item] = RepSub.Nameofitem
   where OrderNo = '".$orderNo."' AND [TotalCheckedCaseQuantity] >0 and WarehouseLocation = '-' order by CodeSup ASC";
   
$queryCount = "Select count(*)
				FROM [RepSub] 
				  inner join Stock on Stock.[Name of Item] = RepSub.Nameofitem
				   where OrderNo = '".$orderNo."' AND [TotalCheckedCaseQuantity] >0 and WarehouseLocation = '-'";

$query = $pdo->prepare($sql);
$query->execute();

$result = $pdo->prepare($queryCount); 
$result->execute(); 
$number_of_rows = $result->fetch();
if($number_of_rows[0] == '1' ){
	echo "<strong>There is ".$number_of_rows[0]." product left.</strong>";
}else{
	echo "<strong>There are ".$number_of_rows[0]." product left without location.</strong>";
}
echo '<br/><br/>';



$option = new aislesOptions();

$quote = '"';

$div = "<DIV class = 'row'>";
$div .= "<DIV class = 'row'>";
$div .= "<div class='col-xs-12 col-12'>";
$div .= $shopName;
$div .= "</div>";
$div .= "</DIV>";
	$div .= "<div class='col-xs-12 col-12'>";
		for($i=0; $row = $query->fetch(); $i++){
			
			$nameOfItem = $row['Nameofitem'];
			
			$div .= "<div class='row'>";
				$div .= "<div class='col-xs-6 col-6'>";
					$div .= "<div class='row'>";
						$div .= "<div class='col-xs-12 col-12'>".$nameOfItem."</div>";
					$div .= "</div>";
					
					$div .= "<div class='row'>";
						$div .= "<div class='col-xs-12 col-12'>".$row['Barcode']."</div>";
						
					$div .= "</div>";
					
					$div .= "<div class='row'>";
						$div .= "<div class='col-xs-12 col-12'>Selling price: &euro;".round($row['Selling Price'],2)."</div>";
					$div .= "</div>";
				$div .= "</div>";
			$nameOfItem = str_replace(" ","_",str_replace("(","LLL", str_replace(")","RRR",str_replace("\"","iiii",str_replace("/","FSFS",$nameOfItem)))));	
				$div .= "<div class='col-xs-4 col-4'>";
					$div .= "<div class='row'>";
						$div .= "<div class='col-xs-12 col-12'>".$option->getAisles($shopName,"option_".$nameOfItem)."</div>";
					$div .= "</DIV>";
				$div .= "</div>";
		
				$div .= "<div class='col-xs-2 col-2'>";
					$div .= "<div class='row'>";
						$div .= "<div class='col-xs-12 col-12'>";
							$div .= "<div class='input-group-btn'>";
								$div .= "<button type='button' name='searchBtn' id = 'updateBtn' class = 'btn btn-primary' onclick = 'updateAisle($quote$nameOfItem$quote);'>";
									$div .= "<i class='fa fa-floppy-o' aria-hidden='true'></i>";
								$div .="</button>";
							$div .= "</div>";
						$div .= "</div>";
					$div .= "</DIV>";
				$div .= "</div>";
				
			$div .= "</DIV>";
					$div .= "<DIV class = 'row'><div class='col-xs-12 col-12'><HR></DIV></DIV>";
			}
    $div .= "</DIV>";
$div .= "</DIV>";

echo $div;
?>