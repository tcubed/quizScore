<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($_POST);
//function file_build_path(...$segments) {
//    return join(DIRECTORY_SEPARATOR, $segments);
//}
//var_dump($_POST);

$district=$_POST["d"];
$division=$_POST["v"];
$quiz=$_POST["qz"];
$q=$_POST["q"];
$timeout=$_POST["TO"];
//$fn=file_build_path("data",$district."_".$division.".txt");
$fn="data/".$district."_".$division.".txt";
echo $fn;

$name1 = $_POST["name1"];
$score1= $_POST["score1"];

$name2 = $_POST["name2"];
$score2= $_POST["score2"];

$name3 = $_POST["name3"];
$score3= $_POST["score3"];
    
$fp = fopen($fn, "w");
$s = $name1 . "," . $score1 . "\n";
fwrite($fp, $s);
$s = $name2 . "," . $score2 . "\n";
fwrite($fp, $s);
$s = $name3 . "," . $score3 . "\n";
fwrite($fp, $s);

$s= $quiz. "," . $q ."\n";
fwrite($fp,$s);

$s=$timeout."\n";
fwrite($fp,$s);

fclose($fp);
echo ": updated";
?>