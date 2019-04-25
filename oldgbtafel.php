<!DOCTYPE html>


<?php
include "./app/board_methods.php";
$configs = include ('./app/config.php');

setlocale (LC_ALL, 'de_DE');

//Geburtstage
$bdsetPast = array_reverse(getPast()->fetchAll());
$bdsetUpcoming = getCurrentAndUpcoming();
$date = 0;
$currentDay = strtr(date('l'), $trans);
$currentDate = date('d.m.Y');
if(empty($bdsetUpcoming)){
  $msg = "Keine Verbindung zur Datenbank möglich.";
}

//Nachrichten
$feed = $configs['FEED'];
$NUMITEMS = 3;

//Read each feed's items
$entries = array();
$xml = simplexml_load_file($feed);
$entries = array_merge($entries, $xml->xpath("//item"));

//Sort feed entries by pubDate
usort($entries, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});
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
  
  <!-- Javascript -->
  <meta http-equiv="refresh" content="3600" />
  <script src="js/clock.js"></script> 

</head>
<body onload="startTime()">
  <div class="row">

    <div class="twelve columns" id="header">
      <img src="images/trauco.png">
      <h4 id="clock"></h4><br>
      <h4 style="margin-top: 10px"><?php echo "$currentDay, $currentDate"?></h4>

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
        <?php 
        //Past Birthdays
        $count = 1;
        foreach ($bdsetPast as $row){
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
            <tr <?php if($count >= 3) echo "style=\"border-bottom: 5px solid black;\""?>>
             	<td><?php echo $doubleDate == TRUE ? "" : $date; ?></td>
            	<td><?php echo $doubleDate == TRUE ? "" : $weekday; ?></td>
            	<td><?php echo "{$row['Firstname']} {$row['Lastname']}";?></td>
            	<td><?php echo $age; ?></td>
          	</tr>
 			<?php 
 			$count++;
            } //END IF
   
        //Current and Upcoming Birthdays
        foreach ($bdsetUpcoming as $row){
            if(date('m-d') == substr($row['Birthday'],5,5)){
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
		<tr class="current"> 
            <td><?php echo $doubleDate == TRUE ? "" : $date; ?></td>
            <td><?php echo $doubleDate == TRUE ? "" : $weekday; ?></td>
            <td><?php echo "{$row['Firstname']} {$row['Lastname']}";?></td>
            <td><?php echo $age; ?></td>
		</tr> 
        <?php } //ENDIF

        // Other days
          //if birthday is not today
          else {

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
        ?>

        </tbody>
      </table>
    </div>

    <div class="six columns" id="right">
     <?php $count = 0;
     foreach($entries as $entry){ ?>
      <article>
        <h2><?php echo $entry->title ?></h2>
        <p><?php echo $entry->description ?></p>
        <p class="createdDate"> <?php echo strftime('%d.%m.%Y %H:%M', strtotime($entry->pubDate)) ?> </p>
        <p class="link"><a href="<?php echo $entry->link ?>">Link</a> (<?php echo parse_url($entry->link)['host'] ?>)</p>
      </article>
      <?php if(++$count >= $NUMITEMS) break;    
     }?>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
