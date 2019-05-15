<?php
//require 'db.php';
session_start();
//set session variable
$email = $_SESSION['email'];;
$uidsql = "SELECT `userID` FROM `user_data` WHERE `email`='$email'";

$result = $mysqli->query($uidsql);
$row = $result->fetch_assoc();
$uid = $row['userID'];

$getsql = "SELECT * FROM `battleroom` WHERE `userID`=$uid";

if(!($resget = $mysqli->query($getsql))){
    $_SESSION['message'] = $uid;
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}

$clrtab = "DROP TABLE IF EXISTS matchcount";
$crttab = "CREATE TABLE `matchcount` (`otheruser` INT, `otherstart` INT, `otherend` INT, `selfstart` INT, `selfend` INT, `duration` INT)";
if(!($clrget = $mysqli->query($clrtab))){
    $_SESSION['message'] = 'Error in clearing';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
if(!($crtget = $mysqli->query($crttab))){
    $_SESSION['message'] = 'Error in getting time';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}

while($row=$resget->fetch_assoc()){
    $selfstart = $row['start'];
    $selfend = $row['end'];
    $selfid = $row['userID'];
    $findsql = "SELECT * FROM `battleroom` WHERE `userID`!=$selfid AND ((`start`<=$selfstart AND `end`>=$selfstart) OR (`start`<=$selfend AND `end` >= $selfstart))";
    if(!($restemp = $mysqli->query($findsql))){
        $_SESSION['message'] = 'Error in getting matching time';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
    }
    while($matchrow = $restemp->fetch_assoc()){
       $otherstart = $matchrow['start'];
       $otherend = $matchrow['end'];
       $duration = min($selfend, $otherend) - max($selfstart, $otherstart);
       $otherid = $matchrow['userID'];
       $inssql = "INSERT into `matchcount` VALUES ($otherid, $otherstart, $otherend, $selfstart, $selfend, $duration)";
       if(!($insres = $mysqli->query($inssql))){
          $_SESSION['message'] = 'Error in collecting mathing time';
         echo '<script type="text/javascript">
         window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
         </script>';
       }
    }
}
$outsql = "SELECT * FROM `matchcount` ORDER BY `duration` DESC";
if(!($outres = $mysqli->query($outsql))){
  $_SESSION['message'] = 'Error in output values';
  echo '<script type="text/javascript">
  window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
  </script>';
}
echo "<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> ";
while($outrow = $outres->fetch_assoc()){
    $otherid = $outrow['otheruser'];
    $namesql = "SELECT * FROM `user_data` WHERE `userID`=$otherid";
    if(!($nameres = $mysqli->query($namesql))){
      $_SESSION['message'] = $otherid;
      echo '<script type="text/javascript">
      window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
      </script>';
    }
    $namerow = $nameres->fetch_assoc();
    echo '<span style="margin-left:100px;">People is '. $namerow['Fname']. $namerow['Lname']. '</span style="margin-left:100px;"><br>  <span>Email is '. $namerow['email']. '</span><br>    <span style="margin-left:100px;">His time from '. $outrow['otherstart']. '  to  '. $outrow['otherend']. '</span><br>';
}

?>