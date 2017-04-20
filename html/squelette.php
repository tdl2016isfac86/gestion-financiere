<?php
if (strstr($_SERVER['PHP_SELF'],'squelette.php') != FALSE) {
    exit('Nous ne permettons pas d\'appeler  directement ce fichier ! Dégage !');
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="utf8">
        <title><?= $_Head_TITRE_PAGE ?></title>
        <link rel="stylesheet" href="html/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="html/css/jquery-ui.min.css" type="text/css" />
        <link rel="stylesheet" href="html/css/jquery-ui.structure.min.css" type="text/css" />
        <link rel="stylesheet" href="html/css/jquery-ui.theme.min.css" type="text/css" />
        <link rel="stylesheet" href="html/css/jquery-ui-timepicker-addon.css" type="text/css" />
        <link rel="stylesheet" href="html/css/style.css" type="text/css" />
    </head>
    <body class="container-fluid">
<header class="container">
    <div class="row">
        <img src="html/img/logo.png">
    </div>
    <nav class="row">
        <ul>
            <li>Accueil</li>
            <li>Bilans</li>
            <li>Stats</li>
        </ul>
    </nav>
</header>
<section class="container">
    <?= $_Body ?>
</section>
<footer class="container">
    
</footer>
    <script type="text/javascript" src="html/js/jquery-3.1.1.js"></script>
    <script type="text/javascript" src="html/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="html/js/jquery-ui-addon-timepicker.js"></script>
    <script type="text/javascript" src="html/js/bootstrap.min.js"></script>        
    <script type="text/javascript" src="html/js/script.js"></script>
    </body>
</html>