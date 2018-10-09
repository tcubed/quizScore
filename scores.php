
<?php

header("Refresh:5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Quiz Scores</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv=”refresh” content=”5;url=scoreShow.php" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  
  <style>
  h1{font-size:50px;}      
  </style>
    
  
</head>
<body>

<?php
//function file_build_path(...$segments) {
//    return join(DIRECTORY_SEPARATOR, $segments);
//}
//var_dump($_GET);
$district=$_GET["d"];
$division=$_GET["v"];
//$fn=file_build_path("data",$district."_".$division.".txt");
$fn="data/".$district."_".$division.".txt";

$file = fopen($fn,"r");
$team1=fgetcsv($file);
$team2=fgetcsv($file);
$team3=fgetcsv($file);
$q=fgetcsv($file);
fclose($file);
?>

<div class="card-deck">
    <div class="card">
        <div class="card-body text-center">
            <h1><?php echo $district;?> - <?php echo $division;?></h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <h1>Question: <?php echo $q[0];?></h1>
        </div>
    </div>
</div>
    
    
<div class="card-deck">
    <div class="card bg-danger">
        <div class="card-body text-center">
            
            <span style="font-size:160px">
                <?php echo $team1[1];?>
            </span>
            <h1><?php echo $team1[0];?></h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            
            <span style="font-size:160px">
                <?php echo $team2[1];?>
            </span>
            <h1><?php echo $team2[0];?></h1>
        </div>
    </div>
    <div class="card bg-primary">
        <div class="card-body text-center"> 
            
            <span style="font-size:160px">
                <?php echo $team3[1];?>
            </span>
            <h1><?php echo $team3[0];?></h1>
        </div>
    </div>
</div>

</body>
</html>
