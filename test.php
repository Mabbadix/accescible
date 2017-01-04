<?php 
$longueurKey = 16;
$key = "1";
for($i=1;$i<$longueurKey;$i++){
    $key .= mt_rand(0,9);
}
echo "$key";
?>