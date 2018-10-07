



<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var_dump($_POST);
$name1 = $_POST["name1"];
$score1= $_POST["score1"];

$name2 = $_POST["name2"];
$score2= $_POST["score2"];

$name3 = $_POST["name3"];
$score3= $_POST["score3"];
    
$fp = fopen("scores.txt", "w");
$s = $name1 . "," . $score1 . "\n";
fwrite($fp, $s);
$s = $name2 . "," . $score2 . "\n";
fwrite($fp, $s);
$s = $name3 . "," . $score3 . "\n";
fwrite($fp, $s);

fclose($fp);
echo "<h1>You data has been saved in a text file!</h1>";
?>