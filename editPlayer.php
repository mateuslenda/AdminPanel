<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header("Location: index.php");
}

$adminLev = $_SESSION['adminLevel'];
$user = $_SESSION['user'];
$uidPlayer = $_SESSION['uidPlayer'];
$guidPlayer = $_SESSION['guidPlayer'];


include('verifyPanel.php');
masterconnect();

$sql = "SELECT * FROM `players` WHERE uid = '$uidPlayer'";
$result = mysqli_query($dbcon, $sql);
$player = $result->fetch_object();	

$username = $player->name;

function stripArray($input, $type)
{
    $array = array();

    switch ($type) {
        case 0:
            $array = explode("],[", $input);
            $array = str_replace('"[[', "", $array);
            $array = str_replace(']]"', "", $array);
            $array = str_replace('`', "", $array);
            break;
    }
    return $array;
}

function before($this, $inthat) 
{ 
      return substr($inthat, 0, strpos($inthat, $this)); 
} 
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Panel - <?php echo $username; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/styles/dashboard.css" rel="stylesheet">


    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  
<?php
include('header/header.php');
?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 style = "margin-top: 70px">Edit Player</h1>
		  <p class="page-header">Edit player menu of the panel, allows you to change values in more depth.</p>
		  
		  <form action='editPlayer.php' method='post'>
		  <div class="btn-group" role="group" aria-label="...">
		  <input class = 'btn btn-primary btn-outline' type='submit' name='remove' value='Reset Civ Licenses'>
	   	  </div>
		  <div class="btn-group" role="group" aria-label="...">
		  <input class = 'btn btn-primary btn-outline' type='submit' name='give' value='Give All Civ Licenses'>
		  </div></form> <br>
		  
<!--
          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
          </div>
-->
<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Player Info</h3>
  </div>
  <div class='panel-body'>
<?php
echo "<div class='lic'>";	
echo "<div id ='editPlayer'><center><h1>".$username."</h1></center>";
echo "<center><h4>UID: ".$player->uid."</h3></center>";
echo "<center><h4>Player ID: ".$player->playerid."</h3></center>";
echo "<center><h4>GUID: ".$guidPlayer."</h3></center>";
echo "<center><h4>Bank: $".$player->bankacc."</h3></center>";
echo "<center><h4>Cash: $".$player->cash."</h3></center>";
echo "<center><h4>Cop Level: ".$player->coplevel."</h3></center>";
echo "<center><h4>Medic Level: ".$player->mediclevel."</h3></center>";
echo "<center><h4>Admin Level: ".$player->adminlevel."</h3></center>";

//echo "<center><h3>".$player->playerid."</h3></center>";
echo "</div>";
echo "  </div> </div> </div>";

echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Edit Player</h3>
  </div>
  <div class='panel-body'>";

?>
            <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Donator Level</th>
					<th>Blacklisted</th>
					<th>Update</th>
                </tr>
              </thead>
              <tbody>
			  
<?php

if (isset($_POST['donUpdate'])) {
	
  $sql = "SELECT * FROM `players` WHERE `uid` = $uidPlayer";
  $result = mysqli_query($dbcon, $sql);
  $player = $result->fetch_object();	
	
  if ($adminLev > 6) {
	
    if ($_POST['donatorlvl'] != $player->donatorlvl){
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." donator level from ".$player->donatorlvl." to ".$_POST['donatorlvl'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['blacklist'] != $player->blacklist){
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." blacklist status from ".$player->blacklist." to ".$_POST['blacklist'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
  $UpdateQ = "UPDATE players SET blacklist='$_POST[blacklist]', donatorlvl='$_POST[donatorlvl]' WHERE uid='$uidPlayer'";
  mysqli_query($dbcon, $UpdateQ);	
	
  } elseif ($adminLev > 4) {
		
  if ($_POST['donatorlvl'] != $player->donatorlvl){
    $message = "Admin ".$user." tried to change ".$player->name."(".$player->playerid.")"." donator level from ".$player->donatorlvl." to ".$_POST['donatorlvl'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['blacklist'] != $player->blacklist){
    $message = "Admin ".$user." has changed ".$player->name."(".$player->playerid.")"." blacklist status from ".$player->blacklist." to ".$_POST['blacklist'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
  $UpdateQ = "UPDATE players SET blacklist='$_POST[blacklist]' WHERE uid='$uidPlayer'";
  mysqli_query($dbcon, $UpdateQ);
  } else {
		
  if ($_POST['donatorlvl'] != $player->donatorlvl){
    $message = "Admin ".$user." tried to change ".$player->name."(".$player->playerid.")"." donator level from ".$player->donatorlvl." to ".$_POST['donatorlvl'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
	
  if ($_POST['blacklist'] != $player->blacklist){
    $message = "Admin ".$user." tried to change ".$player->name."(".$player->playerid.")"." blacklist status from ".$player->blacklist." to ".$_POST['blacklist'];
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);
  }
		
  }
}


	
$sqlget = "SELECT * FROM players WHERE uid=$uidPlayer;";
$search_result = mysqli_query($dbcon, $sqlget) or die ('Connection could not be established');

while ($row = mysqli_fetch_array($search_result,MYSQLI_ASSOC)) {
  echo "<tr>";
echo "<form action=editPlayer.php method=post>";
echo "<td>" ."<input class='form-control' type=text style = 'width: 100%;' name=donatorlvl value=" .$row['donatorlvl'] . " </td>";
echo "<td>" ."<input class='form-control' type=text style = 'width: 100%;' name=blacklist value=" .$row['blacklist'] . " </td>";
echo "<td>" . "<input class='btn btn-primary btn-outline' type=submit name=donUpdate value=Update". " </td>";
echo "</form>";
		
  echo "</tr>";
}
  echo "</table></div>";
	
	

  

echo "</div>";
echo "</div>";

echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Player Notes</h3>
  </div>
  <div class='panel-body'>";
  ?>
            <div class="table-responsive">
            <table class="table table-striped" style = "margin-top: -10px">
              <thead>
                <tr>
					<th>Added by</th>
					<th>Note</th>
					<th>Date added</th>
                </tr>
              </thead>
              <tbody>
			  
<?php
	
  $sqlget = "SELECT * FROM notes WHERE uid=$uidPlayer;";
$search_result = mysqli_query($dbcon, $sqlget) or die ('Connection could not be established');

while ($row = mysqli_fetch_array($search_result,MYSQLI_ASSOC)) {
  echo "<tr>";
//echo "$row[note_text]";

  if ($row['warning'] == 2){
  //echo "<td style=background-color:#FFA500;>Strike</td>";
  //echo "<td style=background-color:#FFA500;><input class='form-control' type=text name=warn value='$row[warning]' .</td>";

echo "<td style=background-color:#FFA500;>" .$row['staff_name'] . " </td>";
echo "<td style=background-color:#FFA500;>" .$row['note_text'] . " </td>";
echo "<td style=background-color:#FFA500;>" .$row['note_updated'] . " </td>";

	
  }elseif ($row['warning'] == 3){
  //echo "<td style=background-color:#FF0000;><input class='form-control' type=text name=warn value='$row[warning]' .</td>";
	
echo "<td style=background-color:#FF0000;>" .$row['staff_name'] . " </td>";
echo "<td style=background-color:#FF0000;>" .$row['note_text'] . " </td>";
echo "<td style=background-color:#FF0000;>" .$row['note_updated'] . " </td>";
  } else {
		
echo "<td>" .$row['staff_name'] . " </td>";
echo "<td>" .$row['note_text'] . " </td>";
echo "<td>" .$row['note_updated'] . " </td>";
		
  }
  echo "</tr>";
}
  echo "</table></div>";
echo "</div>";
echo "</div>";


echo "<div id ='civlic'>";

  if ($player->civ_licenses !== '"[]"' && $player->civ_licenses !== '') {

    $return = stripArray($player->civ_licenses, 0);
    $return = str_replace('[[', "", $return);

echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Civ Licenses</h3>
  </div>
  <div class='panel-body'>";



  foreach ($return as $value) {
    if (strpos($value, "1") == TRUE) {
      $name = before(',', $value);
      $display = explode("_", $name); 
      $displayN = $display['2']; 
      echo "<button type='button' id=" . $name . " class='license btn btn-success btn-sm' onClick='post1(this.id);'>" . $displayN . "</button> ";
		
    } else {
      $name = before(',', $value);
      $display = explode("_", $name); 
      $displayN = $display['2'];
      echo "<button type='button' id=" . $name . " class='btn btn-secondary btn-sm' onClick='post(this.id);'>" . $displayN . "</button> ";

		
    }
  }
echo "  </div>
</div>";
}
echo "</div>";
echo "<div id ='civlic1'>";
  if ($player->med_licenses !== '"[]"' && $player->med_licenses !== '') {
    $return = stripArray($player->med_licenses, 0);
    $return = str_replace('[[', "", $return);
		
echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Medic Licenses</h3>
  </div>
  <div class='panel-body'>";
  
 
  foreach ($return as $value) {
    if (strpos($value, "1") == TRUE) {
      $name = before(',', $value);
      $display = explode("_", $name); 
      $displayN = $display['2'];
      echo "<button type='button' id=" . $name . " class='btn btn-success btn-sm' onClick='post1(this.id);'>" . $displayN . "</button> ";
		
    } else {
      $name = before(',', $value);
      if ($name != ""){
      $display = explode("_", $name); 
      $displayN = $display['2'];
      echo "<button type='button' id=" . $name . " class='btn btn-secondary btn-sm' onClick='post(this.id);'>" . $displayN . "</button> ";
      }
		
    }
  }
  echo "  </div>
</div>";
}
echo "</div>";
echo "<div id ='civlic2'>";
  if ($player->cop_licenses !== '"[]"' && $player->cop_licenses !== '') {

    $return = stripArray($player->cop_licenses, 0);
    $return = str_replace('[[', "", $return);

  echo "<div class='panel panel-info'>
  <div class='panel-heading'>
    <h3 class='panel-title'>Cop Licenses</h3>
  </div>
  <div class='panel-body'>";
		
  foreach ($return as $value) {
    if (strpos($value, "1") == TRUE) {
    $name = before(',', $value);
    $display = explode("_", $name); 
    $displayN = $display['2'];
    echo "<button type='button' id=" . $name . " class='btn btn-success btn-sm' onClick='post1(this.id);'>" . $displayN . "</button> ";
		
    } else {
      $name = before(',', $value);
      if ($name != ""){
      $display = explode("_", $name); 
      $displayN = $display['2'];
      echo "<button type='button' id=" . $name . " class='btn btn-secondary btn-sm' onClick='post(this.id);'>" . $displayN . "</button> ";
      }
		
    }
		
	
  }
    echo "  </div>
</div>";
}
echo "</div>";
echo "</div>";
echo "<div id ='licCheck'><h5></h5>";
echo "</div>";






if (isset($_POST['remove'])) {
	
$licReset = str_replace("1", "0", $player->civ_licenses);
$sql = "UPDATE `players` SET `civ_licenses`='$licReset' WHERE uid ='$uidPlayer'";
$result = mysqli_query($dbcon, $sql); 

    $message = "Admin ".$user." has removed all licenses from ".$player->name."(".$player->playerid.")";
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);

};
if (isset($_POST['give'])) {
	
$licReset = str_replace("0", "1", $player->civ_licenses);
$sql = "UPDATE `players` SET `civ_licenses`='$licReset' WHERE uid ='$uidPlayer'";
$result = mysqli_query($dbcon, $sql); 

    $message = "Admin ".$user." has added all licenses to ".$player->name."(".$player->playerid.")";
    $logQ = "INSERT INTO log (user,action,level) VALUES ('$user','$message',1)";
    mysqli_query($dbcon, $logQ);

};
?>


<script>

$("button").click(function(){
    $("button").toggleClass("btn-secondary btn-success");
});

function post (id)
{
var newid = "#" + id;

	//document.getElementById(id).style.color = "red";
	//document.getElementById(id).style.backgroundColor = "#00FF00";
	//window.location.reload(); 
	//alert(newid);
	$(newid).toggleClass("btn-secondary btn-success");
	
	$.post('changeLicense.php',{id:id,uid:<?php echo $uidPlayer?>},
	function(data)
	{
		//$('h5').html(data);
		
	});
}

function post1 (id)
{
var newid = "#" + id;
	//document.getElementById(id).style.color = "red";
	//document.getElementById(id).style.backgroundColor = "#FF0000";
	 $(newid).toggleClass("btn-secondary btn-success");
	
	var newid = id;
	$.post('changeLicense.php',{id:id,uid:<?php echo $uidPlayer?>},
	function(data)
	{
		//$('h5').html(data);
		
	});
}

</script>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
