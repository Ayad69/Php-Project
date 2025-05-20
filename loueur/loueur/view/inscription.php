<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header id="head">
    <h2 class="alert alert-warning">Inscription</h2>
</header>
<br>
<?php if(isset($message_erreur) && $message_erreur != ''): ?>
    <div class="alert alert-danger errorMessage"><?= $message_erreur ?></div>
<?php endif; ?>

<form method="post" action="index.php">
    <table id="inscriptionTable">
        <tr>
            <td colspan="2"><input type="text" name="nom" placeholder="Identifiant" /></td>
        </tr>

        <tr>
            <td colspan="2"><input type="password" name="mot_de_passe" placeholder="Mot de passe" /></td>
        </tr>
            
         <tr>
            <td colspan="2">
                <input type="radio" id="loueur" name="role" value="loueur" />
                <label for="loueur">Rôle loueur</label>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <input type="radio" id="admin" name="role" value="admin" />
                <label for="admin">Rôle admin</label>
            </td>
        </tr>
        
            <td><br><a href="../../../index.php"><div class="btn btn-info">Retour à la connexion</div></a></td>
            <td><br><input class="btn btn-primary" name="btnSignup" type="submit" value="S'inscrire" /></td>
        </tr> 
    </table>
</form>

</body>

<footer class="footer bg-dark text-white text-center py-3">
    Équipe 4
</footer>

</html>
