<?php
session_start();

/*
PUT THE LEVYRAATI DAY HERE!
*/
$levyraatiday = "Saturday";

include_once('../levy/includes/connection.php');

date_default_timezone_set('Europe/Helsinki');

$date = date("l");

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
    <title>LEVYRAATI</title>
    <link rel="stylesheet" href="style.css"/>

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


        <div class="font-effect-anaglyph">
          <h1>PANDEMIC<br>LEVYRAATI</h1>
          <br>
        </div>
        <div>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <?php if($date == $levyraatiday){ ?>
          <h5>TODAY IS <?php echo strtoupper($date);?>.</h5>
          <h5 style="color:#00ff00;">THE LEVYRAATI IS FUCKING ON.</h5>
          <!--
          <h5 style="color:gold;">IT'S LEVYRAATI 100.</h5>
          <h5>WELCOME TO THE NIGHTMARE.</h5>
          -->

        <?php } else { ?>
          <!--
          <h5 style="color:gold;">COUNTDOWN TO LEVYRAATI 100</h5>
          -->
          <h5>TODAY IS <?php echo strtoupper($date);?>.</h5>
          <h5 style="color:red;">THE LEVYRAATI IS ON <?php echo strtoupper($levyraatiday);?> YOU FUCK.</h5>

        <?php }?>
          <!-- <h5 style="color:#ff0000;">WE ARE ON HIATUS NOW</h5> -->
    	    <p class="intro">Disease is everywhere. Indoors is the only safe place left.</p>
          <h5>STAY INSIDE. <br>RATE SONGS. <br>REMAIN PURE.</h5>
          <!--
          <p class="intro">We listen to music as the world dies and rate songs as disease ravages nations. Get ready for a good time cowboy...</p>
          -->
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        </div>

<div>

<?php if (isset($error)) { ?>
    <h5 style="color:#ff0000;"><?php echo $error; ?></h5>

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
