<!DOCTYPE html>
<html lang="en">
<head>
  <title>Quiz Scores</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--
  <meta http-equiv=”refresh” content=”5;url=scoreShow.php" />
  -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>  
  
  <link rel="stylesheet" type="text/css" href="styles.css">
  
<?php
// if district and division not in the query
if(array_key_exists("d",$_GET)==0 || array_key_exists("v",$_GET)==0){
    header("url:index.html");
}

$district=$_GET["d"];
$division=$_GET["v"];

function activeButton($thisDiv){
    //echo "btn-warning";
    global $division;
    if($division===$thisDiv){echo "btn-warning";}
    else{echo "btn-secondary";}
}
?>

<script>
var time0=new Date();
var s0=time0.getSeconds();
var division;
var otherDivision;
var district;
var allScores;

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
function getScores(){
    // get scores from server
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            allScores=JSON.parse(this.responseText);
            updateScores();
        }
    };
    xmlhttp.open("GET", "returnScores.php?d=" + district, true);
    xmlhttp.send();
}
function startUp(district0,division0){
    // kick off the page update functions
    district=district0;
    division=division0;
    if(division=='A'){otherDivision='B';}
    else {otherDivision='A';}
    getScores();
}
function updateScores(){
    
    var today=new Date();
    var s=today.getSeconds();
    var m = today.getMinutes();
    var msg=document.getElementById("msg");    
    msg.innerHTML='| min:'+m+', sec:'+s+' ('+m%3+')';
    if(m%3==0 && s<15){
        showSnackBar()
    }
    
    // update this divisions names and scores
    document.getElementById('t1score').innerHTML=allScores[division]['team1']['score'];
    document.getElementById('t2score').innerHTML=allScores[division]['team2']['score'];
    document.getElementById('t3score').innerHTML=allScores[division]['team3']['score'];
    document.getElementById('t1name').innerHTML=allScores[division]['team1']['name'];
    document.getElementById('t2name').innerHTML=allScores[division]['team2']['name'];
    document.getElementById('t3name').innerHTML=allScores[division]['team3']['name'];
    document.getElementById('timeout').value=allScores[division]['timeout'];

    // update the other division
    document.getElementById('ot1score').innerHTML=allScores[otherDivision]['team1']['score'];
    document.getElementById('ot2score').innerHTML=allScores[otherDivision]['team2']['score'];
    document.getElementById('ot3score').innerHTML=allScores[otherDivision]['team3']['score'];
    document.getElementById('ot1name').innerHTML=allScores[otherDivision]['team1']['name'];
    document.getElementById('ot2name').innerHTML=allScores[otherDivision]['team2']['name'];
    document.getElementById('ot3name').innerHTML=allScores[otherDivision]['team3']['name'];
    document.getElementById('snackheader').innerHTML="Division "+otherDivision;

    // update A and B quiz and question
    document.getElementById('Aqz').innerHTML=allScores['A']['quiz'];
    document.getElementById('Aqu').innerHTML=allScores['A']['question'];
    document.getElementById('Bqz').innerHTML=allScores['B']['quiz'];
    document.getElementById('Bqu').innerHTML=allScores['B']['question'];

    // show timeout slides
    var timeout=document.getElementById("timeout").value;
    var ovr=document.getElementById("overlay");
    if(timeout>0){
        // timeout is in effect
        var em=document.getElementById("meme");
        //em.src=getImage();
        //msg.innerHTML=s+","+em.src;
        ovr.style.display='block';
    }
    else {
        ovr.style.display='none';
    }
    //msg.innerHTML+='| timeout:'+timeout;
    //msg.innerHTML+='| overlay.style.display:'+ovr.style.display;
    var t=setTimeout(getScores,500);
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
<body style="background-color:black" onload="startUp(<?php echo '\''.$district.'\',\''.$division.'\''; ?> ) " >
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <input type="hidden" id="timeout" value="none">
    <div class="container-fluid">
        <div class="btn-group flex">
            <a class="nav-link btn <?php activeButton("A");?>" href="scores.php?d=WGL&v=A">
                <h1>A / Quiz:
                <span class="badge badge-light" id="Aqz"></span>
                <span>Q:</span>
                <span class="badge badge-info" id="Aqu"></span>               
                </h1>
            </a>
            <a class="nav-link btn <?php activeButton("B");?>" href="scores.php?d=WGL&v=B">
                <h1>B / Quiz:
                <span class="badge badge-light" id="Bqz"></span>
                <span>Q:</span>
                <span class="badge badge-info" id="Bqu"></span> 
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
            <span style="font-size:160px" id="t1score"></span>
            <h1 id="t1name"></h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body text-center">
            <span style="font-size:160px" id="t2score"></span>
            <h1 id="t2name"></h1>
        </div>
    </div>
    <div class="card bg-primary">
        <div class="card-body text-center"> 
            <span style="font-size:160px" id="t3score"></span>
            <h1 id="t3name"></h1>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-bottom">
    <span class="text-white">F11 for full screen.</span>
    <span>||</span>
    <span class="text-white" id="msg"></span>
</nav>

<!-- The actual snackbar -->
<div id="snackbar">
    <!--
    <h1 style="color:#000" id="snackheader"></h1>
    
    <div class="card-deck">
        <div class="card bg-dark">
            <div class="card-body text-center">
                <h1 id="ot1score"></h1>
                <h2 id="ot1name"></h2>
            </div>
        </div>
        <div class="card bg-dark">
            <div class="card-body text-center">
                <h1 id="ot2score"></h1>
                <h2 id="ot2name"></h2>
            </div>
        </div>
        <div class="card bg-dark">
            <div class="card-body text-center">
                <h1 id="ot3score"></h1>
                <h2 id="ot3name"></h2>
            </div>
        </div>  
    </div>
    -->
    <span id="snackheader"></span><span> | </span>
    <span id="ot1name"></span>
    <span id="ot1score"></span><span> | </span>
    <span id="ot2name"></span>
    <span id="ot2score"></span><span> | </span>
    <span id="ot3name"></span>
    <span id="ot3score"></span>
    
</div>
    
<!-- OVERLAY -->
<div id="overlay" style="display:none">
    <div id="mycarousel">
        <!--<img style="height:600px" id="meme" src="img/meme_1.jpg" alt="">-->
        <img style="height:600px" id="meme" src="" alt="">
    </div>
    
    <div id="mycarousel" class="carousel slide" data-ride="carousel" 
         data-interval=15000 data-pause=false>
      
      <div class="carousel-inner">
        <!-- make carousel-item for each image in img/*.jpg -->
        <?php
        $img=glob('img/*.jpg');
        foreach($img as $row) {
        ?>
            <div class="carousel-item<?php if($row==$img[0]){echo " active";}?>">
                <img src="<?php echo $row;?>" alt="">
            </div>
        <?php
        }
        ?>

      </div>
    </div>

</div>

</body>
</html>
