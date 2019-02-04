<?php

function loadScores($district){
    $allScores=array("A"=>array(),"B"=>array());
    $n=count($allScores);
    foreach($allScores as $k => $val) {
        // filename for this district_division
        $fn="data/".$district."_".$k.".txt";
        // read file
        $file = fopen($fn,"r");
        $val=fgetcsv($file);
        $allScores[$k]["team1"]=array("name"=>$val[0],"score"=>$val[1]);
        $val=fgetcsv($file);
        $allScores[$k]["team2"]=array("name"=>$val[0],"score"=>$val[1]);
        $val=fgetcsv($file);
        $allScores[$k]["team3"]=array("name"=>$val[0],"score"=>$val[1]);
        // read question
        $val=fgetcsv($file);
        $allScores[$k]["quiz"]=$val[0];
        $allScores[$k]["question"]=$val[1];
        // other info
        $val=fgetcsv($file);
        $allScores[$k]["timeout"]=$val[0];
        fclose($file);
    }
    return $allScores;
}

$district=$_GET["d"];
#$division=$_GET["v"];

$allScores=loadScores($district);

// Encoding array in JSON format
echo json_encode($allScores);

?>
