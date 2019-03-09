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
  
  
  <link rel="stylesheet" type="text/css" href="styles.css">
  
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
if($division=="A"){
    $otherDivision="B";
}
else{
    $otherDivision="A";
}
if($allScores[$division]["timeout"]==0){$timeout="none";}
else{$timeout="block";}
        
?>
  
<script>
var time0=new Date();
var s0=time0.getSeconds();
function on() {
    document.getElementById("overlay").style.display = "block";
}
function off() {
    document.getElementById("overlay").style.display = "none";
}

function showSnackBar() {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
    // Add the "show" class to DIV
    x.className = "show";
    // After 15 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 15000);
}
function hideSnackBar() {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
    // Add the "show" class to DIV
    x.className =x.className.replace("show", "");
    // After 15 seconds, remove the show class from DIV
    //setTimeout(function(){ x.className = x.className.replace("show", ""); }, 15000);
}
function startTime(){
    var today=new Date();
    var s=today.getSeconds();
    var m = today.getMinutes();
    var msg=document.getElementById("msg");    
    
    if(m%3==0 & s<15){
        showSnackBar()
    }
    
    // show timeout slides
    var e=document.getElementById("timeout");
    if(e.value=="block"){
        // timeout is in effect
        var em=document.getElementById("meme");
        //em.src=getImage();
        //msg.innerHTML=s+","+em.src;
    }
    var t=setTimeout(startTime,500);
}
function getImage(){
    var today=new Date();
    var s=today.getSeconds();
    var idx=Math.floor(s/10)+1;
    var src="img/meme_"+idx+".jpg";
    return src;
}

</script>
</head>
<body style="background-color:black" onload="startTime()">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <input type="hidden" id="timeout" value="<?php echo $timeout;?>">
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
    <span class="text-white" id="msg"></span>
</nav>

    
<!-- The actual snackbar -->
<div id="snackbar">
    <h1 style="color:#000">Division <?php echo $otherDivision; ?></h1>
    <div class="card-deck">
        <div class="card bg-dark">
            <div class="card-body text-center">
                <h1><?php echo $allScores[$otherDivision]["team1"]["score"]; ?></h1>
                <h2><?php echo $allScores[$otherDivision]["team1"]["name"]; ?></h2>
            </div>
        </div>
        <div class="card bg-dark">
            <div class="card-body text-center">
                <h1><?php echo $allScores[$otherDivision]["team2"]["score"]; ?></h1>
                <h2><?php echo $allScores[$otherDivision]["team2"]["name"]; ?></h2>
            </div>
        </div>
        <div class="card bg-dark">
            <div class="card-body text-center">
                <h1><?php echo $allScores[$otherDivision]["team3"]["score"]; ?></h1>
                <h2><?php echo $allScores[$otherDivision]["team3"]["name"]; ?></h2>
            </div>
        </div>
    </div>
</div>
    

<div id="overlay" style="display:<?php echo $timeout;?>">
    <div id="mycarousel">
        <!--<img style="height:600px" id="meme" src="img/meme_1.jpg" alt="">-->
        <img style="height:600px" id="meme" src="" alt="">
    </div>
    <!--
    <div id="mycarousel" class="carousel slide" data-ride="carousel" 
         data-interval=2500 data-pause=false>
      
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
    </div>
-->
</div>
    
</body>
</html>
