<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  if (isset($_GET['id'])) {
      $id = $_GET['id'];

      include_once('../levy/includes/getlevyt.php');

      $currenttime = time();
      $wantedtime = ($currenttime-86400);

      $allsongs = new Raati;
      $getallsongs = $allsongs->get_all_user_songs($id);

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
          <h5 style="margin-top:50px; margin-bottom: 10px;">BEHOLD! <br>The Distinguished Member of the High Council:<br> <b style="color: #00ff00;"><?php echo $id;?></b></h5>
        </div>


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

    $query = $pdo->prepare("SELECT AVG(rating) FROM ratings WHERE author= ?;");
    $query->bindValue(1, $id);

    $query->execute();
    $personalaverage = $query->fetch();


    ?>


    <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
    <h3 style="width: 80%;">Average Rating for <b style="color: green;"><?php echo $id; ?> <?php echo $personalaverage['AVG(rating)']; ?></b></h3>
    <div style="width:80%">

    </div>






          <?php

            $query = $pdo->prepare("SELECT themeid, theme, themedate FROM themes WHERE themeby= ? ORDER BY 3 DESC;");
            $query->bindValue(1, $id);

            $query->execute();
            $personalthemes = $query->fetchAll();

          ?>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <h3 style="width: 80%;"><a href="userthemes.php?id=<?php echo $id;?>">See Themes by <b style="color: aqua;"><?php echo $id; ?></b></a></h3>
          <div style="width:80%">

            <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
            <h5 style="width: 80%; margin-bottom="5px""><a href="userthemes.php?id=Everyone">See Themes by <b style="color: aqua;">Everyone</b></a></h5>
            <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
            <h5 style="width: 80%; margin-bottom="5px""><a href="bestthemes.php"><b style="color: aqua;">See All Themes in Order</b></a></h5>


          </div>



          <?php

                  $query = $pdo->prepare("SELECT songby, songid, rating, thetime FROM ratings WHERE author= ? GROUP BY songid ORDER BY 3 DESC LIMIT 20;");
                  $query->bindValue(1, $id);

                  $query->execute();
                  $personalbangerid = $query->fetchAll();

                  ?>

                  <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
                  <h3 style="width: 80%;"><a href="user.php?id=<?php echo $id;?>"><b style="color: #00ff00;"><?php echo $id; ?></b></a>'s Favorite Songs</h3>
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


                        ?>
                    <a href="<?php echo $bottom10song['link']; ?>" target="_blank">
                    <p style="width:80%;"><b style="color: #e8b923;"><?php echo $bottom10song['songname']; ?> </b><b style="color: #e8b923;"> by <?php echo $bottom10song['artist']; ?></b></p>
                    </a>
                    <li style="color: #ffffff;">
                    <p style="color: #ffffff;">Chosen on <b style="color: #ccff99;"><?php echo date ('l jS \of F Y \a\t G:i', ($bottom['thetime'])); ?></b> by <a href="user.php?id=<?php echo $bottom10song['author'];?>"> <b style="color: #00ff00;"> <?php echo $bottom10song['author']; ?> </b></a></p>

                    <p style="color: #ffffff;" width="80%"><?php echo $id?> gave it: <b style="color: #e8b923;"><?php  echo $bottom['rating'];?></b></p>


                    </li>

                    <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

                  <?php }?>
                <?php }?>
              </ol>
              </div>









  <?php

          $query = $pdo->prepare("SELECT songby, songid, AVG(rating), thetime FROM ratings WHERE songby= ? GROUP BY songid ORDER BY 3 DESC LIMIT 15;");
          $query->bindValue(1, $id);

          $query->execute();
          $personalbangerid = $query->fetchAll();

          ?>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <h3 style="width: 80%;">Top 15 All-Time Songs by <a href="user.php?id=<?php echo $id;?>"><b style="color: #00ff00;"><?php echo $id; ?></b></a> are</h3>
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
                ?>
            <a href="<?php echo $bottom10song['link']; ?>">
            <p style="width:80%;"><b style="color: #e8b923;"><?php echo $bottom10song['songname']; ?> </b><b style="color: #e8b923;"> by <?php echo $bottom10song['artist']; ?></b></p>
            </a>
            <li style="color: #ffffff;">
            <p style="color: #ffffff;">Chosen on <b style="color: #ccff99;"><?php echo date ('l jS \of F Y \a\t G:i', ($bottom['thetime'])); ?></b></p>

            <p style="color: #ffffff;" width="80%">Rating: <b style="color: #e8b923;"><?php  echo $bottom['AVG(rating)'];?></b></p>

            </li>

            <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

          <?php }?>
        <?php }?>
      </ol>
      </div>















    <?php

            $query = $pdo->prepare("SELECT songby, songid, AVG(rating), thetime FROM ratings WHERE songby= ? GROUP BY songid ORDER BY 3 ASC LIMIT 15;");
            $query->bindValue(1, $id);

            $query->execute();
            $personalbangerid = $query->fetchAll();

            ?>

            <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
            <h3 style="width: 80%;">Top 15 <b>FUCKING TURDS</b> by <a href="user.php?id=<?php echo $id;?>"><b style="color: #00ff00;"><?php echo $id; ?></b></a> are</h3>
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
                  ?>
              <a href="<?php echo $bottom10song['link']; ?>">
              <p style="width:80%;"><b style="color: #e8b923;"><?php echo $bottom10song['songname']; ?> </b>by<b style="color: #e8b923;"> <?php echo $bottom10song['artist']; ?></b></p>
              </a>
              <li style="color: #ffffff;">
              <p style="color: #ffffff;">Chosen on <b style="color: #ccff99;"><?php echo date ('l jS \of F Y \a\t G:i', ($bottom['thetime'])); ?></b></p>

              <p style="color: #ffffff;" width="80%">Rating: <b style="color: #e8b923;"><?php  echo $bottom['AVG(rating)'];?></b></p>

              </li>

              <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

            <?php }?>
          <?php }?>
        </ol>
        </div>
      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">










<!--



		<h2 style="width: 80%;">All Songs Chosen By <b style="color: #00ff00;"><?php echo $id;?></b></h2>


          <?php foreach ($getallsongs as $allsongs) { ?>

            <p style="color: #ccff99;"><?php echo date ('l jS \of F Y \a\t G:i', $allsongs['thetime']);?></p>
            <a target="_blank" href="<?php echo $allsongs['link']; ?>">
            <p><b style="color: #e8b923;"><?php echo $allsongs['songname'];?></b> - <b style="color: #e8b923;"><?php echo $allsongs['artist'];?></b></p>
            </a>

            <?php
            $query = $pdo->prepare("SELECT AVG(rating) AS ratings_sum FROM ratings WHERE songid = ?;");
            $query->bindValue(1, $allsongs['songid']);

            $query->execute();
            $thetotal = $query->fetch();

            $query = $pdo->prepare("SELECT rating FROM ratings WHERE author = ? AND songid = ?;");
            $query->bindValue(1, $_SESSION['user']);
            $query->bindValue(2, $allsongs['songid']);

            $query->execute();
            $personalrating = $query->fetch();


            ?>

            <p>Total rating: <b style="color: #e8b923;"> <?php echo round($thetotal['ratings_sum'], 2); ?></b></p>

            <p style="color: teal;">You gave it: <b style="color: fuchsia;"> <?php echo $personalrating['rating']; ?></b></p>
            <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

          <?php } ?>

-->

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        </p>


  </body>
</html>


<?php

} else {
    header('Location: index.php');
    exit();

}

} else {
    header('Location: index.php');

}
 ?>
