
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
$file = fopen("scores.txt","r");
$team1=fgetcsv($file);
$team2=fgetcsv($file);
$team3=fgetcsv($file);
fclose($file);
?>

    
    
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
