<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');


      include_once('../levy/includes/getlevyt.php');

      $currenttime = time();
      $wantedtime = ($currenttime-86400);

      $allsongs = new Raati;
      $getallsongs = $allsongs->get_all_levyt();

      $allthemes = new Raati;
      $getallsthemes = $allthemes->get_themes();


?>

<html>


  <head>
    <title>PANDEMIC LEVYRAATI</title>
    <link rel="stylesheet" href="style.css"/>

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
          <br>
          <p class="intro"> This is a list of <b>ALL THEMES</b> in ORDER, from BEST to FUCKING WORST.</p>
          <p class="intro">I learned JavaScript for this.</p>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        


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

<br>






          <?php

            $query = $pdo->prepare("SELECT themeid, theme, themedate, themesubtitle, themeby FROM themes ORDER BY 3 DESC;");

            $query->execute();
            $personalthemes = $query->fetchAll();

          ?>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <h5 style="width: 80%; margin-bottom="5px""><a href="userthemes.php?id=Everyone">See Themes by <b style="color: #00ff00;">Everyone</b></a></h5>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <h3 style="width: 80%;"> The List of All Themes</b></a></h3>
          <div style="width:80%">
            <ol>
          <div id="main">
          <?php
          $themename = new Raati;

          if (empty($personalthemes)) { ?>
            <p>This user has no themes!</p>
          <?php } else {
            foreach ($personalthemes as $themename) { ?>

              <?php
                /*Get the average for the theme  */


                /* Get every song from theme*/
                $query = $pdo->prepare("SELECT songid FROM songs WHERE theme = ?;");
                $query->bindValue(1, $themename['themeid']);

                $query->execute();
                $themesongid = $query->fetchAll();


                /* Create an array with only the songid values in it */

                $id_array = array_column($themesongid, 'songid');

                /* Create a list of question marks long enough for the MySQL query*/

                $in  = str_repeat('?,', count($id_array) - 1) . '?';


                /* Get total average of every song in the theme*/


                $query = $pdo->prepare("SELECT AVG(rating) AS themeaverage FROM ratings WHERE songid IN ($in);");

                /* Pass the array into the PDO query */
                $query->execute($id_array);
                $themeaverage = $query->fetch();
               ?>

              <div id="dv_<?php echo $themeaverage['themeaverage'];?>">
                <li>
              <a href="theme.php?id=<?php echo $themename['themeid'];?>">
                <p style="width:80%;"><b style="color: aqua;">--<?php echo $themename['theme']; ?>--</b></p>
                <?php if (!empty($themename['themesubtitle'])){ ?>
                <p style="width:80%;"><b>    -<?php echo $themename['themesubtitle']; ?>-</b></p>
              <?php }?>
              </a>
              <p style="color: #ffffff;">Theme appeared on the Levyraati <b style="color: #ccff99;"><?php echo date ('l jS \of F Y ', ($themename['themedate'])); ?></b></p>
                <p style="color: #ffffff;">This theme was by <b style="color: #00ff00;"> <a href="userthemes.php?id=<?php echo $themename['themeby'];?>"> <?php echo $themename['themeby']; ?></b> </a> </p>


               <p>Theme average: <b style="color: #e8b923;"><?php echo $themeaverage['themeaverage'];?></b></p>

               <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
               </li>
             </div>

            <?php }?>
          <?php }?>
          </div>
        </ol>


          </div>

          <br>
          <br>

        </body>
        <script type="text/javascript">

          var main = document.getElementById( 'main' );

          [].map.call( main.children, Object ).sort( function ( b, a ) {
              return +a.id.match( /\d+.[0-9]+/ ) - +b.id.match( /\d+.[0-9]+/ );
          }).forEach( function ( elem ) {
              main.appendChild( elem );
          });


        </script>
      </html>


      <?php



      } else {
          header('Location: index.php');

      }
       ?>
