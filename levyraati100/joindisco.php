<?php

session_start();

$entrycode = 'p4rty45th3w0r1dd1e5!';

include_once('../levy/includes/connection.php');

  if (isset($_POST['user'], $_POST['pass'], $_POST['passagain'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $passagain = $_POST['passagain'];
    $invitecode = $_POST['invitecode'];

    $levy100theme = 'LEVYRAATI 100';

    if ($invitecode != $entrycode){

      $error = 'The bouncer says "THAT IS NOT THE INVITE CODE! THIS PARTY IS ONLY FOR MARA AND THE BOYS!"';

    } else {

    if (empty($user) or empty($pass) or empty($passagain)) {

      $error = 'The bouncer says "WHAT KIND OF GAME ARE YOU PLAYING?"';

      } else {
        $query = $pdo->prepare("SELECT * FROM users WHERE name = ?");

        $query->bindvalue(1, $user);
        $query->execute();
        $payload = $query->fetch();
        $alreadyuser = $payload['name'];

          if ($alreadyuser) {

              $error = 'SOMEONE IS USING THAT SWEET MADE-UP NAME ALREADY, CHOOSE ANOTHER ONE.';

            } else {
                if ($pass != $passagain){

                    $error = "HEY, STAY CONSISTENT WITH YOUR PASSWORD BUD.";

                    } else {
                      //mysql stuff to add user
                      $hashedpassword=password_hash($pass, PASSWORD_DEFAULT);
                      $query = $pdo->prepare("INSERT INTO users (name, password, currenttheme)
                      VALUES (?, ?, ?)");
                      $query->bindValue(1, $user);
                      $query->bindValue(2, $hashedpassword);
                      $query->bindValue(3, $levy100theme);
                      $query->execute();

                      $_SESSION['logged_in_levy'] = true;
                      $_SESSION['user'] = $user;
                      header('Location: levy.php');
                      exit();

                }

            }
        }
    }

}
?>

<html>
  <head>
    <title>WELCOME TO THE END OF THE WORLD</title>
    <link rel="stylesheet" href="/style.css"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/faviconlevy/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/faviconlevy/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/faviconlevy/favicon-16x16.png">
    <link rel="manifest" href="/faviconlevy/site.webmanifest">

  </head>

  <body>
    <body bgcolor="#000000">

    <div class="Halfpic">
      <a href="index.php">
        <img class="Halfpic" src="greybackmusicskull_old.jpg">
      </a>
      </div>

      <div class="Halftext">
        <div class="font-effect-anaglyph">
          <h1>PANDEMIC<br>LEVYRAATI</h1>
          <h5 style="margin-top:50px; margin-bottom: 10px; color: red;">JOIN THE PRIVATE PARTY</h5>
        </div>
        <div>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
    	    <p class="intro">So, the world is dying and you want to have a good time?</p>
          <p class="intro">You came to the right place.</p>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        </div>

<div>

<?php if (isset($error)) { ?>
    <p style="color:#ff0000;"><?php echo $error; ?></p>
<?php } ?>

<div>
<p class="intro">Give your name and make up a password.</p>
<p class="intro">Then give the fucking invite code Mara gave you.</p>
<form action="joindisco.php" method="post" autocomplete="off">
  <input type="text" name="user" placeholder="Give your name..."/>
  <br>
  <input type="password" name="pass" placeholder="Whisper a password to me..."/>
  <br>
  <input type="password" name="passagain" placeholder="Whisper the password again..."/>
  <br>
  <input type="text" name="invitecode" placeholder="Enter Mara's invite code"/>
  <br>
  <input type="submit" value="JOIN THE PARTY" />
</form>
</div>

</div>

</html>
