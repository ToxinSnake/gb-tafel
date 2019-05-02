<?php
session_start();
if(!isset($_SESSION["username"])){
  $_SESSION["referer"] = $_SERVER["PHP_SELF"];
  header("Location: login.php"); 
  exit;
}

require_once "../app/edit_methods.php";

//News updaten
if(isset($_POST["headline"])) {
  $headline = $_POST["headline"];
  $content = "";
  $publish;

  if(isset($_POST["content"])){
    $content = $_POST["content"];
  }
  if(isset($_POST["publish"])){
    $publish = 1;
  } else {
    $publish = 0;
  }

  updateNews($headline, $content, $publish, $_SESSION["username"]);
}

$currentNews = getNews();

 ?>
<!DOCTYPE html>
<!--
* Made by Arne Otten
* www.mj-12.net
* 08/07/2018
-->
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Tafel bearbeiten</title>
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
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/skeleton.css">
  <link rel="stylesheet" href="../css/menustyle.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="../images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve columns" id="editor">
        <h3>Tafel bearbeiten</h3>
      <?php if(!empty($msg)){ ?> <p> <?php echo $msg; ?> </p> <?php } ?>
        <form action="" method="post">
          <input type="text" name="headline" value="<?php echo $currentNews["Headline"]; ?>" placeholder="Überschrift"  maxlength="70" autofocus required>
          <textarea name="content"><?php echo $currentNews["Content"]; ?></textarea>
          <input type="checkbox" name="publish" id="publish" value="1" <?php if($currentNews["Publish"]) echo "checked"; ?>><label style="display: inline;" for="publish">Veröffentlichen</label><br>
          <input class="button-primary" value="Absenden" type="submit">
        </form>
        <a class="button button" href="index.php">Zurück</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
