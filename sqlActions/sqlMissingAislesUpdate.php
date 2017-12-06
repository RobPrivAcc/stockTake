<?php
error_reporting(0);
@ini_set('display_errors', 0);

include('../connection.php');
include('../classes/classAisles.php');

$id = str_replace("_"," ",$_POST[id]);
$id = str_replace("LLL","(",$id);
$id = str_replace("RRR",")",$id);
$id = str_replace('iiii','"',$id);
$id = str_replace('FSFS','/',$id);
$aisle = $_POST[aisle];

$pdo = new PDO($server, $user, $password);
//$sql = "UPDATE Stock SET WarehouseLocation = '".$aisle."' WHERE [Name Of Item] = '".$id."'";
$sql = "UPDATE [StockCustomValues] SET TextValue = '".$aisle."' WHERE  StockFieldName = 'location_".$shopName."' AND [Name Of Item] = '".$id."'";
   $query = $pdo->prepare($sql);
   // $query->execute();
  echo $sql;
?>