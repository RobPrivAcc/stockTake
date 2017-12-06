<?php
error_reporting(0);
@ini_set('display_errors', 0);

include('../connection.php');

$todayDate = $_POST[todayDate];
$calculationResult = $_POST[calculationResult];
$currentQty = $_POST[currentQty];
$ean = $_POST[ean];

if($currentQty == '0.0'){
    $currentQty = '0';
}

$pdo = new PDO($server, $user, $password);

$sql = "UPDATE Stock SET [LastStockQuantity] = '".$currentQty."', [LastStockDate] = '".$todayDate.".001', [Quantity] = '".$calculationResult."' WHERE Barcode = '".$ean."'";


$query = $pdo->prepare($sql);
$query->execute();
echo "Updated";
?>