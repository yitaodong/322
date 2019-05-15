<?php

session_start();

$weight = $_POST['weight'];
$key = $mysqli->escape_string($_POST['key']);
$sqlcleartitle = "DROP VIEW IF EXISTS titlecount";
$sqlcleartext = "DROP VIEW IF EXISTS textcount";
$sqlclearfull = "DROP VIEW IF EXISTS fullcount";
$sqltitle = "CREATE VIEW `titlecount` AS SELECT `userID`, `postname`, (LENGTH(`postname`) - LENGTH(replace(`postname`, '$key', '')))/LENGTH('$key') AS `counttitle` FROM `post` WHERE `postname` LIKE '%{$key}%'";
$sqltext = "CREATE VIEW `textcount` AS SELECT `userID`, `postname`, (LENGTH(`text`) - LENGTH(replace(`text`, '$key', '')))/LENGTH('$key') AS `counttext` FROM `post` WHERE `text` LIKE '%{$key}%'";
$sqlfinal = "CREATE VIEW `fullcount` AS SELECT `textcount`.`userID`, `textcount`.`postname`, `textcount`.`counttext` AS `counttext`, IFNULL(`titlecount`.`counttitle`, 0) AS `counttitle` FROM `textcount` LEFT JOIN `titlecount` ON `textcount`.`userID` = `titlecount`.`userID` AND `textcount`.`postname` = `titlecount`.`postname` UNION SELECT `titlecount`.`userID`, `titlecount`.`postname`, IFNULL(`textcount`.`counttext`, 0) AS `counttext`, `titlecount`.`counttitle` AS `counttitle` FROM `textcount` RIGHT JOIN `titlecount` ON `textcount`.`userID` = `titlecount`.`userID` AND `textcount`.`postname` = `titlecount`.`postname`";
$sqlout = "SELECT * from `fullcount` ORDER BY $weight*`counttitle`+`counttext` DESC LIMIT 5";


if(!($resclrtitle = $mysqli->query($sqlcleartitle))){
	$_SESSION['message'] = 'Error in clearing views';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}

if(!($resclrtext = $mysqli->query($sqlcleartext))){
	$_SESSION['message'] = 'Error in clearing views';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
if(!($resclrfull = $mysqli->query($sqlclearfull))){
	$_SESSION['message'] = 'Error in clearing views';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}

if(!($ressettitle = $mysqli->query($sqltitle))){
	$_SESSION['message'] = 'Error in setting views';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
if(!($ressettext = $mysqli->query($sqltext))){
	$_SESSION['message'] = 'Error in setting views';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
if(!($ressetfinal = $mysqli->query($sqlfinal))){
	$_SESSION['message'] = 'Error in setting views';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}

if(!($ressetout = $mysqli->query($sqlout))){
	$_SESSION['message'] = 'Error in fetching results';
    echo '<script type="text/javascript">
    window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
    </script>';
}
else{
	echo "<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> ";
	while($row = $ressetout -> fetch_assoc()) {
	    $textname = $mysqli->escape_string($row['postname']);
	    $textid = $mysqli->escape_string($row['userID']);
	    $textsql = "SELECT * FROM `post` WHERE `postname`='$textname' AND `userID`='$textid'";
	    if(!($textout = $mysqli->query($textsql))){
	      $_SESSION['message'] = 'Error in fetching text';
          echo '<script type="text/javascript">
          window.location="http://veggiebirds.web.engr.illinois.edu/error.php";
          </script>';
        }
        $textrow = $textout->fetch_assoc();
    	echo '<span style="margin-left:500px;">Title is '. $row['postname']. '</span><br>   <span style="margin-left:500px;">Content is:  '. $textrow['text']. '</span><br>';
    }

}


?>
