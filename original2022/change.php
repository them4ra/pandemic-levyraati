<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {
  if (isset($_POST['old'], $_POST['new'], $_POST['newagain'])) {
      $old = $_POST['old'];
      $new = $_POST['new'];
      $newagain = $_POST['newagain'];

      if (empty($old) or empty($new) or empty($newagain)) {
        $error = 'FILL IN THE FUCKING FIELDS ASSHOLE.';
      } else {

        $query = $pdo->prepare("SELECT * FROM users WHERE name = ?");
        $thename = $_SESSION['user'];
        $query->bindValue(1, $thename);

        $query->execute();
        $user = $query->fetch();
        $hashedpass = $user['password'];

            if ($new !== $newagain) {
              $error = 'TYPE THE NEW PASSWORD CORRECTLY AT LEAST TWICE YOU ILLITERATE FUCK';
                } else {

                    if (password_verify($old, $hashedpass)) {


                        $query = $pdo->prepare("UPDATE users SET password=? WHERE name=?");

                          $hashed = password_hash($new, PASSWORD_DEFAULT);
                          $thename = $_SESSION['user'];

                          $query->bindValue(1, $hashed);
                          $query->bindValue(2, $thename);

                          $query->execute();
                          $success = 'PASSWORD CHANGED YOU FUCK';

                      } else {
                          $error = 'YOU GOT YOUR OLD PASSWORD WRONG WHAT THE FUCK IS YOUR PROBLEM?';
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
              <h1>PANDEMIC LEVYRAATI</h1>
              <h5 style="margin-top:50px; margin-bottom: 10px;">&#128273; CHANGE PASSWORD &#128273;</h5>
            </div>


          <p>CHANGE THE SECRET WORD.<br> STAY SAFE.<br> STAY INSIDE. </p>

          <div style="width: 80%;">
          <?php if (isset($error)) { ?>
            <h6 style="color:#ff0000;"><?php echo $error; ?></h6>

          <?php } ?>
          <?php if (isset($success)) { ?>
            <h5 style="color:#2ecc71 ;"><?php echo $success; ?></h5>

          <?php } ?>
        </div>

          <form action="change.php" method="post" autocomplete="off">

                <input type="password" name="old" placeholder="OLD SHITTY PASSWORD" /><br />

                <input type="password" name="new" placeholder="NEW DOPE PASSWORD" /><br />

                <input type="password" name="newagain" placeholder="NEW DOPE PASSWORD AGAIN" /><br />

              <input type="submit" value="CHANGE YOUR FUCKING PASSWORD"/>

          </form>

            <div>
              <a href="levy.php">
              <div class="commentbutton">
              <p style="text-align:center">&#127881; GO BACK TO THE PARTY! &#127881;<p>
              </div>
              </a>
            </div>
            <p></p>
            <a href="logout.php">
            <div class="commentbutton">
              <center>
            <p>&#127771; LEAVE THE DISCO! &#127771;</p>
            </center>
            </div>
            </a>
            <br>
      </div>
    </body>
  </html>

  <?php
} else {
  header('Location: index.php');
}

 ?>
