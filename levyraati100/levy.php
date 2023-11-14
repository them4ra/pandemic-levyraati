<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  include_once('../levy/includes/getlevyt.php');

  $levy= new Raati;
  $levyt = $levy->todays_disco();

  /*
  $levy= new Raati;
  $levyt = $levy->get_all_levyt();
 */


  $rating = new Raati;
  $ratings = $rating->get_all_ratings();

  if (isset($_POST['themechange'])) {

    $themechange = $_POST['themechange'];
    $themechangesub = $_POST['themechangesub'];


    $query = $pdo->prepare("UPDATE users SET currenttheme = ? WHERE name=?");
    $query->bindValue(1, $themechange);
    $query->bindValue(2, $_SESSION['user']);
    $query->execute();

    if ($themechange != 'No Theme!') {

    $query = $pdo->prepare("INSERT INTO themes (theme, themeby, themedate, themesubtitle)
    VALUES (?, ?, ?, ?)");
    $query->bindValue(1, $themechange);
    $query->bindValue(2, $_SESSION['user']);
    $query->bindValue(3, time());
    $query->bindValue(4, $themechangesub);

    $query->execute();
    header('Location: levy.php');

  } else {

    header('Location: levy.php');

        }


  } else {

  if (isset($_POST['song'], $_POST['artist'])) {

      $song = $_POST['song'];
      $artist = $_POST['artist'];
      $submitted = $_SESSION['user'];
      $songlink = $_POST['songlink'];
      $songcomment = $_POST['songcomment'];

      $query = $pdo->prepare("SELECT currenttheme FROM users WHERE name = ?");
      $query->bindValue(1, $_SESSION['user']);
      $query->execute();

      $currenttheme = $query->fetch();



      $theme = $currenttheme['currenttheme'];





      if (empty($song) or empty($artist)) {

      $error = 'GIVE A SONG AND ARTIST. NOT A HARD THING TO DO.';

      } else {

      $query = $pdo->prepare("SELECT themeid FROM themes WHERE theme = ?");
      $query->bindValue(1, $theme);
      $query->execute();

      $themeid = $query->fetch();

      $themeidnum = $themeid['themeid'];

      if(empty($themeidnum)) {
        $themeidnum = 72;
      }

      $query = $pdo->prepare("INSERT INTO songs (artist, songname, comment, thetime, author, link, theme)
      VALUES (?, ?, ?, ?, ?, ?, ?)");
      $query->bindValue(1, $artist);
      $query->bindValue(2, $song);
      $query->bindValue(3, $songcomment);
      $query->bindValue(4, time());
      $query->bindParam(5, $submitted);
      $query->bindParam(6, $songlink);
      $query->bindParam(7, $themeidnum);

      $query->execute();
      header('Location: levy.php');

    }

  }

    if (isset($_POST['rating'])) {

        $songrating = $_POST['rating'];
        $ratedsong = $_POST['songid'];
        $submitter = $_SESSION['user'];

            if ($songrating > 10) {

              $error='YOU CAN ONLY GIVE IT 10 AT MOST FUCKER.';

            }

            elseif ($songrating < 0) {

              $error='JUST GIVE IT A ZERO IF YOU HATED IT NUMBNUTS.';

            }

            else {

            $query = $pdo->prepare("SELECT * FROM ratings WHERE songid = ? AND author = ?");
            $query->bindValue(1, $ratedsong);
            $query->bindValue(2, $submitter);
            $query->execute();

            $alreadyrated = $query->fetch();



            if (empty($alreadyrated['author'] && empty($error))) {

              $query = $pdo->prepare("SELECT * FROM songs WHERE songid = ?");
              $query->bindValue(1, $ratedsong);
              $query->execute();

              $theratedsong = $query->fetch();
              $ratedsongauthor = $theratedsong['author'];

              $query = $pdo->prepare("INSERT INTO ratings (songid, author, rating, thetime, songby)
              VALUES (?, ?, ?, ?, ?)");
              $query->bindValue(1, $ratedsong);
              $query->bindValue(2, $submitter);
              $query->bindValue(3, $songrating);
              $query->bindValue(4, time());
              $query->bindValue(5, $ratedsongauthor);

              $query->execute();
              header('Location: levy.php');
            }

            else {

              $error='YOU ALREADY RATED THAT SONG ASSHOLE.';
              }
            }
          }
        }


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
      <img class="Halfpic" src="greybackmusicskullx.jpg">
      </div>

      <div class="Halftext">
        <div class="font-effect-anaglyph">
              <a href="menu.php">
                  <h1>PANDEMIC<br>LEVYRAATI</h1>
              </a>
          <h5 style="margin-top:50px; margin-bottom: 10px; width: 80%;">

            <a href="user.php?id=<?php echo $_SESSION['user'];?>">
            <b style="color: #00ff00;"><?php echo $_SESSION['user']; ?></b>
            </a>
            <!--
            is INSIDE and SAFE FROM DISEASE.</h5>
          -->
           is HERE TO LISTEN TO SOME ABSOLUTE SHIT.
           </h5>

        </div>
        <div>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <?php if (isset($error)) { ?>
            <p style="color:#FF0000; font-size: 22pt;"><?php echo $error; ?></p>
          <?php } ?>
          <!--
    	    <p class="intro">Give a record and let it spin! </p>
          <p class="intro">Then watch your taste in music get harshly judged!</p>
          -->
          <!--
          <p class="intro">Outside, every surface is caked in layers of putrid disease. Leaving your home will only invite decay into your life.</p>
          <p class="intro">WE ARE THE CHOSEN AND THE PURE.</p>
          <p class="intro">WE LISTEN TO MUSIC AS THE WORLD ROTS AWAY.</p>
          <p class="intro">ISOLATION IS OUR STRENGTH.</p>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          -->
          <h5 style="color:gold;">FUCKING LEVYRAATI 100</h5>
          <p class="intro">Tonight is a night of horrors. Each song chosen tonight is an engineered psychological attack, meant to cripple the listener and scar the mind for life.</h5>
          <p class="intro">There is not way out tonight. </p>
          <p class="intro">You cannot choose your theme. </p>
          <p class="intro">You are LOCKED IN.</p>
        </div>


        <?php
        $query = $pdo->prepare("SELECT currenttheme FROM users WHERE name = ?");
        $query->bindValue(1, $_SESSION['user']);
        $query->execute();

        $currenttheme = $query->fetch();

        $query = $pdo->prepare("SELECT themeid, themedate, themesubtitle FROM themes WHERE theme = ?");
        $query->bindValue(1, $currenttheme['currenttheme']);
        $query->execute();

        $currentthemeid = $query->fetch();

        $currenttime = time();
        $timeoflasttheme = $currentthemeid['themedate'];
        if(empty($timeoflasttheme)){
          $timeoflasttheme = $currenttime -86400;
        }
        $themetime = ($timeoflasttheme+86400);

         ?>

         <div>


               <!-- If the user has no theme, it means the user just created their account and this welcome message comes up-->
               <?php

               if (empty($currenttheme['currenttheme'])){

                 ?>
                 <!--
                 <div style="margin-right: 5%; margin-top: 5%;">
                 <h4 style="color: red;">Welcome to the PANDEMIC LEVYRAATI asshole! </h4>
                 <h4>Since this is your first time here, you'll need to</h4>
                 <h4 style="color: cyan;">CHOOSE A FUCKING THEME</h4>
                 <h4>A Theme is something that connects all your songs together.</h4>
                 <h4> If you don't like that you can either <b style="color: red;">FUCK OFF</b> or write:</h4>
                 <h4>No Theme!</h4>
                 <h4>into the theme box!</h4>
                 <br>
                 <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
                    <div style="margin-left: 5%; margin-top: 5%;">
                 <h5>Give a Theme for Tonight</h5>
                 <p>Enter your theme for tonight's selection in the box above.</p>
                 <p>Note: Use <a href="theme.php?id=72"><b style="color: cyan;">No Theme!</b></a> to have no theme.</p>
                <form action="levy.php" method="post" autocomplete="off">
                  <input type="text" name="themechange" placeholder="THEME NAME" />
                  <input type="text" name="themechangesub" placeholder="Subtitle for theme (Optional)" />
                  <input type="submit" value="CHANGE THEME"/><br>

                </form>
              </div>
            </div>
          -->

               </div>
               <?php }
               /*
               if($themetime < $currenttime & $currenttheme !== 'No Theme!') {
               */

               ?>

               <!--
                 <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
                    <div style="margin-left: 5%; margin-top: 5%;">
                 <h5>Give a Theme for Tonight</h5>
                 <p>Enter your theme for tonight's selection in the box below.</p>
                 <p>Note: Use <a href="theme.php?id=72"><b style="color: cyan;">No Theme!</b></a> to have no theme.</p>
                <form action="levy.php" method="post" autocomplete="off">
                  <input type="text" name="themechange" placeholder="THEME NAME" />
                  <input type="text" name="themechangesub" placeholder="Subtitle for theme (Optional)" />
                  <input type="submit" value="CHANGE THEME"/><br>

                </form>
              </div>
            </div>
          -->


        <?php/* } else { */?>

      <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
        <div style="margin-left: 5%; margin-top: 5%;">
      <h5 margin-top="5px" style="color: red;">Put Up a Song and ISOLATE!</h5>
      <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%; margin-top: 2%;">
        <div style="margin-left: 5%;">
      <p>YOUR THEME FOR TONIGHT</p>
        <p><a href="theme.php?id=<?php echo $currentthemeid['themeid'];?>"><b style="color: Cyan;"><?php echo $currenttheme['currenttheme'];?></b></a></p>
      <?php if (!empty($currentthemeid['themesubtitle'])) { ?>

        <p style="margin-top: -2%;" ><i><?php echo $currentthemeid['themesubtitle']; ?></i></p>
       <?php } ?>
     </div>
   </div>
      <p>Give the name, artist and song link and POST THAT SHIT.</p>

        <form action="levy.php" method="post" autocomplete="off">
          <input type="text" name="song" placeholder="Song" />
          <input type="text" name="artist" placeholder="Artist" />
          <input type="text" name="songlink" placeholder="Link to song" />
          <input type="text" name="songcomment" placeholder="Say something about the song (Optional)" maxlength="1000"/>
          <input type="hidden" name="theme" value="<?php echo $currenttheme['currenttheme'];?>" />
          <input type="submit" value="SUBMIT FOR JUDGEMENT!"/>
        </form>
      <!--
      <a href="logout.php">
      <div class="commentbutton">
      <p>LEAVE THE DISCO!<p>
      </div>
      </a>
      <br>
      -->
      <!--
      <div>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <center>
         <p style="color: yellow;"><a href="changetheme.php">Click Here to Change your Theme</a></p>
       </center>
        </div>
      -->
    </div>
    </div>

    <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">




      <a href="banger_new.php">
      <div class="bangerbutton">
        <br>
      <h5>HOW BAD IS THIS SHIT, NUMERICALLY?<h5>
        <br>
      </div>
      </a>
      <p></p>
      <a href="menu.php">
      <div class="commentbutton">
        <center>
      <p>&#128128; THE UNDERBELLY &#128128;</p>
      </center>
      </div>
      </a>
      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
      <h3>Wall of Judgement</h3>
      <?php if (empty($levyt)){ ?>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <h5>No one put on any songs today!</h5>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <br>
          <br>
      <?php } else { foreach ($levyt as $levy) { ?>
        <!--
      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
    -->
      <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
      <div style="margin-left: 5%; margin-top: 2%; margin-right: 5%;">
        <p>
            On <b style="font-size: 20pt; font-style: oblique;"><?php echo date ('l jS \of F Y \a\t G:i', $levy['thetime']); ?></b>, <b style="color: #00ff00;">
              <a href="user.php?id=<?php echo $levy['author'];?>"><?php echo $levy['author'];?></b> </a> put on:
        </p>

        <?php
          parse_str( parse_url( $levy['link'], PHP_URL_QUERY ), $my_array_of_vars);

          $youtubelink = $my_array_of_vars['v'];
          $youtubelink = trim($youtubelink);
         ?>

        <h5>
          <u>
          <a target="_blank" href="<?php echo $levy['link']; ?>">
            <img src="https://img.youtube.com/vi/<?php echo $youtubelink;?>/mqdefault.jpg" style="border-radius: 5%;">
          <h5><?php echo $levy['songname']; ?> by <?php echo $levy['artist']; ?></h5>
          </a>
        </u>
        </h5>
          <?php if (!empty($levy['comment'])) { ?>
            <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%; margin-top: 2%;">
              <div style="margin-left: 2%;">
            <p><b><u>About this song</u></b></p>
            <p><i><?php echo $levy['comment']; ?></i></p>
          </div>
          </div>
          <?php }?>
      </div>
      <div style="margin-left: 5%; margin-right: 5%;">
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
      <table style="width:50%">

      <?php
          $judgement = new Raati;
          $judgements = $judgement->get_ratings($levy['songid']);

 if (empty($judgements)){ ?>


   <h5>No ratings yet...</h5>

<?php } else foreach ($judgements as $judgement) { ?>
            <tr>
              <td align="left">
            <a href="user.php?id=<?php echo $judgement['author'];?>"><p style="color: #00ff00; padding-bottom: -15pt;"><?php echo $judgement['author']; ?></p></a>
            </td>
          <td align="right">
            <p><?php  echo $judgement['rating']; ?></p>
          </td>
        </tr>
      <?php }?>

    </table>
    <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
    <?php
    $query = $pdo->prepare("SELECT AVG(rating) AS ratings_sum FROM ratings WHERE songid = ?;");
    $query->bindValue(1, $levy['songid']);

    $query->execute();
    $thetotal = $query->fetch();
    ?>
    <br>
    <h5>Total rating:<b style="color: #e8b923;"> <?php echo round($thetotal['ratings_sum'], 2); ?></b></h5>

      <br>
      <form action="levy.php" method="post" autocomplete="off" id="<?php echo $levy['songid']?>" >
        <input type="hidden" name="songid" value="<?php echo $levy['songid']?>">
        <input style="width: 100%;" type="number" step="any" name="rating" placeholder="So, what grade do you give it?" />
        <input style="width: 100%;" type="submit" value="JUDGEMENT!"/>
      </form>
      <!--
      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
    -->
    </div>
  </div>
  <br>
      <?php  } ?>
      <br>
      <br>
  </body>
</html>


<?php

}

/*
}
*/
} else {
  header('Location: index.php');
}

 ?>
