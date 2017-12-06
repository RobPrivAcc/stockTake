<?php
include('../connection.php');

$searchField = $_POST['searchField'];

    $db = new PDO($server, $user, $password);
    $sql = "SELECT
        [Name of Item]
      ,[Quantity]
      ,[BarCode]
      ,[CaseBarcode]
      ,[PackSize]
      ,[CodeSup]
      ,[Manufacturer]
      ,[LastStockQuantity]
      ,[InternalRefCode]
      ,[WarehouseLocation]
      ,[Discontinued]
      FROM Stock WHERE BarCode = '".$searchField."'";
      
      $table = "<div class='row'>";
      $table .= "<div class='col-xs-12'>";
      $table .= "<table>";
      $name = "";
    $smt = $db->prepare($sql);

    $smt->execute();
    while ($row = $smt->fetch()){
        $name = "<H4>".$row[0]."</H4>";
        $table .= "<tr>";
            $table .= "<td class = 'tableCellFontSize'><strong>Name of Item</strong></td><td>".$row[0]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>Quantity</strong></td><td><span id='currentQty'>".$row[1]."</span></td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>BarCode</strong></td><td><span id='ean'>".$row[2]."</span></td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td><strong>Warehouse Location</strong></td><td>".$row[9]."</td>";
        $table .="</tr>";
        $table .="<tr>";
            $table .= "<td></td><td></td>";
        $table .="</tr>";
        
        $table .="<tr>";
            $table .= "<td><strong>Full bags QTY</strong></td><td><input type = \"text\" id = \"fullBagsQty\" value = \"0\" size = \"4\"/></td>";
        $table .="</tr>";
        
        $table .="<tr>";
            $table .= "<td><strong>Full Bags weight in kg</strong></td>";
             
            $table .= "<td id='selectBigBagsPlace'>";
            
            $table .= "</td>";
        $table .="</tr>";
        
        $table .="<tr>";
            $table .= "<td><strong>Small bags QTY</strong></td><td><input type = \"text\" id = \"smallBagsQty\" size = \"4\"/></td>";
        $table .="</tr>";        
        
        $table .="<tr>";
            $table .= "<td><strong>Small Bags weight in kg</strong></td>";
             
            $table .= "<td id='selectSmallBagsPlace'>";
            
            $table .= "</td>";
        $table .="</tr>";
    }
    $table .= "</table>";
    $table .= "</div>";
    $table .= "</div>";
    
    $table .= "<div class='row'>";
        $table .= "<div class='col-xs-8' id = 'calculationResultLbl'>";
        
        $table .= "</div>";
        $table .= "<div class='col-xs-4' id = 'calculationResult'>";
        
        $table .= "</div>";
    $table .= "</div>";
    
    $table .= "<div class='row'>";
                $table .= "<div class='col-xs-6' id = 'calculateBtnPlace'>";
                    $table .= '<button type="button" name="calculateBtn" id = "calculateBtn" class = "btn btn-primary" onclick = "calculateBagQty();">';
                        $table .= '<i class="icon-refresh" aria-hidden="true"></i> Calculate';
                    $table .= '</button>&nbsp;';
                $table .= "</div>";
                
                $table .= "<div class='col-xs-6' id = 'updateQtyBtnPlace'>";
                $table .= "</div>";                
    $table .= "</div>";
    $name .= $table;
    $today = date("Y-m-d H:i:s");
    
    $name .= "<input type = 'hidden' id='todayDate' value = '".$today."'>";
    echo $name."<br/>".$today;
?>