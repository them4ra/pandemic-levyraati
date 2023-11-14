<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  include_once('../levy/includes/getlevyt.php');
  $levy= new Raati;
  $levyt = $levy->get_all_levyt();

  $currenttime = time();
  $wantedtime = (86400);



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

      <?php
      $query = $pdo->prepare("SELECT COUNT(*) FROM songs");
      $query->execute();

      $numberofsong = $query->fetch();

      ?>


      <div class="Halftext">
        <div class="font-effect-anaglyph">
          <h1>THE LIST</h1>
          <h5 style="margin-top:50px; margin-bottom: 10px;">ALL THE SONGS. ALL OF THEM.</h5>
        </div>
        <div>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <?php if (isset($error)) { ?>
            <p style="color:#FF0000;"><?php echo $error; ?></p>
          <?php } ?>

          <?php
          $top = new Raati;
          $top10 = $top->get_them_all();

          $rank = 1;
          $fh = fopen('levyraati_list.txt', 'w');
          fwrite($fh, "PANDEMIC LEVYRAATI - THE LIST OF THEM ALL");
          fwrite($fh, "\n");
          fwrite($fh, "The holy records of every song played during the Pandemic Levyraati.");
          fwrite($fh, "\n");
          fwrite($fh, "\n");
          fwrite($fh, "\n");
          fwrite($fh, "rank;artist;songname;put on by;total score;date;theme;rated by;rating;");
          fwrite($fh, "\n");

          if (empty($top10)) { ?>
            <p>IF YOU ARE READING THIS THE DATABASE IS FUCKED!</p>
        <?php } else {
          foreach ($top10 as $top) { ?>

                <?php
                $top10name = new Raati;
                $top10song = $top10name->get_banger($top['songid']);

                fwrite($fh, $rank);
                fwrite($fh, ";");
                $rank = $rank + 1;
                fwrite($fh, $top10song['artist']);
                fwrite($fh, ";");
                fwrite($fh, $top10song['songname']);
                fwrite($fh, ";");
                fwrite($fh, $top['songby']);
                fwrite($fh, ";");
                fwrite($fh, $top['AVG(rating)']);
                fwrite($fh, ";");
                fwrite($fh, gmdate("d/m/Y/H:i:s", $top10song['thetime'] + 7200));
                fwrite($fh, ";");


                $query = $pdo->prepare("SELECT theme FROM songs WHERE songid = ?;");
                $query->bindValue(1, $top['songid']);

                $query->execute();
                $themenumber = $query->fetch();


                $query = $pdo->prepare("SELECT theme FROM themes WHERE themeid = ?;");
                $query->bindValue(1, $themenumber['theme']);

                $query->execute();
                $themename = $query->fetch();

                fwrite($fh, $themename['theme']);
                fwrite($fh, ";");

                $topratings = new Raati;
                $topratings2 = $topratings->get_all_ratings_2($top['songid']);

                foreach ($topratings2 as $topratings) {
                fwrite($fh, $topratings['author']);
                fwrite($fh, ";");
                fwrite($fh, $topratings['rating']);
                fwrite($fh, ";");
                    }
                fwrite($fh, "\n");
                ?>
                <!--
            <a target="_blank" href="<?php /* echo $top10song['link']; ?>">
            <p style="width:80%;"><b style="color: #e8b923;"><?php echo $top10song['songname']; ?> - <?php echo $top10song['artist']; ?></p>
            </a>
            <li style="color: #ffffff;">
            <p style="color: #ffffff;">Chosen by <b style="color: #00ff00; padding-bottom:-15pt;"><?php echo $top['songby']; ?></b></p>

            <p style="color: #ffffff;" width="80%">Rating: <b style="color: #e8b923;"><?php  echo $top['AVG(rating)']; */?></b></p>

            </li>

            <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          -->

          <?php }?>
          <!--
        </ol>
        </div>
      -->
        <?php

          fclose($fh);
        }?>


    	    <p class="intro">Dozens of nights. Hundreds of songs. This is a list of them all, in order by rating. </p>
          <p class="intro">STAY INSIDE. NEVER LEAVE. THIS IS THE NEW NORMAL.</p>
          <p class="intro"><b style="color: red;"><?php echo $rank - 1 ?></b> songs have been played during the HOLY QUARANTINE!</p>
          <a href="levyraati_list.txt" style="color: #e8b923;">OPEN THE LIST OF THEM ALL!!!!!</a>
          <hr width="80%" color="" size="2" align="left" margin-bottom="-5px">

        </p>
        <a href="pastbangers.php?timestamp=<?php echo ($wantedtime)?>">
        <a href="levy.php">
        <div class="commentbutton">
        <p>GO BACK TO THE PARTY!<p>
        </div>
        </a>
        <p></p>
        <a href="logout.php">
        <div class="commentbutton">
        <p>LEAVE THE DISCO!<p>
        </div>
        </a>

        <!--
        <h2 style="width: 80%;">THE LIST OF OBJECTIVE RATINGS</h2>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        -->

        <div style="width:80%">
          <ol>

      <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
      <br>

  </body>
</html>


<?php

} else {
  header('Location: index.php');
}

 ?>
