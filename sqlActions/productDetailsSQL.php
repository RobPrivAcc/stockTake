<?php
$searchField = $_POST['searchField'];
include('../connection.php');

    $db = new PDO($server, $user, $password);
    $sql = "SELECT
               [Name of Item]
              ,[Quantity]
              ,[ProductBarcodes].[Barcode]
              ,[CaseBarcode]
              ,[PackSize]
              ,[CodeSup]
              ,[Manufacturer]
              ,[LastStockQuantity]
              ,[InternalRefCode]
              ,[WarehouseLocation]
              ,TextValue
              ,[Discontinued]
            FROM Stock
                inner join [ProductBarcodes] on Stock.[Name of Item] = ProductBarcodes.NameOfItem
                inner join [StockCustomValues] on [StockCustomValues].NameOfItem = Stock.[Name of Item]
                where StockFieldName = 'location_".$shopName."' AND ProductBarcodes.Barcode = '".$searchField."'";
      echo $sql.'<BR/>';
      $table = "<div class='row'>";
      $table = "<div class='col-xs-12'>";
      $table .= "<table>";
    $smt = $db->prepare($sql);
//echo $sql;
    $smt->execute();
    while ($row = $smt->fetch()){
        $table .= "<tr>";
            $table .= "<td><strong>Name of Item</strong></td><td>".$row[0]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>Quantity</strong></td><td>".$row[1]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>BarCode</strong></td><td>".$row[2]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>Case Barcode</strong></td><td>".$row[3]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>PackSize</strong></td><td>".$row[4]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>Supplier Code</strong></td><td>".$row[5]."</td>";
        $table .="</tr>";
        $table .="<tr>";    
            $table .= "<td><strong>Manufacturer</strong></td><td>".$row[6]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>LastStockQuantity</strong></td><td>".$row[7]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>Internal Code</strong></td><td>".$row[8]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>Warehouse Location</strong></td><td>".$row[9]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>location_".$shopName."</strong></td><td>".$row[10]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>Discontinued</strong></td><td>".$row[11]."</td>";
        $table .="</tr>";
    }
    $table .= "</table>";
    $table .= "</div>";
    $table .= "</div>";
    
    echo $table;
?>