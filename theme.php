<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  if (isset($_GET['id'])) {
      $id = $_GET['id'];

      include_once('../levy/includes/getlevyt.php');

      $currenttime = time();

      $query = $pdo->prepare("SELECT theme, themeby, themedate, themesubtitle FROM themes WHERE themeid = ?;");
      $query->bindValue(1, $id);

      $query->execute();
      $themeinfo = $query->fetch();

      $themerating = 0;
      $themeratingno = 0;

      $playlistlink = "https://www.youtube.com/watch_videos?video_ids=";


      if (isset($_POST['missingtheme'])) {

          $theman = $_SESSION['user'];
          $checktheman = $themeinfo['themeby'];


        if ($theman == $checktheman) {

            $missingtheme = $_POST['missingtheme'];


            $query = $pdo->prepare("UPDATE themes SET theme = ? WHERE themeid = ?;");
            $query->bindValue(1, $missingtheme);
            $query->bindValue(2, $id);
            $query->execute();

            $success = 'THEME ADDED.';
            header('Location: theme.php?id='.$id);

            } else {

              $error = 'THIS IS NOT YOUR THEME YOU STUPID BITCH.';


                }

            } else {
              $error = 'This playlist has no theme. Infuse the collection of songs with meaning and HONOR THE LEVYRAATI.';


}



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


  <body bgcolor="#000000">

    <div class="Halfpic">
      <img class="Halfpic" src="greybackmusicskull.jpg">
      </div>

      <div class="Halftext">
        <div class="font-effect-anaglyph">
          <h1>PANDEMIC<br>LEVYRAATI</h1>
        </div>
        <div>

        </div>
  <br>



      <?php

          $query = $pdo->prepare("SELECT songid, artist, songname, comment, link, author FROM songs WHERE theme= ?;");
          $query->bindValue(1, $id);

          $query->execute();
          $themesongs = $query->fetchAll();

        ?>


          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <p class="intro"> The human mind collapses into itself without narratives. For this reason the Levyraati employs <b>THEMES</b>.</p>
          <p class="intro">Listen to this carefully curated playlist AND DON'T GO OUTSIDE IT'S FUCKING DANGEROUS, PLAGUE IS EVERYWHERE.</p>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">


          <?php if (empty($themeinfo['theme'])) { ?>

            <?php if (isset($error)) { ?>
              <p style="color:#FF0000; font-size: 22pt;"><b><?php echo $error; ?></b></p>
            <?php } ?>

            <?php if (isset($success)) { ?>
              <h5 style="color:#2ecc71 ;"><?php echo $success; ?></h5>
            <?php } ?>

            <form action="theme.php?id=<?php echo $id;?>" method="post" autocomplete="off">
              <input type="text" name="missingtheme" placeholder="What was the theme?" />
              <input type="submit" value="ENTER THAT MISSING INFO BABY!"/>
            </form>


            <?php } else { ?>

          <h3 style="width: 80%; color: aqua;"><?php echo $themeinfo['theme'];?></h3>
          <?php if (!empty($themeinfo['themesubtitle'])){ ?>
          <p style="width:80%; "><b> <?php echo $themeinfo['themesubtitle']; ?></b></p>
          <br>
        <?php }?>

            <?php } ?>


          <p class="intro">This playlist is by <b style="color: #00ff00;"><a href="user.php?id=<?php echo $themeinfo['themeby'];?>"><?php echo $themeinfo['themeby'];?></b></a></p>
          <p class="intro">This theme appeared on the Levyraati <b style="color: #00ff00;"><?php echo date ('l jS \of F Y', $themeinfo['themedate']);?></b></p>
          <div id="themedatatop"></div>

          <button style=" background-color: #FFFFFF;
  border: none;
  color: black;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;" id="hide" onclick="orderThemes()" >Order List by Average</button>


            <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">



            <div id="main">
          <?php
          $allthemesongs = new Raati;

          if (empty($themesongs)) { ?>
            <p>This theme DOES NOT EXIST!</p>
        <?php } else {
          foreach ($themesongs as $allthemesongs) { ?>

            <?php
                      $query = $pdo->prepare("SELECT AVG(rating) AS ratings_sum FROM ratings WHERE songid = ?;");
                      $query->bindValue(1, $allthemesongs['songid']);

                      $query->execute();
                      $thetotal = $query->fetch();
            ?>

            <?php
                      $query = $pdo->prepare("SELECT rating AS personal_rating FROM ratings WHERE songid = ? AND AUTHOR = ? ;");
                      $query->bindValue(1, $allthemesongs['songid']);
                      $query->bindValue(2, $_SESSION['user']);

                      $query->execute();
                      $personaltotal = $query->fetch();
            ?>

            <?php
              parse_str( parse_url( $allthemesongs['link'], PHP_URL_QUERY ), $my_array_of_vars);

              $youtubelink = $my_array_of_vars['v'];
              $youtubelink = trim($youtubelink);

              if(!empty($youtubelink)){
                $playlistlink .= $youtubelink;
                $playlistlink .= ",";
                  }
             ?>
            <div id="dv_<?php echo round($thetotal['ratings_sum'], 3); ?>">
            <div style="justify-content: center;">
            <a target="_blank" href="<?php echo $allthemesongs['link']; ?>">
              <img src="https://img.youtube.com/vi/<?php echo $youtubelink;?>/mqdefault.jpg" style="border-radius: 5%;">
            <p style="width:80%;"><b style="color: #e8b923;"><?php echo $allthemesongs['songname']; ?> </b>by<br><b style="color: #e8b923;"> <?php echo $allthemesongs['artist']; ?></b></p>
            </a>



            <?php if (!empty($allthemesongs['comment'])) { ?>
              <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%; margin-top: 2%;">
                <div style="margin-left: 2%;">
              <p><b>About this song</b></p>
              <p><i><?php echo $allthemesongs['comment']; ?></i></p>
            </div>
            </div>
            <?php }?>

            <?php if ($themeinfo['themeby'] == 'Everyone') { ?>
            <p style="width:80%;"><b>This song was chosen by</b><a href="user.php?id=<?php echo $allthemesongs['author'];?>"> <b style="color: #00ff00;"><?php echo $allthemesongs['author']; ?></b></a></p>

            <?php }?>


            <p>This song got a total rating of: <b style="color: #e8b923;"> <?php echo round($thetotal['ratings_sum'], 3); ?></b></p>
            <?php $themerating +=  $thetotal['ratings_sum']; ?>
            <?php $themeratingno +=  1; ?>
            <p>You gave it a total rating of: <b style="color: #ffbdde;"> <?php echo round($personaltotal['personal_rating'], 4); ?></b></p>


            <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          </div>
        </div>
          <?php }?>
        <?php }?>
          <br>
        <div id="themedata">
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <a href="<?php echo $playlistlink; ?>" target="_blank">
          <p>
             <img src="playlist.png" height="10%"> Create YouTube playlist from Theme
          </p>

          </a>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <p>
            This theme got  a total average rating of <h5><b style="color: #c0c0c0;"> <?php echo ($themerating/$themeratingno); ?></b></h5>
          </p>
          </div>
          <script>
          jQuery("#themedata").detach().appendTo('#themedatatop')

          </script>

      </div>

          <br>

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
        <br>

        <script type="text/javascript">
        function orderThemes(){
          var main = document.getElementById( 'main' );

          [].map.call( main.children, Object ).sort( function ( b, a ) {
              return +a.id.match( /\d+.[0-9]+/ ) - +b.id.match( /\d+.[0-9]+/ );
          }).forEach( function ( elem ) {
              main.appendChild( elem );
          });


          var divelement = document.getElementById('hide');

              if(divelement.style.display == 'none')
                    divelement.style.display =='block';
                else
                    divelement.style.display = 'none';
                    hidenow = button.style.visibility = "hidden";
                  }


        </script>




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
