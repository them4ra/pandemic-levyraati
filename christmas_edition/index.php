<?php
session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])){

  header('Location: levy.php');

 ?>
<?php
} else {
  if (isset($_POST['user'], $_POST['pass'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if (empty($user) or empty($pass)) {
      $error = 'The bouncer says "STOP FUCKING AROUND."';
    } else {
      $query = $pdo->prepare("SELECT * FROM users WHERE name = ?");

      $query->bindvalue(1, $user);
      $query->execute();
      $payload = $query->fetch();
      $hashedpass = $payload['password'];

      if ($user && password_verify($pass, $hashedpass)) {

        $_SESSION['logged_in_levy'] = true;
        $_SESSION['user'] = $user;
        header('Location: levy.php');
        exit();

      } else{
        $error = 'The bouncer says "ONLY FOR THE LEVYRAATI COWBOYS! EVERYONE ELSE FUCK OFF."';

      }

    }

  }

?>

<html>
  <head>
    <title>REMAIN PURE</title>
    <link rel="stylesheet" href="/style.css"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/faviconlevy/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/faviconlevy/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/faviconlevy/favicon-16x16.png">
    <link rel="manifest" href="/faviconlevy/site.webmanifest">


  </head>

  <body>
    <body bgcolor="#000000">

    <div class="Halfpic">
      <a href="joindisco.php">
        <picture>
            <source media="(max-width: 540px)" srcset="greybackmusicskull.jpg">
            <source media="(max-width: 1200px)" srcset="greybackmusicskull.jpg">
              <img class="Halfpic" src="greybackmusicskull.gif">
            </picture>
      </a>
      </div>

      <div class="Halftext">

        <audio autoplay loop>
            <source src="levy.wav" type="audio/mpeg">
            </audio>

<!--CHRISTMAS THEME! -->

            <div class="font-effect-anaglyph">
              <h1>PANDEMIC<br>LEVYRAATI</h1>
              <h5 style="margin-top:50px; margin-bottom: 10px; color: red;">CHRISTMAS EDITION</h5>
            </div>
            <div>
              <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        	    <p class="intro">All I want for Christmas is for <br>PEOPLE TO LEAVE ME THE FUCK ALONE AND NOT GIVE ME COVID.</p>
              <h5>STAY INSIDE AND TOASTY. <br>RATE CHRISTMAS SONGS. <br>REMAIN PURE AND JOLLY.</h5>


<!-- -->

<!--

        <div class="font-effect-anaglyph">
          <h1>PANDEMIC<br>LEVYRAATI</h1>
          <br>
        </div>
        <div>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
    	    <p class="intro">Disease is everywhere. Indoors is the only safe place left.</p>
          <h5>STAY INSIDE. <br>RATE SONGS. <br>REMAIN PURE.</h5>
          <!--
          <p class="intro">We listen to music as the world dies and rate songs as disease ravages nations. Get ready for a good time cowboy...</p>
          -->
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">


        </div>

<div>

<?php if (isset($error)) { ?>
    <p style="color:#ff0000;"><?php echo $error; ?></p>

<?php
      }
?>
<div>
<form action="index.php" method="post" autocomplete="off">
  <input type="text" name="user" placeholder="Who the fuck are you..."/>
  <br>
  <input type="password" name="pass" placeholder="Whisper your password..."/>
  <br>
  <input type="submit" value="ENTER THE LEVYRAATI" />
</form>
</div>

</div>

</html>

<?php
}
?>
