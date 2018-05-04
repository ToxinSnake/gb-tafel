<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Tafel</title>
  <meta name="description" content="">
  <meta name="author" content="">

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

</head>
<body>


<?php
  /*
  $currentDate = date_create(null);
  echo date_format($currentDate,"d.m");
  date_add($currentDate, date_interval_create_from_date_string("1 days"));
  echo date_format($currentDate,"d.m");
  */
 ?>

<div class="row">
  <div class="five columns" id="main-left">
    <table class="u-full-width">
      <tr> <!-- Day -2 -->
        <td class="date">02.05</td>
        <td>Mittwoch</td>
        <td>Arne Otten (24)</td>
      </tr> <!-- End of Day -2 -->

      <tr> <!-- Day -1 -->
        <td class="date">03.05</td>
        <td>Donnerstag</td>
        <td>Lars Meyerhoff (41)</td>
      </tr> <!-- End of Day -1 -->

      <tr id="currentDay"> <!-- Current Day -->
        <td class="date">04.05</td>
        <td>Freitag</td>
        <td>Malte Lindemuth (39)</td>
      </tr> <!-- End of Current Day -->

      <tr> <!-- Day 1 -->
        <td class="date">05.05</td>
        <td>Samstag</td>
        <td>Manuel Mehl (35)</td>
      </tr> <!-- End of Day 1 -->

      <tr> <!-- Day 2 -->
        <td class="date">06.05</td>
        <td>Sonntag</td>
        <td>Gerda Müllerhausen Gedenk (49),<br> Hans Müller (23)</td>
      </tr> <!-- End of Day 2 -->

      <tr> <!-- Day 3 -->
        <td class="date">07.05</td>
        <td>Sonntag</td>
        <td></td>
      </tr> <!-- End of Day 3 -->

      <tr> <!-- Day 4 -->
        <td class="date">08.05</td>
        <td>Montag</td>
        <td></td>
      </tr> <!-- End of Day 4 -->
    </table>

  </div>

  <div class="seven columns" id="main-right">
    <article>
      <h2>Nachricht des Tages</h2>
      <p>Hackerman immernoch unentdeckt.</p>
      <p class="createdDate">04.05.2018</p>
    </article>

    <article>
      <h2>Mitarbeiterfest</h2>
      <p>Jetzt sofort anmelden!</p>
      <p class="createdDate">04.05.2018</p>
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
          <p class="createdDate">04.05.2018</p>
    </article>
  </div>

</div>

</body>
</html>
