<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header id="head">
    <h2 class="alert alert-warning">Connexion Admin</h2>
</header>
<br>

<?php if(isset($message_erreur) && $message_erreur != ''): ?>
    <div class="alert alert-danger errorMessage"><?= $message_erreur ?></div>
<?php endif; ?>

<form method="post" action="index.php">
    <table id="connexion">
        <tr>
            <td colspan="3"><input type="text" name="nom" placeholder="Identifiant" /></td>
        </tr>

        <tr>
            <td colspan="3"><input type="password" name="mot_de_passe" placeholder="Mot de passe" /></td>
        </tr>

        <tr>
            <td><br><a href="#"><input class="btn btn-warning" name="btnErase" type="reset" value="Effacer" /></a></td>
            <td><br><a href="index.php?inscription"><div class="btn btn-info">S'inscrire</div></a></td>
            <td><br><input class="btn btn-primary" name="btnConnect" type="submit" value="Connexion" /></td>
            <div class="mt-4">
    <a href="loueur/index2.php" class="btn btn-success">Espace Utilisateur</a>
</div>
        </tr> 
    </table>
</form>
<br><br>

</body>
<footer class="footer bg-dark text-white text-center py-3">
    Équipe 4
</footer>

</html>