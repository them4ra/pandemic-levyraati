<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  include_once('../levy/includes/getlevyt.php');
  $levy= new Raati;
  $levyt = $levy->get_all_levyt();

  $currenttime = time();
  $wantedtime = ($currenttime-86400);

  /*Get the best song*/

  $query = $pdo->prepare("SELECT songid, AVG(rating) FROM ratings WHERE thetime >= ? GROUP BY songid ORDER BY 2 DESC LIMIT 1;");
  $query->bindValue(1, $wantedtime);

  $query->execute();
  $bangerid = $query->fetch();

  /*Get the worst song*/

  $query = $pdo->prepare("SELECT songid, AVG(rating) FROM ratings WHERE thetime >= ? GROUP BY songid ORDER BY 2 ASC LIMIT 1;");
  $query->bindValue(1, $wantedtime);

  $query->execute();
  $disgraceid = $query->fetch();


  $banger = new Raati;
  $getbanger = $banger->get_banger($bangerid['songid']);


  $disgrace = new Raati;
  $getdisgrace = $disgrace->get_banger($disgraceid['songid']);


  /* Get ranked list of all songs*/
  $query = $pdo->prepare("SELECT songid, aavg, @curRank := @curRank + 1 AS rank FROM (SELECT songid, AVG(rating) AS aavg FROM ratings, (SELECT @curRank := 0) r GROUP BY songid ORDER BY aavg DESC) dr GROUP BY songid ORDER BY  rank ASC");

  $query->execute();
  $bangeridplace = $query->fetchAll();



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
      <img class="Halfpic" src="greybackmusicskullafter.jpg">
      </div>

      <div class="Halftext">
        <div class="font-effect-anaglyph">
          <h1>PANDEMIC<br>LEVYRAATI</h1>
          <h5 style="margin-top:50px; margin-bottom: 10px;">Banger of the Day!</h5>
            <h5 class="intro" style="color: red;">AFTER MARTIN PASSED OUT</h5>
        </div>
        <div>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <?php if (isset($error)) { ?>
            <p style="color:#FF0000;"><?php echo $error; ?></p>
          <?php } ?>
    	    <p class="intro">Here it is!</p>
          <p class="intro">The Banger of the Day is...</p>
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

          $ultimatebangerid = $bangerid['songid'];

          ?>
          <br>
          <h5>Total rating:<b style="color: #e8b923;"> <?php echo round($thetotal['ratings_sum'], 2); ?></b></h5>

          <!-- Overall rank in the list -->

          <p>This song is

            <?php
            foreach($bangeridplace as $listofthemallrank) {

              if($listofthemallrank['songid'] == $ultimatebangerid){
                ?>
                <b style="color: gold;">
                <?php
                echo $listofthemallrank['rank'];
                  }
                  ?>
                </b>
                  <?php

                }
            ?>
            on the List of Them All</p>

            <!-- End of Section for Overall rank in the list -->

          <p>
            This song was chosen by <a href="user.php?id=<?php echo $getbanger['author'];?>"><b style="color: #00ff00;"><?php echo $getbanger['author']; ?></b></a>
          </p>

          <?php

          $query = $pdo->prepare("SELECT rating FROM ratings WHERE songid = ? AND author = ?;");
          $query->bindValue(1, $bangerid['songid']);
          $query->bindValue(2, $_SESSION['user']);

          $query->execute();
          $yourscore = $query->fetch();

          ?>

          <p>You gave it:<b style="color: fuchsia;"> <?php echo $yourscore['rating']; ?></b></p>


          <?php }?>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <p class="intro">The DISGRACE of the day is...</p>
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
          $ultimatedisgraceid = $disgraceid['songid'];
          ?>
          <br>
          <h5>Total rating:<b style="color: #e8b923;"> <?php echo round($thetotal['ratings_sum'], 2); ?></b></h5>

          <!-- Overall rank in the list -->

          <p>This song is

            <?php
            foreach($bangeridplace as $listofthemallrank) {

              if($listofthemallrank['songid'] == $ultimatedisgraceid){
                ?>
                <b style="color: gold;">
                <?php
                echo $listofthemallrank['rank'];
                  }
                  ?>
                </b>
                  <?php

                }
            ?>
            on the List of Them All</p>

          <p>
            This song was chosen by <a href="user.php?id=<?php echo $getdisgrace['author'];?>"><b style="color: #00ff00;"><?php echo $getdisgrace['author']; ?></b></a>
          </p>

          <?php

          $query = $pdo->prepare("SELECT rating FROM ratings WHERE songid = ? AND author = ?;");
          $query->bindValue(1, $disgraceid['songid']);
          $query->bindValue(2, $_SESSION['user']);

          $query->execute();
          $yourscore = $query->fetch();

          ?>

          <p>You gave it:<b style="color: fuchsia;"> <?php echo $yourscore['rating']; ?></b></p>



          <?php }?>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        </p>
        <p></p>
        <p></p>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <a href="banger_new.php">
        <div class="commentbutton" style="margin-top:50px; margin-bottom: 10px;">
        <p style="text-align:center;"><br>&#9201; WHILE THE COUNCIL WAS IN SESSION &#9201;<br><br></p>
        </div>
        </a>
        <p></p>

        <a href="levy.php">
        <div class="commentbutton">
        <center>
        <p>&#127881; GO BACK TO THE PARTY! &#127881;</p>
        </center>
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
        <br>


        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <h5>WHO'S TO BLAME</h5>
        <p>Who's to blame for all this...</p>
        <?php
        $user = new Raati;
        $allusers = $user->get_all_users();
        foreach ($allusers as $user) { ?>
          <?php

          $query = $pdo->prepare("SELECT theme, themeid FROM themes WHERE themeby = ? AND themedate >= ? LIMIT 1;");
          $query->bindValue(1, $user['name']);
          $query->bindValue(2, $wantedtime);

          $query->execute();
          $usertheme = $query->fetch();


          $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE songby= ? and thetime >= ? GROUP BY songid ORDER BY 3 DESC LIMIT 1;");
          $query->bindValue(1, $user['name']);
          $query->bindValue(2, $wantedtime);

          $query->execute();
          $personalbangerid = $query->fetch();

          $personalbanger = new Raati;
          $getpersonalbanger = $personalbanger->get_banger($personalbangerid['songid']);



          $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE songby= ? and thetime >= ? GROUP BY songid ORDER BY 3 ASC LIMIT 1;");
          $query->bindValue(1, $user['name']);
          $query->bindValue(2, $wantedtime);

          $query->execute();
          $personaldisgraceid = $query->fetch();

          $personaldisgrace = new Raati;
          $getpersonaldisgrace = $personaldisgrace->get_banger($personaldisgraceid['songid']);

          ?>

          <?php if (empty($getpersonalbanger)) { ?>

        <?php } else { ?>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <p><a href="user.php?id=<?php echo $user['name'];?>"><b style="color: #00ff00;"><?php echo $user['name']; ?></b></a> has the theme <a href="theme.php?id=<?php echo $usertheme['themeid'];?>"><b style="color: cyan;"> <?php echo $usertheme['theme'];?></a></b></p>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <p>Top song chosen by <a href="user.php?id=<?php echo $user['name'];?>"><b style="color: #00ff00;"><?php echo $user['name']; ?></b></a> is</p>
          <a target="_blank" href="<?php echo $getpersonalbanger['link']; ?>">
          <p style="width:80%;"><b style="color: #e8b923;"><?php echo $getpersonalbanger['songname'];?></b> by <b style="color: #e8b923;"><?php echo $getpersonalbanger['artist']; ?></b></p>
          </a>
          <p style="width:80%;">Total: <b style="color: #e8b923;"><?php echo $personalbangerid['AVG(rating)'] ?></b></p>


          <?php

          $query = $pdo->prepare("SELECT rating FROM ratings WHERE songid = ? AND author = ?;");
          $query->bindValue(1, $getpersonalbanger['songid']);
          $query->bindValue(2, $_SESSION['user']);

          $query->execute();
          $yourscore = $query->fetch();

          ?>

          <p>You gave it:<b style="color: fuchsia;"> <?php echo $yourscore['rating']; ?></b></p>



        <?php
              }
              ?>
              <?php if (empty($getpersonaldisgrace)) { ?>

            <?php } else { ?>
              <p><b>ABSOLUTE DISGRACE</b> chosen by <a href="user.php?id=<?php echo $user['name'];?>"><b style="color: #00ff00;"><?php echo $user['name']; ?></b></a> is</p>
              <a target="_blank" href="<?php echo $getpersonaldisgrace['link']; ?>">
              <p style="width:80%;"><b style="color: #e8b923;"><?php echo $getpersonaldisgrace['songname'];?></b> by <b style="color: #e8b923;"><?php echo $getpersonaldisgrace['artist']; ?></b></p>
              </a>
              <p style="width:80%;">Total: <b style="color: #e8b923;"><?php echo $personaldisgraceid['AVG(rating)'] ?></b></p>


                  <?php

                  $query = $pdo->prepare("SELECT rating FROM ratings WHERE songid = ? AND author = ?;");
                  $query->bindValue(1, $personaldisgraceid['songid']);
                  $query->bindValue(2, $_SESSION['user']);

                  $query->execute();
                  $yourscore = $query->fetch();

                  ?>

                  <p>You gave it:<b style="color: fuchsia;"> <?php echo $yourscore['rating']; ?></b></p>

                  <?php
                        }
                        ?>

        <?php
          }
        ?>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <h2 style="width: 80%;">Top 10</h2>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <div style="width:80%">
          <ol>
        <?php
        $top = new Raati;
        $top10 = $top->get_top10($wantedtime);
        if (empty($top10)) { ?>
          <p>No songs were put on today!</p>
      <?php } else {
        foreach ($top10 as $top) { ?>

              <?php
              $top10name = new Raati;
              $top10song = $top10name->get_banger($top['songid']);
              ?>
          <a target="_blank" href="<?php echo $top10song['link']; ?>">
          <p style="width:80%;"><b style="color: #e8b923;"><?php echo $top10song['songname']; ?> - <?php echo $top10song['artist']; ?></p>
          </a>
          <li style="color: #ffffff;">
          <p style="color: #ffffff;">Chosen by <b style="color: #00ff00; padding-bottom:-15pt;"><?php echo $top['songby']; ?></b></p>

          <p style="color: #ffffff;" width="80%">Rating: <b style="color: #e8b923;"><?php  echo $top['AVG(rating)'];?></b></p>


          <?php

          $query = $pdo->prepare("SELECT rating FROM ratings WHERE songid = ? AND author = ?;");
          $query->bindValue(1, $top10song['songid']);
          $query->bindValue(2, $_SESSION['user']);

          $query->execute();
          $yourscore = $query->fetch();

          ?>

          <p>You gave it:<b style="color: fuchsia;"> <?php echo $yourscore['rating']; ?></b></p>



          </li>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <?php }?>
      </ol>
      </div>
      <?php }?>
      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
      <br>

  </body>
</html>


<?php

} else {
  header('Location: index.php');
}

 ?>
