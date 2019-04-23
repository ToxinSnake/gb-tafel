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
  <link rel="stylesheet" href="css/gbstyle.css">

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
      <table class="u-full-width current">
        <thead class="current">
          <th style="text-align: left; padding-left: 7%;">Heute</th>
          <th></th>
          <th></th>
        </thead>
        <tbody>
          <tr>
            <td style="text-align: left; padding-left: 7%;">Bernd Holz</td>
            <td>Trauco</td>
            <td>Fibu</td>
          </tr>
          <tr>
            <td style="text-align: left; padding-left: 7%;">Heinrich Gerhard</td>
            <td>Nowebau</td>
            <td>Tiefbau</td>
          </tr>
        </tbody>
      </table>
    
      <table class="u-full-width past">
        <thead class="past">
          <th style="text-align: left; padding-left: 7%;">22. April</th>
          <th style="text-align: left;">Montag</th>
          <th></th>
        </thead>
        <tbody>
          <tr>
            <td style="text-align: left; padding-left: 7%;">Malte Lindemuth</td>
            <td>Trauco</td>
            <td>EDV</td>
          </tr>
          <tr>
            <td style="text-align: left; padding-left: 7%;">Peter Heinz</td>
            <td>Nowebau</td>
            <td>Rohbau</td>
          </tr>
        </tbody>
      </table>

      <table class="u-full-width past">
        <thead class="past">
          <th style="text-align: left; padding-left: 7%;">21. April</th>
          <th style="text-align: left;">Sonntag</th>
          <th></th>
        </thead>
        <tbody>
          <tr>
            <td style="text-align: left; padding-left: 7%;">Justus Greiber</td>
            <td>Trauco</td>
            <td>EDV</td>
          </tr>
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
