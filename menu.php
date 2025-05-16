<?php

require_once('BDD_Manager.php');

$message_erreur = '';

/*
if(isset($_GET['btnConnect'])) {
    if(isset($_GET['email']) && $_GET['email'] != '' &&
        isset($_GET['motdepasse']) && $_GET['motdepasse'] != '') {
        $message_erreur = connecteUtilisateur($_GET['email'], $_GET['motdepasse']);
        if($message_erreur == '') {
            header('Location: index.php');
        }
    }
}
*/
?>

<html>
<head>
<meta charset="UTF-8">
<title>  </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/andy-pro" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="../images/icon.ico">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div id="barre">Connexion </div>

<header id="head">
    <br>
        <br>
            <br>
                <br>
                    <br>
                        <br>
                        
    <h2 class="alert alert-warning">Menu</h2>
</header>
<br>
<?php if($message_erreur != '')
    echo "<div class=\"alert alert-danger errorMessage\">$message_erreur</div>";
?>

<hr class="separator">
<a href="infos/infos.php" class="buttoninfos">Mes informations</a>

</body>
</html>