<?php
error_reporting(0);
@ini_set('display_errors', 0);

include('../connection.php');

$aisle = $_POST[aisle];


if($currentQty == '0.0'){
    $currentQty = '0';
}

$pdo = new PDO($server, $user, $password);

$sql = "SELECT [Name of Item], [Quantity] ,[BarCode]
        FROM Stock
        inner join [StockCustomValues] on [StockCustomValues].NameOfItem = Stock.[Name of Item]
        WHERE StockFieldName = 'location_".$shopName."' AND TextValue = '".$aisle."' ORDER BY [Name of Item] ASC";


$query = $pdo->prepare($sql);
$query->execute();

$div = "";
$zebra = 1;

for($i=0; $row = $query->fetch(); $i++){
    
    if ($zebra == 1){
         $class = " zebraOn";
         $zebra = 0;
    }else{
        $class = "";
         $zebra = 1;
    }
    
    $name = $row['Name of Item'];
    
    $div .= '<DIV id = "'.$row['Name of Item'].'" class = "row'.$class.' bottomLine">';
            $div .= '<DIV class = "col-xs-10 col-10">';
                $div .= '<DIV class = "row">';
                    $div .= '<DIV class ="col-xs-12 col-12 name"><strong>'.$row['Name of Item'].'</strong></DIV>';
                $div .= '</DIV>';
                $div .= '<DIV class = "row">';
                    $div .= '<DIV class ="col-xs-2 col-2 qty">'.$row['Quantity'].'</DIV>';
                    $div .= '<DIV class ="col-xs-10 col-10 ean">'.$row['BarCode'].'</DIV>';
                $div .= '</DIV>';
            $div .= '</DIV>';
            $div .= '<DIV class = "col-xs-2 col-2">';
            
            $div .= '<div class="vertical-center">';
                $div .= '<i class="fa fa-plus" aria-hidden="true" onclick="expand(\''.$name.'\');"></i>';
            
            $div .= '</DIV>';
            $div .= '</DIV>';
    $div .= '</DIV>';
   
}
echo $div;
?>