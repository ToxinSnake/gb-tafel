<?php
include "./app/board_methods.php";
$configs = include ('./app/config.php');

setlocale (LC_ALL, 'de_DE');

//Tag und Zeit für Kopf
$currentDay = strtr(date('l'), $trans);
$currentDate = date('d.m.Y');

//Geburtstage
$noEntry = true;
$countToday = count(getTodayBirthdays()->fetchAll());
if($countToday > 0) {
  $bdsetToday = getTodayBirthdays();
}
//Vergangene Geburtstage
$bdsetsPast = array_fill(0, $configs['PAST_BIRTHDAYS']-1, NULL);
for($i = 1; $i <= $configs['PAST_BIRTHDAYS']; $i++){
  $bdsetsPast[$i-1] = getPastBirthdays($i);
}

//Interne News holen
$internalNews = getNews();

//Nachrichten
$feed = $configs['FEED'];
$NUMITEMS = 2;

//Read each feed's items
$entries = array();
$xml = simplexml_load_file($feed);
$entries = array_merge($entries, $xml->xpath("//item"));

//Sort feed entries by pubDate
usort($entries, function ($feed1, $feed2) {
    return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
});
?>
<!DOCTYPE html>
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

  <!-- Logo, Datum Uhrzeit -->
    <div class="twelve columns" id="header">
      <img src="images/trauco.png">
      <h4 id="clock"></h4><br>
      <h4 style="margin-top: 10px"><?php echo "$currentDay, $currentDate"?></h4>
    </div>

    <div class="six columns" id="left">    
      <!-- Heutige Geburtstage -->
      <?php 
      if($countToday > 0){
        $noEntry = false;
      ?> 
      <table class="u-full-width current">
        <thead class="current">
          <th class="leftpad">Heute</th>
          <th></th>
          <th></th>
        </thead>
        <tbody>
        <?php 
        foreach($bdsetToday as $row) { 
        ?>
          <tr>
            <td class="leftpad"><?php echo "{$row['Firstname']} {$row['Lastname']}" ?></td>
            <td><?php echo "{$row['CName']}" ?></td>
            <td><?php echo "{$row['DName']}" ?></td>
          </tr>
      <?php 
        } ?> 
        </tbody>
      </table>
      <?php 
      } ?>

         
      <!-- Vergangene Geburtstage -->
      <?php
      $dayCount = 1;
      foreach($bdsetsPast as $entry) { 
        if(getRowCount($entry->queryString) > 0){
          $noEntry = false; ?>
      <table class="u-full-width past">
        <thead class="past">
          <th class="leftpad"><?php echo strtr(date("d. F", time() + (-$dayCount * 24 * 60 * 60)), $trans); ?></th>
          <th style="text-align: left;"><?php echo strtr(date("l", time() + (-$dayCount * 24 * 60 * 60)), $trans); ?></th>
          <th></th>
        </thead>
        <tbody>
          <?php foreach($entry as $row) { ?>
          <tr>
            <td class="leftpad"><?php echo "{$row['Firstname']} {$row['Lastname']}" ?></td>
            <td><?php echo "{$row['CName']}" ?></td>
            <td><?php echo "{$row['DName']}" ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>          
      <?php 
        }
        $dayCount++; 
      } if($noEntry){ ?>
      <p class="nothing">¯\_(ツ)_/¯<br>Keine Geburtstage in nächster Zeit</p>
      <?php
      }
      ?>
    </div>

    <div class="six columns" id="right">
     
    <!-- Interne News -->
    <?php if($internalNews["Publish"]) { ?>
      <article class="internal">
        <h2><?php echo $internalNews["Headline"]; ?></h2>
        <p><?php echo $internalNews["Content"] ?></p>
        <p class="createdDate"> <?php echo strtr(strftime('%A, %d.%m.%Y %H:%M', $internalNews["Date"]), $trans) ?> </p>
        <p class="link">Verfasser: <?php echo $internalNews["Author"] ?></p>
      </article>
      <?php } ?>

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