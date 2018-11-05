<?php
if(array_key_exists("d",$_GET)==0 || array_key_exists("v",$_GET)==0){
    die("something is not right...");
}
$district=$_GET["d"];
$division=$_GET["v"];
//$fn=file_build_path("data",$district."_".$division.".txt");
$fn="data/".$district."_".$division.".txt";

$file = fopen($fn,"r");
$team1=fgetcsv($file);
$team2=fgetcsv($file);
$team3=fgetcsv($file);
$qq=fgetcsv($file);
$timeout=fgetcsv($file);
fclose($file);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Score Enter</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  
  
  <script>
//var TOstate=false;

function submitScores(team,scoreChange) {
    //console.log('submitScores')
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("txtHint").innerHTML = this.responseText;
            console.log(this.responseText);
        }
    };
    xmlhttp.open("POST", "processForm.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var division=document.getElementById("division").value;
    var quiz=document.getElementById("quiz").value;
    var question=document.getElementById("question").value;
    
    var args="d=WGL";
    args+="&v="+division;
    args+="&qz="+quiz;
    args+="&q="+question;
    //https://stackoverflow.com/questions/14787761/convert-true-1-and-false-0-in-javascript
    var timeoutState=Number(document.getElementById("timeout").value);
    console.log(timeoutState)
    args+="&TO="+timeoutState;
    
    for (var ii=0;ii<3;ii++){
        var nm=document.getElementById("name"+(ii+1)).value;
        var oldscore=Number(document.getElementById("score"+(ii+1)).value);
        var newscore=oldscore;
        if((ii+1)==team){
            if(scoreChange==20){newscore=20;}
            else if(scoreChange==10 || scoreChange==-10){
                newscore+=scoreChange;
            }
        }
        
        document.getElementById("score"+(ii+1)).value=newscore;
        args+="&name"+(ii+1)+"="+nm;
        args+="&score"+(ii+1)+"="+newscore;
    }
    console.log('args:'+args);
    xmlhttp.send(args);
    //xmlhttp.send();
}
function updateQuiz(v){
    //console.log('updateQuiz')
    var q=Number(document.getElementById("quiz").value);
    if(v==0){q=1;}
    else{q+=v;}
    document.getElementById("quiz").value=q;
    submitScores(0,0);
}
function updateQuestion(v){
    //console.log('updateQuestion')
    var q=document.getElementById("question").value;
    var num=Number(q.match(/\d+/))
    if(v=="0"){q=1;}
    else if(v=="1"){q=num+1;}
    else if(v=="-1"){q=num-1;}
    else if(v=="A"){q=num+"A";}
    else if(v=="B"){q=num+"B";}
    document.getElementById("question").value=q;
    submitScores(0,0);
}
function toggleButton(){
    //console.log("toggleButton")
    var timeoutState=Number(document.getElementById("timeout").value);
    var e=document.getElementById("TO");
    e.classList.toggle("bg-warning");
    timeoutState=1-timeoutState;
    document.getElementById("timeout").value=timeoutState
    //console.log("toggleButton: "+timeoutState)
    submitScores(0,0);
}
</script>
  
  
</head>
<body class="bg-secondary">

    <!--
<div class="jumbotron text-center">
  <h1>My First Bootstrap Page</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div>
  -->

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
      <a class="navbar-brand" href="#">C&MA Quizzing: <?php echo $district;?> - <?php echo $division;?></a>
  </nav>
  
<div class="container bg-secondary" style="margin-top:80px">
    <div class="row">
        <div class="col-sm-3">
            <div class="card bg-secondary">
                <div class="card-body text-center">
                    <input id="division" type="hidden" value="<?php echo $division;?>">
                    <input id="timeout" type="hidden" value="<?php echo $timeout[0];?>">
                    
                    <!-- QUIZ -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Quiz</span>
                        </div>
                        <input id="quiz" type="text" class="form-control" readonly value="<?php echo $qq[0];?>">
                        <div class="input-group-append">
                            <button class="btn btn-default" onclick="updateQuiz(1)">+1</button>
                            <button class="btn btn-default" onclick="updateQuiz(-1)">-1</button>
                            <button class="btn btn-default" onclick="updateQuiz(0)">
                                <i class="fas fa-file"></i>
                            </button>
                        </div>

                    </div>
                    
                    <!-- QUESTION -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Question</span>
                        </div>
                        <input id="question" type="text" class="form-control" readonly value="<?php echo $qq[1];?>">
                        <div class="input-group-append">
                            <button class="btn btn-default" onclick="updateQuestion('1')">+1</button>
                            <button class="btn btn-default" onclick="updateQuestion('-1')">-1</button>
                            <button class="btn btn-default" onclick="updateQuestion('A')">A</button>
                            <button class="btn btn-default" onclick="updateQuestion('B')">B</button>
                            <button class="btn btn-default" onclick="updateQuestion('0')">
                                <i class="fas fa-file"></i>
                            </button>
                        </div>
                    </div>
              </div>
            </div>
        </div>
        
        <!-- RED BENCH-->
        <div class="col-sm-3">
            <div class="card bg-danger">
                <div class="card-body text-center">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Team</span>
                        </div>
                        <input id="name1" type="text" class="form-control" onchange="submitScores(1,0)" value="<?php echo $team1[0];?>">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Score</span>
                        </div>
                        <input id="score1" type="text" class="form-control" readonly value="<?php echo $team1[1];?>">
                        <div class="input-group-append">
                            <button class="btn btn-default" onclick="submitScores(1,10)">+10</button>
                            <button class="btn btn-default" onclick="submitScores(1,-10)">-10</button>
                            <button class="btn btn-default" onclick="submitScores(1,20)">
                                <i class="fas fa-file"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        <!-- WHITE BENCH-->
        <div class="col-sm-3">
            <div class="card">
              <div class="card-body text-center">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Team</span>
                        </div>
                        <input id="name2" type="text" class="form-control" onchange="submitScores(2,0)" value="<?php echo $team2[0];?>">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Score</span>
                        </div>
                        <input id="score2" type="text" class="form-control" readonly value="<?php echo $team2[1];?>">
                        <div class="input-group-append">
                            <button class="btn btn-default" onclick="submitScores(2,10)">+10</button>
                            <button class="btn btn-default" onclick="submitScores(2,-10)">-10</button>
                            <button class="btn btn-default" onclick="submitScores(2,20)">
                                <i class="fas fa-file"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        <!-- BLUE BENCH-->
        <div class="col-sm-3">
            <div class="card bg-primary">
              <div class="card-body text-center">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Team</span>
                        </div>
                        <input id="name3" type="text" class="form-control" onchange="submitScores(3,0)" value="<?php echo $team3[0];?>">
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Score</span>
                        </div>
                        <input id="score3" type="text" class="form-control" readonly value="<?php echo $team3[1];?>">
                        <div class="input-group-append">
                            <button class="btn btn-default" onclick="submitScores(3,10)">+10</button>
                            <button class="btn btn-default" onclick="submitScores(3,-10)">-10</button>
                            <button class="btn btn-default" onclick="submitScores(3,20)">
                                <i class="fas fa-file"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div> 
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-3">
            <div class="card bg-secondary">
                <div class="card-body text-center">
                    <button id="TO" class="btn btn-default bg-basic" onclick="toggleButton()">Time Out</button>
                </div>
            </div>
        </div>
    </div>
</div>
  
  
  
</body>
</html>


<?php
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "Mickey Mouse\n";
fwrite($myfile, $txt);
$txt = "Minnie Mouse\n";
fwrite($myfile, $txt);
fclose($myfile);
?>

