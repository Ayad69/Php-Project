<?php


require_once('BDD_Manager.php');

$message_erreur = '';

// Vérifie que le bouton du formulaire a été cliqué
if(isset($_GET['btnConnect'])) {
    // Vérifie que les champs existent et ne sont pas vides
    if(isset($_GET['nom']) && $_GET['nom'] != '' &&
        isset($_GET['motdepasse']) && $_GET['motdepasse'] != '') {
        $message_erreur = connecteUtilisateur($_GET['nom'], $_GET['motdepasse']);
        if($message_erreur == '') {
            // Si pas d'erreur, renvoie l'utilisateur vers le jeu de la roulette
            header('Location: roulette.php');
        }
    }
}
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

<header id="head">
    <br>
        <br>
            <br>
                <br>
                    <br>
                        <br>
                        
    <h2 class="alert alert-warning">Connexion</h2>
</header>
<br>
<?php if($message_erreur != '')
    echo "<div class=\"alert alert-danger errorMessage\">$message_erreur</div>";
?>

<form method="get" action="connexion.php">
    <table id="connexionTable">
        <tr>
            <td colspan="3"><input type="text" name="nom" placeholder="Identifiant" /></td>
        </tr>

        <tr>
            <td colspan="3"><input type="text" name="motdepasse" placeholder="Mot de passe" /></td>
        </tr>

        <tr>
            <td><br><a href="#"><input class="btn btn-warning" name="btnErase" type="reset" value="Effacer" /></a></td>
            <td><br><a href="inscription.php"><div class="btn btn-info">S'inscrire</div></a></td>
            <td><br><input class="btn btn-primary" name="btnConnect" type="submit" value="Jouer" /></td>
        </tr> 
    </table>
</form>











<div id="barre">Connexion </div>


<div id="main">Connexion</div> 



<hr class="separator">


</body>
</html>