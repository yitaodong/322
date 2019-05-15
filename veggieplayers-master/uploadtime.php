<?php
session_start();
//set session variable
$email = $_SESSION['email'];;
$uidsql = "SELECT `userID` FROM `user_data` WHERE `email`='$email'";
            
$result = $mysqli->query($uidsql);
$row = $result->fetch_assoc();
$uid = $row['userID'];
$starttime = $_POST['starttime'];
$endtime = $_POST['endtime'];
$checksql = "SELECT * FROM `battleroom` WHERE `userID` = $uid";
$checkresult = $mysqli->query($checksql);
$flag=0;
$sql="";

while($checkrow = $checkresult->fetch_assoc()){
	$flag=1;
	$orgstart=$checkrow['start'];
	$orgend=$checkrow['end'];
	if($orgstart==$starttime and $orgend == $endtime){
	    $flag=3;
	    break;
	}
	
	if($orgstart<=$endtime and $orgend>=$starttime){
		if($orgstart<=$starttime){
			if($orgend<$endtime){
				$sql="UPDATE `battleroom` SET `end`='$endtime' WHERE `userID` = '$uid' AND `start`='$orgstart' AND `end`='$orgend'";
			}	
		}
		else{
			if($orgend>=$endtime){
				$sql="UPDATE `battleroom` SET `start`='$starttime' WHERE `userID` = '$uid' AND `start`='$orgstart' AND `end`='$orgend'";
			}
			else{
				$sql="UPDATE `battleroom` SET `start`='$starttime', `end`='$endtime' WHERE `userID` = '$uid' AND `start`='$orgstart' AND `end`='$orgend'";
			}
		}
		
	}	
}

if($sql=="" and $flag==3){
	$_SESSION['message'] = 'Your time is already in the base';
	echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/success.php";
    </script>';
}
else{
	if($sql==""){
			$sql="INSERT INTO `battleroom` (`start`, `end`, `userID`) VALUES ('$starttime', '$endtime', '$uid')";
	}
	if($postresult = $mysqli -> query($sql) and $flag!=2){
    $_SESSION['message'] = 'Your time is entered!';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/success.php";
    </script>';
    }
    elseif($flag!=2){
    $_SESSION['message'] = $postresult;
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
    }
}


?>