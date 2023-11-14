<?php

session_start();

include_once('../levy/includes/connection.php');

if (isset($_SESSION['logged_in_levy'])) {

  date_default_timezone_set('Europe/Helsinki');

  $user = $_SESSION['user'];

  if (isset($_POST['adminstatus'])) {

    $statuschange = $_POST['adminstatus'];
    $statuscomment = $_POST['admincomment'];
    $statusrequestid = $_POST['adminrequestid'];

    if (isset($_POST['fuckingsure'])) {

      $query = $pdo->prepare("UPDATE requests SET completed=1 WHERE requestid=?");
      $query->bindValue(1, $statusrequestid);


      $query->execute();
      header('Location: requests.php');

    } else {

    $query = $pdo->prepare("UPDATE requests SET requestState= ?, comment=?, commenttime =? WHERE requestid=?");
    $query->bindValue(1, $statuschange);
    $query->bindValue(2, $statuscomment);
    $query->bindValue(3, time());
    $query->bindValue(4, $statusrequestid);


    $query->execute();
    header('Location: requests.php');

    }

  }


  if (isset($_POST['request'])) {

      $request = $_POST['request'];
      $submitted = $_SESSION['user'];

      $emptycomment = "-";
      $keepcompleted = 0;


      if (empty($request)) {

      $error = 'JUST GIVE A FUCKING REQUEST AND STOP FUCKING AROUND.';

      } else {

      /* New request state is set to 0. 0 is for newly generated requests. */
      $requestState = 0;


      $query = $pdo->prepare("INSERT INTO requests (requestedBy, requestedOn, request, requestState, comment, completed, commenttime)
      VALUES (?, ?, ?, ?, ?, ?, ?)");
      $query->bindValue(1, $submitted);
      $query->bindValue(2, time());
      $query->bindValue(3, $request);
      $query->bindValue(4, $requestState );
      $query->bindValue(5, $emptycomment);
      $query->bindValue(6, $keepcompleted);
      $query->bindValue(7, time());


      $query->execute();
      header('Location: requests.php');

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
          <h1>PANDEMIC<br>LEVYRAATI</h1>
          <h5 style="margin-top:50px; margin-bottom: 10px; width: 80%; color: #ad00ad;">
            Requests Page
          </h5>

        </div>
        <div>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <!--This is where the error goes -->
          <?php if (isset($error)) { ?>
            <p style="color:#FF0000; font-size: 22pt;"><?php echo $error; ?></p>
          <?php } ?>
          <!--Intro flavor text -->
          <p class="intro">The pandemic is forever.</p>
          <p class="intro">The only safe place is this website.</p>
          <p class="intro">Add site feature requests here. You can also see the status of change requests. </p>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        </div>

        <a href="levy.php">
        <div class="commentbutton">
        <center>
        <p>&#127881; GO BACK TO THE PARTY! &#127881;</p>
        </center>
        </div>
        </a>

        <br>

         <div>

           <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
             <div style="margin-left: 5%; margin-top: 2%;">

               <br>
      <h5 margin-top="5px" style="color:  #ad00ad ;">Make a feature request</h5>
      <p>Write your request down here. Try to describe your request as specifically as possible. There is no need for excessive detail but the clearer the request, the faster I can get working on it.</p>

        <form action="requests.php" method="post" autocomplete="off">
          <textarea rows="5" cols="60" name="request" placeholder="What is your request?"></textarea>
          <input type="submit" value="Submit your request..."/>
        </form>
      <!--
      <a href="logout.php">
      <div class="commentbutton">
      <p>LEAVE THE DISCO!<p>
      </div>
      </a>
      <br>
      -->
    </div>
    </div>

    <br>

    <?php
    $query = $pdo->prepare("SELECT * FROM requests WHERE requestState = 2 ORDER BY commenttime DESC");

    $query->execute();

    $allrequests = $query->fetchAll();

    ?>

      <h3>Site Update Requests List</h3>
      <p style="color: green;"><a href="requests.php">Show All Requests</a></p>

      <?php if (empty($allrequests)){ ?>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <h5>No Requests!</h5>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
          <br>
          <br>
      <?php } else { foreach ($allrequests as $requestedinfo) {

          if($requestedinfo['completed'] == 0) {

        ?>



      <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
      <div style="margin-left: 5%; margin-top: 2%; margin-right: 5%;">
        <p>
            Request on <b style="font-size: 20pt; font-style: oblique;"><?php echo date ('l jS \of F Y \a\t G:i', $requestedinfo['requestedOn']); ?></b>
            <br>
             Request by <b style="color: #00ff00;"><?php echo $requestedinfo['requestedBy'];?></b>:
        </p>
        <h5>
          <hr width="80%" color="#FFFFFF" size="2" align="left" margin-left: "2%" margin-bottom="-5px">
          <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
            <h5 style="margin-left: 2%; margin-top: 2%;">Request:</h5>
            <p style="margin-left: 2%;"><?php echo $requestedinfo['request']; ?></p>
          </div>
        </h5>
        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <h5>Status:</h5>
        <?php
          $requeststatus = $requestedinfo['requestState'];
          if($requeststatus == 0) {
                        ?>
                <h5 style="color: orange;">Open</h5>
            <?php
          } elseif($requeststatus == 1){
                        ?>
                <h5 style="color: yellow;">Request is being worked on...</h5>
            <?php
          } elseif($requeststatus == 2){
                        ?>
                <h5 style="color: green;">Request added!</h5>
            <?php
          }elseif($requeststatus == 3){
                        ?>
                <h5 style="color: red;">Request denied. Sorry.</h5>
            <?php
          }
            ?>

      </div>
      <div style="margin-left: 5%; margin-right: 5%;">
                <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">
        <?php if(!empty($requestedinfo['commenttime'])){ ?>
        <p>Commented on <b style="font-size: 20pt; font-style: oblique;"><?php echo date ('l jS \of F Y \a\t G:i', $requestedinfo['commenttime']); ?></b></p>
        <?php }?>
        <?php
        if(!empty($requestedinfo['comment'])){
        ?>
        <p>From <b style="color: #00ff00;">Martin</b></p>
        <p><?php echo $requestedinfo['comment'];?></p>

        <?php } ?>

        <hr width="80%" color="#FFFFFF" size="2" align="left" margin-bottom="-5px">

        <?php
        /* YOU'RE THE ADMIN BABY! */
        if($user == 'Martin'){
          ?>
          <div style="border-style: solid; border-color: white; border-radius: 5px; width: 80%;">
          <div style="margin-left: 2%; margin-top: 2%;">
          <h5>Admin Tools</h5>
          <form action="requests.php" method="post" autocomplete="off">
            <input type="hidden" name="adminrequestid" value="<?php echo $requestedinfo['requestid']?>">
            <input type="number" name="adminstatus" placeholder="What status do you want to give this?" />
            <p>0=Open, 1=Being Worked On, 2=Granted, 3=Denied</p>
            <input type="text" name="admincomment" placeholder="Give a comment, if you want..." />
            <label class="container" style="width: 80%;">REMOVE REQUEST
              <input type="checkbox" name="fuckingsure" value="fuckingsure" class="largerCheckbox">
              <span class="checkmark"></span>
            </label>
            <input type="submit" value="Submit your request..."/>
          </form>
        </div>
        </div>
                <br>

                <?php

                  }
                ?>


      <table style="width:50%">


    </table>


    </div>
  </div>
  <br>
          <?php } ?>
      <?php  } ?>
      <br>
      <br>
  </body>
</html>


<?php

} } else {
  header('Location: index.php');
}

 ?>
