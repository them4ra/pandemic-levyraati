<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  include_once('../levy/includes/getlevyt.php');

  $playlistlink = "https://www.youtube.com/watch_videos?video_ids=";


    $lowvalue = $_POST['lowvalue'];
    $highvalue = $_POST['highvalue'];
    $playlistlength = $_POST['playlistlength'];

    if($lowvalue <= 0){
      $lowvalue = 0;
      $error = 'Try setting some actual values next time you fucking idiot.';
    }
    if($highvalue >= 10){
      $highvalue = 10;
      $error = 'Try setting some actual values next time you fucking idiot.';
    }

    if ($playlistlength <= 0){
      $playlistlength = 50;
      $error = 'Try setting some actual values next time you fucking idiot.';
    }
    if ($playlistlength >= 50){
      $playlistlength = 50;
      $error = 'Try setting some actual values next time you fucking idiot.';
    }

    if ($playlistlength >= 50){
      $playlistlength = 50;
      $error = 'Try setting some actual values next time you fucking idiot.';
    }

    $query = $pdo->prepare("SELECT songid, rating FROM ratings WHERE rating >= ? AND rating <= ? AND author = ? ORDER BY RAND() LIMIT ?;");
    $query->bindValue(1, $lowvalue);
    $query->bindValue(2, $highvalue);
    $query->bindValue(3, $_SESSION['user']);
    $query->bindValue(4, $playlistlength, PDO::PARAM_INT);
    $query->execute();
    $playlistsongids = $query->fetchAll();



?>
<html>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
          <h5 style="margin-top:50px; margin-bottom: 10px; width: 80%;">

            <a href="user.php?id=<?php echo $_SESSION['user'];?>">
            <b style="color: #00ff00;"><?php echo $_SESSION['user']; ?></b>
            </a>
            <?php if($highvalue < 7){ ?>
            wants to <b style="color: red;">LISTEN TO SOME FUCKING SHIT.</b></h5>
          <?php } else {?>
          wants to <b style="color: green;">LISTEN TO SOMETHING FUCKING GOOD.</b></h5>

          <?php }?>


        </div>
        <div>
          <!-- Errors will be printed here -->
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <?php if (isset($error)) { ?>
            <p style="color:#FF0000; font-size: 22pt;"><?php echo $error; ?></p>
          <?php } ?>
        </div>

        <!-- This is where the playlist results will be displayed! -->
        <h5>Today's Playlist</h5>
        <div id="playlisttop"></div>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <p>Songs you rated between <br>
          <h5><?php echo $lowvalue;?> and <?php echo $highvalue;?></h></p>
        <p>This playlist has <?php echo $playlistlength;?> songs</p>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <a href="whattolistento.php"><h5 style="color: green;">Create New Playlist</h5></a>

         <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <?php

          foreach($playlistsongids as $playlistsongid){

            /* Get song, artist and YouTube link */
            $songid = $playlistsongid['songid'];

            $query = $pdo->prepare("SELECT songname, artist, link FROM songs WHERE songid = ?;");
            $query->bindValue(1, $songid);

            $query->execute();
            $songinplaylist = $query->fetch();

            parse_str( parse_url( $songinplaylist['link'], PHP_URL_QUERY ), $my_array_of_vars);

            $youtubelink = $my_array_of_vars['v'];
            $youtubelink = trim($youtubelink);

            if(!empty($youtubelink)){
              $playlistlink .= $youtubelink;
              $playlistlink .= ",";
                }


            ?>
            <a target="_blank" href="<?php echo   $songinplaylist['link']; ?>">
              <img src="https://img.youtube.com/vi/<?php echo $youtubelink;?>/mqdefault.jpg" style="border-radius: 5%;">

              <p style="width:80%;"><b style="color: #e8b923;"><?php echo $songinplaylist['artist']; ?></b> -<b style="color: silver;"> <?php echo $songinplaylist['songname'];?><p></b>

            </a>
            <p>You gave this song: <b style="color: pink;"><?php echo $playlistsongid['rating'];?></b></p>
            <hr width="80%" color="#FFFFFF" size="2" align="left">
        <?php


          }

        ?>

        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <div id="playlist">
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <a href="<?php echo $playlistlink; ?>" target="_blank">
          <p>
             <img src="playlist.png" height="10%"> Create YouTube Playlist
          </p>
          </a>

          </div>
          <script>
          jQuery("#playlist").detach().appendTo('#playlisttop')

          </script>
         <br>

       </div>


      </body>
    </html>

<?php

} else {
  header('Location: index.php');
}

 ?>
