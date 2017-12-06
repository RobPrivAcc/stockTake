<?php
include('../connection.php');
$supplierList = json_decode($_POST['supplierList']);
//print_r($supplierList);

$db = new PDO($server, $user, $password);


for ($i=0;$i < count($supplierList);$i++){
    
    
        $sql = "UPDATE Stock SET [ReStock Quantity] = '".$supplierList[$i][1]."', [Replenishment Amount] = '".$supplierList[$i][2]."' WHERE [Name of Item] = '".$supplierList[$i][0]."';";

  
    $query = $db->prepare($sql);
    $query->execute();
    
    //echo $sql."<BR/>";
}

echo "<div class='alert alert-success'>
  <strong>Done!</strong> Products updated.
</div>";
    //$db = new PDO($server, $user, $password);
  /*  $ai = json_decode($_POST[minMaxArray]);
    print_r($ai);*/
    
?>