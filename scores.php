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

#overlay {
    position: fixed; /* Sit on top of the page content */
    display: none; /* Hidden by default */
    width: 100%; /* Full width (cover the whole page) */
    height: 100%; /* Full height (cover the whole page) */
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5); /* Black background with opacity */
    z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
    cursor: pointer; /* Add a pointer on hover */
}
#mycarousel{
    position: absolute;
    top: 50%;
    left: 50%;
    font-size: 50px;
    color: white;
    transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
}
  .carousel-inner img {
      height: 600px;
  }
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
    $allScores[$k]["quiz"]=$val[0];
    $allScores[$k]["question"]=$val[1];
    // other info
    $val=fgetcsv($file);
    $allScores[$k]["timeout"]=$val[0];
    fclose($file);
}

function activeButton($thisDiv){
    //echo "btn-warning";
    global $division;
    if($division===$thisDiv){echo "btn-warning";}
    else{echo "btn-secondary";}
}

if($allScores[$division]["timeout"]==0){$timeout="none";}
else{$timeout="block";}
        
?>
<script>
    function on() {
    document.getElementById("overlay").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}
</script>
</head>
<body style="background-color:black">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <div class="btn-group flex">
            <a class="nav-link btn <?php activeButton("A");?>" href="scores.php?d=WGL&v=A">
                <h1>A / Quiz:
                <span class="badge badge-light">
                    <?php echo $allScores["A"]["quiz"]; ?>
                </span>
                <span>Q:</span>
                <span class="badge badge-info">
                    <?php echo $allScores["A"]["question"]; ?>
                </span>               
                </h1>
            </a>
            <a class="nav-link btn <?php activeButton("B");?>" href="scores.php?d=WGL&v=B">
                <h1>B / Quiz:
                <span class="badge badge-light">
                    <?php echo $allScores["B"]["quiz"]; ?>
                </span>
                <span>Q:</span>
                <span class="badge badge-info">
                    <?php echo $allScores["B"]["question"]; ?>
                </span>
                </h1>
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

<div id="overlay" style="display:<?php echo $timeout;?>">

    <div id="mycarousel" class="carousel slide" data-ride="carousel" 
         data-interval=2500 data-pause=false>

        <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
        
        
      <!-- The slideshow -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="img/meme_1.jpg" alt="">
        </div>
        <div class="carousel-item">
          <img src="img/meme_2.jpg" alt="">
        </div>
        <div class="carousel-item">
          <img src="img/meme_3.jpg" alt="">
        </div>
      </div>

      <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>

    </div>

</div>
    
</body>
</html>
