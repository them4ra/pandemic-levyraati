<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  include_once('../levy/includes/getlevyt.php');



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
              <br>

        </div>
        <div>
          <!-- Errors will be printed here -->
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <?php if (isset($error)) { ?>
            <p style="color:#FF0000; font-size: 22pt;"><?php echo $error; ?></p>
          <?php } ?>

          <h4>What to Listen to Today?</h5>
          <p class="intro">It's probably not Saturday.</p>
          <p class="intro">You need to relive the high the Pandemic Levyraati gives you.</p>
          <p class="intro">Now you can get a playlist and GET MUSICALLY HIGH YOU JUNKIE FUCK.</p>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        </div>

           <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
             <div style="margin-left: 5%;">
               <br>

                <b style="color: #e8b923;">
                  <h5>Create a Playlist</h5>
                </b>

                <form action="whattolistento_result.php" method="post" autocomplete="off">
                  <input type="number" name="highvalue" step="any" placeholder="Choose songs no higher than..." />
                  <input type="number" name="lowvalue" step="any" placeholder="Choose songs no lower than..." />
                  <br>
                  <br>
                  <input type="number" name="playlistlength" placeholder="Number of songs you want" />
                  <input type="submit" name="createplaylist" value="Create Playlist"/><br>

                </form>
                <p>Give two ratings and a playlist will be created with songs you rated between the give values.</p>

              </div>
              </div>

              <br>
         <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

       </div>


      </body>
    </html>

<?php

} else {
  header('Location: index.php');
}

 ?>
