<?php
$min = 5.76;
$packSize = 1;

echo "min : ".$min."<br/>";
echo "pack size : ".$packSize."<br/>";
echo "modulo : ".$min%$packSize."<br/><br/><br/>";

while ($min%$packSize != 0){
                $min++;
                echo $min.'<br/>';
            }
            ?>