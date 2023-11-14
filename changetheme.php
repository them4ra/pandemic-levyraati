<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  include_once('../levy/includes/getlevyt.php');


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
              <a href="levy.php">
                  <h1>PANDEMIC<br>LEVYRAATI</h1>
              </a>
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
          <h4>CHANGE YOUR THEME</h5>
          <p class="intro">You're getting drunk and now it's time to party.</p>
          <p class="intro">Martin is very likely passed out because he's a weak fuck.</p>
          <p class="intro">You can change your theme now.</p>
          <p class="intro">WASH YOUR HANDS, YOU MAY BE CAKED IN FILTH</p>

          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
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

         ?>

         <div>

           <p>YOUR CURRENT THEME:</p>

           <p><a href="theme.php?id=<?php echo $currentthemeid['themeid'];?>"><b style="color: Cyan;"><?php echo $currenttheme['currenttheme'];?></b></a></p>
           <?php if (!empty($currentthemeid['themesubtitle'])) { ?>

             <p style="margin-top: -2%;" ><?php echo $currentthemeid['themesubtitle']; ?></p>

            <?php } ?>
           </div>

           <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
             <div style="margin-left: 5%;">
               <br>



                 <h5>Change your Theme</h5>
                <form action="changetheme.php" method="post" autocomplete="off">
                  <input type="text" name="themechange" placeholder="THEME NAME" />
                  <input type="text" name="themechangesub" placeholder="Subtitle for theme (Optional)" />

                  <input type="submit" value="CHANGE THEME"/><br>

                </form>
                <p>Enter your theme for tonight's selection in the box above.</p>
                <p>Note: Use <a href="theme.php?id=72"><b style="color: cyan;">No Theme!</b></a> to have no theme.</p>
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
