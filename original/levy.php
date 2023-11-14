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

  if (isset($_POST['fuckingsure'], $_POST['themechange'])) {

    $themechange = $_POST['themechange'];


    $query = $pdo->prepare("UPDATE users SET currenttheme = ? WHERE name=?");
    $query->bindValue(1, $themechange);
    $query->bindValue(2, $_SESSION['user']);
    $query->execute();

    if ($themechange != 'No Theme!') {

    $query = $pdo->prepare("INSERT INTO themes (theme, themeby, themedate)
    VALUES (?, ?, ?)");
    $query->bindValue(1, $themechange);
    $query->bindValue(2, $_SESSION['user']);
    $query->bindValue(3, time());

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



      $theme = $_POST['theme'];





      if (empty($song) or empty($artist)) {

      $error = 'GIVE A SONG AND ARTIST. NOT A HARD THING TO DO.';

      } else {

      $query = $pdo->prepare("SELECT themeid FROM themes WHERE theme = ?");
      $query->bindValue(1, $theme);
      $query->execute();

      $themeid = $query->fetch();

      $themeidnum = $themeid['themeid'];

      $query = $pdo->prepare("INSERT INTO songs (artist, songname, thetime, author, link, theme)
      VALUES (?, ?, ?, ?, ?, ?)");
      $query->bindValue(1, $artist);
      $query->bindValue(2, $song);
      $query->bindValue(3, time());
      $query->bindParam(4, $submitted);
      $query->bindParam(5, $songlink);
      $query->bindParam(6, $themeidnum);

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
      <img class="Halfpic" src="greybackmusicskull.jpg">
      </div>

      <div class="Halftext">
        <div class="font-effect-anaglyph">
          <h1>PANDEMIC<br>LEVYRAATI</h1>
          <h5 style="margin-top:50px; margin-bottom: 10px; width: 80%;">

            <a href="user.php?id=<?php echo $_SESSION['user'];?>">
            <b style="color: #00ff00;"><?php echo $_SESSION['user']; ?></b>
            </a>
            is INSIDE and SAFE FROM DISEASE.</h5>

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
          <p class="intro">Outside, every surface is caked in layers of putrid disease. Leaving your home will only invite decay into your life.</p>
          <p class="intro">WE ARE THE CHOSEN AND THE PURE.</p>
          <p class="intro">WE LISTEN TO MUSIC AS THE WORLD ROTS AWAY.</p>
          <p class="intro">ISOLATION IS OUR STRENGTH.</p>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        </div>


        <?php
        $query = $pdo->prepare("SELECT currenttheme FROM users WHERE name = ?");
        $query->bindValue(1, $_SESSION['user']);
        $query->execute();

        $currenttheme = $query->fetch();

         ?>

      <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
        <div style="margin-left: 5%; margin-top: 5%;">
      <h5 margin-top="5px" style="color: red;">Put Up a Song and ISOLATE!</h5>
      <p>Give the name, artist and song link and POST THAT SHIT.</p>

        <form action="levy.php" method="post" autocomplete="off">
          <input type="text" name="song" placeholder="Song" />
          <input type="text" name="artist" placeholder="Artist" />
          <input type="text" name="songlink" placeholder="Link to song...(Optional)" />
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
    </div>
    </div>

    <br>

      <div>

        <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
          <div style="margin-left: 5%; margin-top: 2%;">
       <p>Enter your theme for tonight in the box below. REMEMBER TO CHECK THE BOX!</p>
       <p>Use "<a href="theme.php?id=72"><b style="color: cyan;">No Theme!</b></a>" to have no theme.</p>
       <h4 style="color: SlateBlue;">Your current theme</h4>
      <form action="levy.php" method="post" autocomplete="off">
        <input type="text" name="themechange" value="<?php echo $currenttheme['currenttheme'];?>" />


      <label class="container" style="width: 80%;">Check the box if you're totally fucking sure you want to change your theme.
        <input type="checkbox" name="fuckingsure" value="fuckingsure" class="largerCheckbox">
        <span class="checkmark"></span>
      </label>



        <input type="submit" value="CHANGE THEME"/><br>

      </form>
    </div>
    </div>

      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

    </div>





      <a href="banger.php">
      <div class="bangerbutton">
        <br>
      <h5>GO TO THE BANGER BOARD!!!<h5>
        <br>
      </div>
      </a>
      <p></p>
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
      <div style="margin-left: 5%; margin-top: 2%;">
        <p>
            On <b style="font-size: 20pt; font-style: oblique;"><?php echo date ('l jS \of F Y \a\t G:i', $levy['thetime']); ?></b>, <b style="color: #00ff00;">
              <a href="user.php?id=<?php echo $levy['author'];?>"><?php echo $levy['author'];?></b> </a> put on:
        </p>
        <h5>
          <u>
          <a target="_blank" href="<?php echo $levy['link']; ?>">
          <h5><?php echo $levy['songname']; ?> by <?php echo $levy['artist']; ?></h5>
          </a>
        </u>
        </h5>
      </div>
      <div style="margin-left: 5%; margin-right: 5%;">
      <p>Ratings</p>
      <table style="width:50%">
      <?php
          $judgement = new Raati;
          $judgements = $judgement->get_ratings($levy['songid']);


 if (empty($judgements)){ ?>

   <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
   <h5>No ratings yet...</h5>
   <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

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

} } else {
  header('Location: index.php');
}

 ?>
