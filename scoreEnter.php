<!DOCTYPE html>
<html lang="en">
<head>
  <title>Score Enter</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  
  
  <script>
function submitScores() {

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
        var question=document.getElementById("q").value;
        
        var args="d=WGL";
        args+="&v="+division;
        args+="&q="+question;
        
        for (var ii=0;ii<3;ii++){
            var nm=document.getElementById("name"+(ii+1)).value;
            var score=document.getElementById("score"+(ii+1)).value;
            args+="&name"+(ii+1)+"="+nm;
            args+="&score"+(ii+1)+"="+score;
            //if(ii<2){args+='&';}
        }
        //console.log('args:'+args);
        xmlhttp.send(args);
        //xmlhttp.send();
}
</script>
  
  
</head>
<body>

    <!--
<div class="jumbotron text-center">
  <h1>My First Bootstrap Page</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div>
  -->

<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
              <div class="card-body text-center">
                  <div class="form-group">
                    <label for="dis">District</label>
                    <input type="text" class="form-control" id="dis" value="Western Great Lakes (WGL)" readonly>
                  </div>
                  <div class="form-group">
                    <label for="division">Division</label>
                    <input type="text" class="form-control" id="division" onchange="submitScores()" value="A">
                  </div>
                 <div class="form-group">
                    <label for="q">Question</label>
                    <input type="text" class="form-control" id="q" onchange="submitScores()" value="1">
                  </div>

              </div>
            </div>
        </div>
        
        
        <div class="col-sm-3">
            <div class="card bg-danger">
              <div class="card-body text-center">

                  <h3>Team name</h3>
                  <input type="text" id="name1" onchange="submitScores()" value="Team 1">
                  <h3>Score</h3>
                  <input type="text" id="score1" onchange="submitScores()" value="20">


              </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
              <div class="card-body text-center">
                        <h3>Team name</h3>
                  <input type="text" id="name2" onchange="submitScores()" value="Team 2">
                  <h3>Score</h3>
                  <input type="text" id="score2" onchange="submitScores()" value="20">
              </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card bg-primary">
              <div class="card-body text-center" onchange="submitScores()">
                        <h3>Team name</h3>
                  <input type="text" id="name3" onchange="submitScores()" value="Team 3">
                  <h3>Score</h3>
                  <input type="text" id="score3" onchange="submitScores()" value="20">
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

