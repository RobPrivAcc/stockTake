<?php
$supplierList = $_POST['supplierList'];
include('../connection.php');
include('../config.php');
include('../classes/classSum.php');

$minMax = new summaryClass($server, $user, $password);

    $db = new PDO($server, $user, $password);
    
    $updateArray = array();
    
    $sql = "SELECT [Name of Item]
      ,[Supplier Cost]
      ,[PackSize]
      ,[Quantity]
      
      ,[ReStock Quantity]
      ,[Replenishment Amount]
      
  FROM [Stock] WHERE Discontinued = '0' AND SupplierName = '$supplierList';";

  
    $query = $db->prepare($sql);
    $query->execute();

    $div = "<DIV class = 'row'>";
    
    for($i=0; $row = $query->fetch(); $i++){
        $minMaxArray = array();
        
        $productName = $row['Name of Item'];
        $packSize = $row['PackSize'];
        $div .= "<DIV class = 'col-xs-12 col-s-12 col-12' style = 'border-bottom: 1px solid black;'>";
            $div .= "<DIV class = 'row'>";
            
                $div .= "<DIV class = 'col-s-12 col-12'><strong>";
                    $div .= $row['Name of Item']."  (".round($packSize,0).")    Weakly avarage(".($minMax->getMonth($productName)/4).")    (".date('Y-m-d', strtotime('-1 month')).")";
                $div .= "</strong></DIV>";
            $div .= "</DIV>";
            
            $div .= "<DIV class = 'row'>";
                $div .= "<DIV class = 'col-s-4 col-4'>";
                    $div .= "Current QTY: ".round($row['Quantity'],2);
                $div .= "</DIV>";
                $div .= "<DIV class = 'col-s-4 col-4'>";
                    $newMin = $minMax->getMin($productName,$minProc,$packSize);
                    $div .= "MIN: ".round($row['ReStock Quantity'],2)." -> (".$newMin.")";
                $div .= "</DIV>";
                $div .= "<DIV class = 'col-s-4 col-4'>";
                    $newMax = $minMax->getMax($productName,$maxProc,$packSize);
                    $div .= "MAX: ".round($row['Replenishment Amount'],2)." -> (".$newMax.")";
                $div .= "</DIV>";                
            $div .= "</DIV>";
            
        $div .= "</DIV>";
        
        $updateArray[] = array($productName,$newMin,$newMax);
    }
    $div .="</DIV>";
        $div .= "<DIV class = 'row'>";
        $div .= "<DIV class = 'col-s-4 col-4'>";
            
            $div .="<input type ='hidden' id='minMaxArray' value='".json_encode($updateArray)."'/>";
            $div .="<button class='btn btn-primary' onclick = 'minMaxUpdateValues();'>Update</button>";
        $div .= "</DIV>";                
        $div .= "</DIV>";
	
    echo $div;
    
?>