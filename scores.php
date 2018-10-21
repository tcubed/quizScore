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

<?php
if(array_key_exists("d",$_GET)==0 || array_key_exists("v",$_GET)==0){
    header("url:index.html");
}

$district=$_GET["d"];
$division=$_GET["v"];

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
    $allScores[$k]["q"]=$val[0];
    fclose($file);
}

function activeButton($thisDiv){
    //echo "btn-warning";
    global $division;
    if($division===$thisDiv){echo "btn-warning";}
    else{echo "btn-secondary";}
}
?>

</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <div class="btn-group flex">
            <a class="nav-link btn <?php activeButton("A");?>" href="scores.php?d=WGL&v=A"><h1>Division A
                <span class="badge badge-info"><?php echo $allScores["A"]["q"]; ?></span></h1>
            </a>
            <a class="nav-link btn <?php activeButton("B");?>" href="scores.php?d=WGL&v=B"><h1>Division B
                <span class="badge badge-info"><?php echo $allScores["B"]["q"]; ?></span></h1>
            </a>
        </div>

        <div class="nav navbar-nav navbar-right">
            <a class="nav-link btn btn-secondary" role="button" href="index.html"><h3>Home</h3></a>
        </div>
    </div>
</nav>

<div class="card-deck">
    <div class="card bg-danger">
        <div class="card-body text-center">
            <span style="font-size:160px">
                <?php echo $allScores[$division]["team1"]["score"]; ?>
            </span>
            <h1><?php echo $allScores[$division]["team1"]["name"];?></h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <span style="font-size:160px">
                <?php echo $allScores[$division]["team2"]["score"]; ?>
            </span>
            <h1><?php echo $allScores[$division]["team2"]["name"];?></h1>
        </div>
    </div>
    <div class="card bg-primary">
        <div class="card-body text-center"> 
            <span style="font-size:160px">
                <?php echo $allScores[$division]["team3"]["score"]; ?>
            </span>
            <h1><?php echo $allScores[$division]["team3"]["name"];?></h1>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-bottom">
    <span class="text-white">F11 for full screen.</span>
</nav>
    
</body>
</html>
