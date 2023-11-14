<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  $currenttime = time();
  $wantedtime = ($currenttime-86400);


?>
<html>
  <head>
    <title>PANDEMIC LEVYRAATI</title>
    <link rel="stylesheet" href="/style.css"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/faviconlevy/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/faviconlevy/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/faviconlevy/favicon-16x16.png">
    <link rel="manifest" href="/faviconlevy/site.webmanifest">


  </head>

  <body>
    <body bgcolor="#000000">

    <div class="Halfpic">
      <img class="Halfpic" src="greybackmusicskull.jpg">
      </div>

      <div class="Halftext">
        <div class="font-effect-anaglyph">
              <a href="levy.php">
          <h1>PANDEMIC<br>LEVYRAATI</h1>
              </a>
          <h5 style="margin-top:50px; margin-bottom: 10px;"></h5>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <p>The pandemic is long. The site has BLOATED like a CORPSE. Now there are too many tools that clutter the main page.</p>
          <p>Now these buttons are getting SHOVED BACK into this DARK UNDERBELLY.</p>
          <p>NEVER LEAVE YOUR HOME. THIS SITE IS YOUR HOME NOW.</p>
        </div>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        </p>
        <p></p>
        <p></p>
        <h5>Data & Stats</h5>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <p></p>
        <a href="whattolistento.php">
        <div class="commentbutton">
          <center>
        <h5><br>&#127911; What to Listen to Today? &#127911;<br><br></h5>
      </center>
        </div>
        </a>
        <p></p>
        <a href="https://docs.google.com/spreadsheets/d/1TEbS4pMf0aL-uk9gsn8PYaiU7KDTqTkxFVxJdmR0v5w/edit#gid=0">
        <div class="commentbutton">
          <center>
        <h5><br>&#128081; SIMO'S A FREAK IN THE SHEETS &#128081;<br><br></h5>
      </center>
        </div>
        </a>
        <p></p>
        <a href="pastbangers_new.php?timestamp=<?php echo ($wantedtime)?>">
        <div class="commentbutton">
          <center>
        <h5><br>&#8986; DO THE TIMEWARP! WHAT WAS ON LAST WEEK?!?!? &#8986;<br><br></h5>
      </center>
        </div>
        </a>
        <p></p>
        <a href="bestthemes.php">
        <div class="commentbutton">
        <center>
        <h5><br>&#127751; All Themes in Order &#127751;<br><br></h5>
        </center>
        </div>
        </a>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <p></p>
        <a href="alltime_new.php">
        <div class="commentbutton">
        <center>
        <h5><br>&#11088; LEVYRAATI ALL STARS &#11088;<br><br></h5>
        </center>
        </div>
        </a>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <p></p>
        <a href="thelist.php">
        <div class="commentbutton">
        <center>
        <h5><br>&#128220; THE LIST OF THEM ALL &#128220;<br><br></h5>
        </center>
        </div>
        </a>
        <p></p>
        <p></p>
        <!--
        <a href="2021.php">
        <div class="commentbutton">
        <center>
        <h5><br>&#x1F38A; THE BEST OF 2021 &#x1F38A;<br><br></h5>
        </center>
        </div>
        </a>
        -->
        <a href="100.php">
        <div class="commentbutton">
        <center>
        <h5><br>&#x1F92E; LEVYRAATI 100 MEMORIAL &#x1F92E;<br><br></h5>
        </center>
        </div>
        </a>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <br>
        <h5>User Account</h5>
        <p></p>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <a href="levy.php">
        <div class="commentbutton">
        <center>
        <p>&#127881; GO BACK TO THE PARTY! &#127881;</p>
        </center>
        </div>
        </a>
        <p></p>
        <a href="change.php">
        <div class="commentbutton">
          <center>
        <p>&#128273; CHANGE YOUR PASSWORD! &#128273;</p>
          </center>
        </div>
        </a>
        <p></p>
        <a href="requests.php">
        <div class="commentbutton">
          <center>
        <p>&#128295; MAKE A FEATURE REQUEST &#128295;</p>
          </center>
        </div>
        </a>
        <p></p>
        <a href="logout.php">
        <div class="commentbutton">
          <center>
        <p>&#127771; LEAVE THE DISCO! &#127771;</p>
        </center>
        </div>
        </a>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <br>
        <br>


  </body>
</html>


<?php

} else {
  header('Location: index.php');
}

 ?>
