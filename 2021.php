<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  include_once('../levy/includes/getlevyt.php');
  $levy= new Raati;
  $levyt = $levy->get_all_levyt();

  $currenttime = time();
  $wantedtime = (1609452320);

  $query = $pdo->prepare("SELECT songid, AVG(rating) FROM ratings WHERE thetime BETWEEN 1609452320 AND 1640901920 GROUP BY songid ORDER BY 2 DESC LIMIT 1;");
  $query->bindValue(1, $wantedtime);

  $query->execute();
  $bangerid = $query->fetch();

  $query = $pdo->prepare("SELECT songid, AVG(rating) FROM ratings WHERE thetime BETWEEN 1609452320 AND 1640901920 GROUP BY songid ORDER BY 2 ASC LIMIT 1;");
  $query->bindValue(1, $wantedtime);

  $query->execute();
  $disgraceid = $query->fetch();


  $banger = new Raati;
  $getbanger = $banger->get_banger($bangerid['songid']);


  $disgrace = new Raati;
  $getdisgrace = $disgrace->get_banger($disgraceid['songid']);


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
          <h2>&#11088; BEST OF 2021 &#11088;</h2>
          <h5 style="margin-top:50px; margin-bottom: 10px;">THE YEAR OF SHAME</h5>
        </div>
        <div>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <?php if (isset($error)) { ?>
            <p style="color:#FF0000;"><?php echo $error; ?></p>
          <?php } ?>
    	    <p class="intro">This year was full of plague. At least we listened to music.</p>
          <p class="intro">What was the best song of 2021? LET'S FIND OUT...</p>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
            <div width="80%">
              <h3 width="80%">THE ABSOLUTE BEAST OF 2021....</h3>
            </div>
        </div>
        <p>


        <?php if (empty($getbanger)){ ?>
            <h5>No one put on any songs today!</h5>
        <?php } else {?>
          <div style="width: 80%;">
          <a target="_blank" href="<?php echo $getbanger['link']; ?>">
          <b style="color: #e8b923;"><?php echo $getbanger['songname']; ?></b>
          by
          <b style="color: #e8b923;"><?php echo $getbanger['artist']; ?></b>
          </a>
          </div>
          <?php

          $query = $pdo->prepare("SELECT AVG(rating) AS ratings_sum FROM ratings WHERE songid = ?;");
          $query->bindValue(1, $bangerid['songid']);

          $query->execute();
          $thetotal = $query->fetch();


          $query = $pdo->prepare("SELECT theme, themeid, themedate FROM themes WHERE themeid = ?;");
          $query->bindValue(1, $getbanger['theme']);

          $query->execute();
          $thetotalbangertheme = $query->fetch();



          ?>
          <br>
          <h5>Total rating:<b style="color: #e8b923;"> <?php echo round($thetotal['ratings_sum'], 2); ?></b></h5>

          <p>
            This song was chosen by <a href="user.php?id=<?php echo $getbanger['author'];?>"><b style="color: #00ff00;"><?php echo $getbanger['author']; ?></b></a>
          </p>
          <p>
            This song was from the theme <a target="_blank" href="theme.php?id=<?php echo $thetotalbangertheme['themeid']; ?>"> <b style="color: aqua;"><?php echo $thetotalbangertheme['theme']; ?></b></a>
          </p>
          <p>
            This song was played <b style="color: #CC3399;"><?php echo date('d F Y', $thetotalbangertheme['themedate']); ?></b>
          </p>
          <?php }?>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <h3 width="80%">The SHAME song of 2021 was...</h3>
        <?php if (empty($getbanger)){ ?>
            <h5>No one put on any songs today!</h5>
        <?php } else {?>
          <div style="width: 80%;">
          <a target="_blank" href="<?php echo $getdisgrace['link']; ?>">
          <b style="color: #e8b923;"><?php echo $getdisgrace['songname']; ?></b>
          by
          <b style="color: #e8b923;"><?php echo $getdisgrace['artist']; ?></b>
          </a>
          </div>
          <?php

          $query = $pdo->prepare("SELECT AVG(rating) AS ratings_sum FROM ratings WHERE songid = ?;");
          $query->bindValue(1, $disgraceid['songid']);

          $query->execute();
          $thetotal = $query->fetch();



          $query = $pdo->prepare("SELECT theme, themeid, themedate FROM themes WHERE themeid = ?;");
          $query->bindValue(1, $getdisgrace['theme']);

          $query->execute();
          $thetotaldisgracetheme = $query->fetch();


          ?>

          <br>
          <h5>Total rating:<b style="color: #e8b923;"> <?php echo round($thetotal['ratings_sum'], 2); ?></b></h5>

          <p>
            This song was chosen by <a href="user.php?id=<?php echo $getdisgrace['author'];?>"><b style="color: #00ff00;"><?php echo $getdisgrace['author']; ?></b></a>
          </p>
          <p>
            This song was from the theme <a target="_blank" href="theme.php?id=<?php echo $thetotaldisgracetheme['themeid']; ?>"> <b style="color: aqua;"><?php echo $thetotaldisgracetheme['theme']; ?></b></a>
          </p>
          <p>
            This song was played <b style="color: #CC3399;"><?php echo date('d F Y', $thetotaldisgracetheme['themedate']); ?></b>
          </p>

          <?php }?>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        </p>
        <a href="pastbangers.php?timestamp=<?php echo ($wantedtime)?>">
        <a href="levy.php">
        <div class="commentbutton">
        <p style="text-align:center">&#127881; GO BACK TO THE PARTY! &#127881;<p>
        </div>
        </a>
        <p></p>
        <a href="logout.php">
        <div class="commentbutton">
        <p style="text-align:center">&#127771; LEAVE THE DISCO! &#127771;<p>
        </div>
        </a>

<?php

        $id = $_SESSION['user']

?>

        <?php

                $query = $pdo->prepare("SELECT songby, songid, rating, thetime FROM ratings WHERE thetime BETWEEN 1609452320 AND 1640901920 AND author= ? GROUP BY songid ORDER BY 3 DESC LIMIT 20;");
                $query->bindValue(1, $id);

                $query->execute();
                $personalbangerid = $query->fetchAll();

                ?>

                <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
                <h3 style="width: 80%;"><a href="user.php?id=<?php echo $id;?>"><b style="color: #00ff00;"><?php echo $id; ?></b></a>'s Favorite Songs of 2021 </h3>
                <div style="width:80%">
                  <ol>
                <?php
                $bottom = new Raati;

                if (empty($personalbangerid)) { ?>
                  <p>This feature is not for Everyone!</p>
              <?php } else {
                foreach ($personalbangerid as $bottom) { ?>

                      <?php
                      $bottom10name = new Raati;
                      $bottom10song = $bottom10name->get_banger($bottom['songid']);

                      $query = $pdo->prepare("SELECT theme, themeid, themedate FROM themes WHERE themeid = ?;");
                      $query->bindValue(1, $bottom10song['theme']);

                      $query->execute();
                      $the2021theme = $query->fetch();


                      ?>
                  <a href="<?php echo $bottom10song['link']; ?>" target="_blank">
                  <p style="width:80%;"><b style="color: #e8b923;"><?php echo $bottom10song['songname']; ?> </b><b style="color: #e8b923;"> by <?php echo $bottom10song['artist']; ?></b></p>
                  </a>
                  <li style="color: #ffffff;">
                  <p style="color: #ffffff;">Chosen on <b style="color: #ccff99;"><?php echo date ('l jS \of F Y \a\t G:i', ($bottom['thetime'])); ?></b> by <a href="user.php?id=<?php echo $bottom10song['author'];?>"> <b style="color: #00ff00;"> <?php echo $bottom10song['author']; ?> </b></a></p>
                  <p>
                    This song was from the theme <a target="_blank" href="theme.php?id=<?php echo $the2021theme['themeid']; ?>"> <b style="color: aqua;"><?php echo $the2021theme['theme']; ?></b></a>
                  </p>
                  <p style="color: #ffffff;" width="80%">You gave it: <b style="color: #e8b923;"><?php  echo $bottom['rating'];?></b></p>


                  </li>

                  <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

                <?php }?>
              <?php }?>
            </ol>
            </div>








        <h3>WHO'S TO BLAME</h3>
        <?php
        $user = new Raati;
        $allusers = $user->get_all_users();
        foreach ($allusers as $user) { ?>
          <?php

          /* THE BEST*/

          $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime BETWEEN 1609452320 AND 1640901920 AND songby = ? GROUP BY songid ORDER BY 3 DESC LIMIT 1;");
          $query->bindValue(1, $user['name']);

          $query->execute();
          $personalbangerid = $query->fetch();

          $personalbanger = new Raati;
          $getpersonalbanger = $personalbanger->get_banger($personalbangerid['songid']);




          $query = $pdo->prepare("SELECT theme, themeid, themedate FROM themes WHERE themeid = ?;");
          $query->bindValue(1, $getpersonalbanger['theme']);

          $query->execute();
          $thepersonalbangertheme = $query->fetch();




          /* THE WORST*/

          $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime BETWEEN 1609452320 AND 1640901920 AND songby = ? GROUP BY songid ORDER BY 3 ASC LIMIT 1;");
          $query->bindValue(1, $user['name']);

          $query->execute();
          $personaldisgraceid = $query->fetch();

          $personaldisgrace = new Raati;
          $getpersonaldisgrace = $personaldisgrace->get_banger($personaldisgraceid['songid']);



          $query = $pdo->prepare("SELECT theme, themeid, themedate FROM themes WHERE themeid = ?;");
          $query->bindValue(1, $getpersonaldisgrace['theme']);

          $query->execute();
          $thepersonaldisgracetheme = $query->fetch();



          ?>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <p><b>THE ABSOLUTE EARGASM</b> CHOSEN BY <a href="user.php?id=<?php echo $user['name'];?>"><b style="color: #00ff00;"><?php echo $user['name']; ?></b></a> WAS</p>
          <?php if (empty($getpersonalbanger)) { ?>
            <p>If you're reading this, the database is FUCKED!</p>
        <?php } else { ?>
          <a target="_blank" href="<?php echo $getpersonalbanger['link']; ?>">
          <p style="width:80%;"><b style="color: #e8b923;"><?php echo $getpersonalbanger['songname'];?></b> by <b style="color: #e8b923;"><?php echo $getpersonalbanger['artist']; ?></b></p>
          </a>
          <p style="width:80%;">Total: <b style="color: #e8b923;"><?php echo $personalbangerid['AVG(rating)'] ?></b></p>
          <p>
            This song was from the theme <a target="_blank" href="theme.php?id=<?php echo $thepersonalbangertheme['themeid']; ?>"> <b style="color: aqua;"><?php echo $thepersonalbangertheme['theme']; ?></b></a>
          </p>
          <p>
              This song was played <b style="color: #CC3399;"><?php echo date('d F Y', $thepersonalbangertheme['themedate']); ?></b>
          </p>
        <?php
              }
              ?>


              <p><b>THE WORST PIECE OF AURAL DIAHHREA</b> CHOSEN BY <a href="user.php?id=<?php echo $user['name'];?>"><b style="color: #00ff00;"><?php echo $user['name']; ?></b></a> WAS</p>
              <?php if (empty($getpersonaldisgrace)) { ?>
                <p>If you're reading this, the database is FUCKED!</p>
            <?php } else { ?>
              <a target="_blank" href="<?php echo $getpersonaldisgrace['link']; ?>">
              <p style="width:80%;"><b style="color: #e8b923;"><?php echo $getpersonaldisgrace['songname'];?></b> by <b style="color: #e8b923;"><?php echo $getpersonaldisgrace['artist']; ?></b></p>
              </a>
              <p style="width:80%;">Total: <b style="color: #e8b923;"><?php echo $personaldisgraceid['AVG(rating)'] ?></b></p>
              <p>
                This song was from the theme <a target="_blank" href="theme.php?id=<?php echo $thepersonaldisgracetheme['themeid']; ?>"> <b style="color: aqua;"><?php echo $thepersonaldisgracetheme['theme']; ?></b></a>
              </p>
              <p>
                  This song was played <b style="color: #CC3399;"><?php echo date('d F Y', $thepersonaldisgracetheme['themedate']); ?></b>
              </p>
            <?php
                  }
                  ?>

        <?php
          }
        ?>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <h2>&#128079;    &#128079;    &#128079;</h2>
        <h2 style="width: 80%;">THE BEST OF 2021</h2>
        <h2>&#128079;    &#128079;    &#128079;</h2>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <div style="width:80%">
          <ol>
        <?php
        $top = new Raati;
        $top10 = $top->get_top10_2021();

        if (empty($top10)) { ?>
          <p>If you're reading this, the database is FUCKED!</p>
      <?php } else {
        foreach ($top10 as $top) { ?>

              <?php
              $top10name = new Raati;
              $top10song = $top10name->get_banger($top['songid']);


              $query = $pdo->prepare("SELECT theme, themeid, themedate FROM themes WHERE themeid = ?;");
              $query->bindValue(1, $top10song['theme']);

              $query->execute();
              $thebangertheme = $query->fetch();


              ?>
          <a target="_blank" href="<?php echo $top10song['link']; ?>">
          <p style="width:80%;"><b style="color: #e8b923;"><?php echo $top10song['songname']; ?> - <?php echo $top10song['artist']; ?></p>
          </a>
          <li style="color: #ffffff;">
          <p style="color: #ffffff;">Chosen by <b style="color: #00ff00; padding-bottom:-15pt;"><?php echo $top['songby']; ?></b></p>

          <p style="color: #ffffff;" width="80%">Rating: <b style="color: #e8b923;"><?php  echo $top['AVG(rating)'];?></b></p>
          <p>
            This song was from the theme <a target="_blank" href="theme.php?id=<?php echo $thebangertheme['themeid']; ?>"> <b style="color: aqua;"><?php echo $thebangertheme['theme']; ?></b></a>
          </p>
          <p>
            This song was played <b style="color: #CC3399;"><?php echo date('d F Y', $thebangertheme['themedate']); ?></b>
          </p>

          </li>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <?php }?>
      </ol>
      </div>
      <?php }?>
      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

      <h2>&#128169;    &#128169;    &#128169;</h2>
      <h2 style="width: 80%; color: white;">THE SHIT OF 2021 (NOT IN A GOOD WAY)</h2>
      <h2>&#128169;    &#128169;    &#128169;</h2>
      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

      <div style="width:80%">
        <ol>
      <?php
      $bottom = new Raati;
      $bottom10 = $bottom->get_bottom10_2021();

      if (empty($bottom10)) { ?>
        <p>If you're reading this, the database is FUCKED!</p>
    <?php } else {
      foreach ($bottom10 as $bottom) { ?>

            <?php
            $bottom10name = new Raati;
            $bottom10song = $bottom10name->get_banger($bottom['songid']);



            $query = $pdo->prepare("SELECT theme, themeid, themedate FROM themes WHERE themeid = ?;");
            $query->bindValue(1, $bottom10song['theme']);

            $query->execute();
            $thedisgracetheme = $query->fetch();



            ?>
        <a target="_blank" href="<?php echo $bottom10song['link']; ?>">
        <p style="width:80%;"><b style="color: #e8b923;"><?php echo $bottom10song['songname']; ?> - <?php echo $bottom10song['artist']; ?></p>
        </a>
        <li style="color: #ffffff;">
        <p style="color: #ffffff;">Chosen by <b style="color: #00ff00; padding-bottom:-15pt;"><?php echo $bottom['songby']; ?></b></p>

        <p style="color: #ffffff;" width="80%">Rating: <b style="color: #e8b923;"><?php  echo $bottom['AVG(rating)'];?></b></p>

        <p>
          This song was from the theme <a target="_blank" href="theme.php?id=<?php echo $thedisgracetheme['themeid']; ?>"> <b style="color: aqua;"><?php echo $thedisgracetheme['theme']; ?></b></a>
        </p>
        <p>
          This song was played <b style="color: #CC3399;"><?php echo date('d F Y', $thedisgracetheme['themedate']); ?></b>

        </p>

        </li>

        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

      <?php }?>
    <?php }?>
  </ol>
  </div>
<hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

  </body>
</html>


<?php

} else {
  header('Location: index.php');
}

 ?>
