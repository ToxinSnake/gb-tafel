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
  <title>Benutzer verwalten</title>
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

  <!-- JS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script type="text/javascript" src="../js/jquery-3.3.1.js"></script>

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="../images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve columns" id="menu">
        <h3>Benutzer verwalten</h3>

        <!-- Neuen Benutzer anlegen -->
        <form action="" method="post">
          <input type="text" name="username" value="" placeholder="Benutzername"  maxlength="40" autofocus required>
          <input type="text" name="password" value="" placeholder="Passwort"  maxlength="60" required>
          <select name="privilege" required>
            <option value="">Privilegien wählen...</option>  
            <option value="admin">admin</option>
            <option value="user">user</option>
          </select>
          <input class="button-primary" value="Benutzer hinzufügen" type="submit">
        </form>
        <br>
        
        <!-- Benutzer löschen -->
        <form action="" method="post">
          <select name="deleteUser" required>
            <option value="">Benutzer löschen...</option>
          </select>
          <input class="button-primary delete" value="Benutzer löschen" type="submit">
        </form>
        <a class="button button" href="index.php">Zurück</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
