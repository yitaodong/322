<?php 
/* Battleroom page */
require 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Battleroom</title>
  <?php include 'css/css.html'; ?>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['searchroom'])) {
    REQUIRE 'searchroom.php';
  }
  elseif(isset($_POST['upload'])) {
    REQUIRE 'uploadtime.php';
  }
}
?>

<body>
  <div class="form">
  	<ul class="tab-group">
  	  <li class="tab active"><a href="#playgame">I want play games!</a></li>
	  <li class="tab"><a href="#posttime">Share my available times</a></li>
  	</ul>

  	<div class="tab-content">
  	  <div id="playgame">
  	    <h1>Find teammates</h1>
  		<form action="battleroom.php" method="post" autocomplete="off">
          <div class="field-wrap">
          	<label>
          		Game<span class="req">*</span>
            </label>
          		<input type="text" required autocomplete="off" name="gamename"/>          	
          </div>
          <button type="submit" class="button button-block" name="searchroom" />SEARCH</button>
  		</form>
  	  </div>

      <div id="posttime">
        <h1>Post available time</h1>
        <form action="battleroom.php" method="post" autocomplete="off">
          <div class="top-row">
            <div class="field-wrap">
              <label>
                Start time<span class="req">*</span>
              </label>
              <input type="number" required autocomplete="off" name="starttime" />
            </div>
        
            <div class="field-wrap">
              <label>
                End time<span class="req">*</span>
              </label>
              <input type="number"required autocomplete="off" name="endtime" />
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Game<span class="req">*</span>
            </label>
              <input type="text" required autocomplete="off" name="gamename"/>
          </div>

          <div class="field-wrap">
            <label>
              Size of team<span class="req">*</span>
            </label>
              <input type="number" required autocomplete="off" name="teamsize"/>
          </div>

          <div class="field-wrap">
            <label>
              Region<span class="req">*</span>
            </label>
              <input type="text" required autocomplete="off" name="region"/>
          </div>

          <button type="submit" class="button button-block" name="upload" />UPLOAD MY TIME</button>
      </form>
      </div>
  	</div>

 <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    
    <script src="js/discussion.js"></script>
</body>
</html>

