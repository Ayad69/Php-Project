<?php
session_start();
require_once '../../model/Loueur.php';
require_once '../../model/LoueurDAO.php';


if (!isset($_SESSION['id']) || !isset($_SESSION['nom'])) {
    
    header('Location: ../../../../index.php');
    exit();
}


try {
    $pdo = new PDO('mysql:host=localhost;dbname=php;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}


$loueurDAO = new LoueurDAO($pdo);


$loueurInfo = $loueurDAO->getById($_SESSION['id']);


if (isset($_GET['deco'])) {
   
    $_SESSION = array();
    
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
 
    session_destroy();
    
  
    header('Location: ../../../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistique du loueur</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            padding: 20px;
        }
        #intro {
            text-align: center;
        }
        .divider {
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .user-info {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .user-info table {
            width: 100%;
        }
        .user-info th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
        }
        .user-info td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
<div class="container">
    <header id="head">
        <h2 class="alert alert-warning text-center">Statistique du loueur</h2>
    </header>
    <br>
    
    <div id="intro">
        <h3>Bienvenue <?= htmlspecialchars($_SESSION['nom']) ?></h3>
    </div>
    <br>
    
 
    <?php if ($loueurInfo): ?>
        <div class="user-info">
            <h4 class="text-center mb-3">Vos informations</h4>
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <td><?= htmlspecialchars($loueurInfo->getId()) ?></td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td><?= htmlspecialchars($loueurInfo->getNom()) ?></td>
                </tr>
                <tr>
                    <th>Appels KO</th>
                    <td><?= htmlspecialchars($loueurInfo->getAppelsKo() ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Timeouts</th>
                    <td><?= htmlspecialchars($loueurInfo->getTimeouts() ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Date d'analyse</th>
                    <td><?= htmlspecialchars($loueurInfo->getDateAnalyse() ?? 'N/A') ?></td>
                </tr>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Impossible de récupérer vos informations. Veuillez contacter l'administrateur.</div>
    <?php endif; ?>
    
    <div class="form-group text-center mt-3">
        <a href="stat.php?deco" id="quitButton" class="btn btn-danger">Déconnecter</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>

<footer class="footer bg-dark text-white text-center py-3">
    Équipe 4
</footer>
</html>