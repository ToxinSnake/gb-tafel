<!DOCTYPE html>


<?php
include "./app/board_methods.php";

setlocale (LC_ALL, 'de_DE');

$bdset = getCurrentAndUpcoming();
if(empty($bdset)){
  $msg = "Keine Verbindung zur Datenbank möglich.";
}

?>

<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>GB Tafel</title>
  <meta name="description" content="">
  <meta name="author" content="Arne Otten">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/newgbstyle.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>
  <div class="row">

    <div class="twelve columns" id="header">
      <img src="images/trauco.png">
      <h4>12:45 Uhr<br>
        Donnerstag, 09.08.2018</h4>

    </div>

    <div class="six columns" id="left">
      <table class="u-full-width">
        <thead>
          <th>Datum</th>
          <th>Tag</th>
          <th>Name</th>
          <th>Alter</th>
        </thead>
        <tbody>
          <tr> <!-- Day -2 -->
            <td>07.08</td>
            <td>Dienstag</td>
            <td>Arne Otten</td>
            <td>24</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>Pia Flessner</td>
            <td>21</td>
          </tr>
          <!-- End of Day -2 -->

          <tr> <!-- Day -1 -->
            <td>08.08</td>
            <td>Mittwoch</td>
            <td>Lars Meyerhoff</td>
            <td>41</td>
          </tr> <!-- End of Day -1 -->

          <!-- Current day -->
          <?php
          if($bdset instanceof PDOStatement){
            foreach ($bdset as $row){
              ?>
          <tr class="current">
            <?php
              if(date('m-d') == substr($row['Birthday'],5,5)){
                $filled = TRUE; //needed to not have double entries

                //check if the current date is the same as the last
                if((substr($row['Birthday'],8,2).".".substr($row['Birthday'],5,2)) == $date){
                  $doubleDate = TRUE;
                } else {
                  $doubleDate = FALSE;
                }
                $date = substr($row['Birthday'],8,2).".".substr($row['Birthday'],5,2);

                //translate english weekdays to german
                $weekday = date('l');
                $weekday = strtr($weekday, $trans);

                //calculate age
                $age = date('Y') - substr($row['Birthday'],0,4);
            ?>
            <td><?php echo $doubleDate == TRUE ? "" : $date; ?></td>
            <td><?php echo $doubleDate == TRUE ? "" : $weekday; ?></td>
            <td><?php echo "{$row['Firstname']} {$row['Lastname']}";?></td>
            <td><?php echo $age; ?></td>
          </tr> <!-- End of current day -->
        <?php } //ENDIF

        // Other days
          //if birthday is not today
          if($filled == FALSE) {

            //check if the current date is the same as the last
            if((substr($row['Birthday'],8,2).".".substr($row['Birthday'],5,2)) == $date){
              $doubleDate = TRUE;
            } else {
              $doubleDate = FALSE;
            }
            $date = substr($row['Birthday'],8,2).".".substr($row['Birthday'],5,2);

            //Generate weekday from unix-timestamp and translate english weekdays to german
            $weekday = date('l', strtotime(date('Y')."-".substr($row['Birthday'],5,2)."-".substr($row['Birthday'],8,2)));
            $weekday = strtr($weekday, $trans);

            $age = date('Y') - substr($row['Birthday'],0,4);
           ?>
          <tr>
            <td><?php echo $doubleDate == TRUE ? "" : $date; ?></td>
            <td><?php echo $doubleDate == TRUE ? "" : $weekday; ?></td>
            <td><?php echo "{$row['Firstname']} {$row['Lastname']}";?></td>
            <td><?php echo $age; ?></td>
          </tr><!-- End of other days -->
          <?php
            } //ENDIF
            $filled = FALSE;
          } //ENDFOREACH
        }?>

        </tbody>
      </table>
    </div>

    <div class="six columns" id="right">
      <article>
        <h2>Nachricht des Tages</h2>
        <p>Hackerman immernoch unentdeckt.</p>
      </article>

      <article>
        <h2>Mitarbeiterfest</h2>
        <p>Jetzt sofort anmelden!</p>
      </article>

      <article>
        <h2>Ganz langer Text</h2>
        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
          invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam
          et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est
          Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
           diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,
            no sea takimata sanctus est Lorem ipsum dolor sit amet.At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,
            no sea takimata sanctus est Lorem ipsum dolor sit amet.At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,
            no sea takimata sanctus est Lorem ipsum dolor sit amet.At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren,
            no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
      </article>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
