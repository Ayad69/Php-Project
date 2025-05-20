<?php
session_start();
require_once '../../model/Loueur.php';
require_once '../../model/LoueurDAO.php';
require_once '../../model/Utilisateur.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=php;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}


$loueurDAO = new LoueurDAO($pdo);


$message_erreur = '';
$message_succes = '';


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
    
   
    header('Location: ../../../index.php');
    exit();
}


if (isset($_POST['action'])) {
    $action = $_POST['action'];
    

    if ($action === 'ajouter') {
        if (isset($_POST['nom']) && !empty($_POST['nom'])) {
            $nom = trim($_POST['nom']);
            
         
            $nouveauLoueur = new Loueur();
            $nouveauLoueur->setNom($nom);
            $nouveauLoueur->setAppelsKo(0);
            $nouveauLoueur->setTimeouts(0);
            $nouveauLoueur->setDateAnalyse(date('Y-m-d H:i:s'));
            
    
            if ($loueurDAO->add($nouveauLoueur)) {
                $message_succes = "Loueur ajouté avec succès.";
            } else {
                $message_erreur = "Erreur lors de l'ajout du loueur.";
            }
        } else {
            $message_erreur = "Veuillez remplir tous les champs.";
        }
    } 
  
    elseif ($action === 'supprimer') {
        if (isset($_POST['id_suppression']) && !empty($_POST['id_suppression'])) {
            $id = $_POST['id_suppression'];
            
            
            $loueur = $loueurDAO->getById($id);
            if ($loueur) {
                if ($loueurDAO->delete($id)) {
                    $message_succes = "Loueur supprimé avec succès.";
                } else {
                    $message_erreur = "Erreur lors de la suppression du loueur.";
                }
            } else {
                $message_erreur = "Loueur introuvable.";
            }
        } else {
            $message_erreur = "ID non spécifié pour la suppression.";
        }
    } 
  
    elseif ($action === 'modifier') {
        if (isset($_POST['id_modification']) && !empty($_POST['id_modification']) && 
            isset($_POST['nom_modification']) && !empty($_POST['nom_modification'])) {
            
            $id = $_POST['id_modification'];
            $nom = trim($_POST['nom_modification']);
            $appelsKo = isset($_POST['appels_ko']) ? intval($_POST['appels_ko']) : 0;
            $timeouts = isset($_POST['timeouts']) ? intval($_POST['timeouts']) : 0;
            
           
            $loueur = $loueurDAO->getById($id);
            if ($loueur) {
                $loueur->setNom($nom);
                $loueur->setAppelsKo($appelsKo);
                $loueur->setTimeouts($timeouts);
                $loueur->setDateAnalyse(date('Y-m-d H:i:s'));
                
                if ($loueurDAO->update($loueur)) {
                    $message_succes = "Loueur modifié avec succès.";
                } else {
                    $message_erreur = "Erreur lors de la modification du loueur.";
                }
            } else {
                $message_erreur = "Loueur introuvable.";
            }
        } else {
            $message_erreur = "Veuillez remplir tous les champs pour la modification.";
        }
    }
}


$loueurInfo = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero']) && !isset($_POST['action'])) {
    $id = trim($_POST['numero']);
    $loueurInfo = $loueurDAO->getById($id);
    
    if (!$loueurInfo) {
        $message_erreur = "ID utilisateur introuvable.";
    }
}

$tousLesLoueurs = $loueurDAO->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistique</title>
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
        #formJeu {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        .blockJeu {
            text-align: center;
            padding: 15px;
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
        .admin-section {
            margin-top: 40px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
        .admin-form {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .tab-content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <header id="head">
        <h2 class="alert alert-warning text-center">Statistique</h2>
    </header>
    <br>
    
    <?php if(isset($message_erreur) && $message_erreur != ''): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message_erreur) ?></div>
    <?php endif; ?>

    <?php if(isset($message_succes) && $message_succes != ''): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message_succes) ?></div>
    <?php endif; ?>

    <!-- Affichage de l'utilisateur -->
        <?php
            $utilisateur = new Utilisateur($_SESSION['id_utilisateur'],$_SESSION['nom'],"mdp", "Administrateur");
      ?>
        <center><h3><?= htmlspecialchars($utilisateur->getNom()) ?></h3></center>


    
    <form method="post" action="stat.php" id="formJeu" class="text-center">
        <div class="divider"></div>
        
        <div class="blockJeu">
            <label for="numero">Entrez un ID</label><br><br>
            <input type="text" name="numero" id="numero" class="form-control" required>
        </div>
        
        <div class="divider"></div>
        
        <div class="form-group">
            <input type="submit" name="btnJouer" class="btn btn-success" value="Rechercher" />
        </div>
    </form>
    
    <div class="form-group text-center mt-3">
        <a href="stat.php?deco" id="quitButton" class="btn btn-danger">Déconnecter</a>
    </div>
    
    <?php if ($loueurInfo): ?>
        
        <div class="user-info">
            <h4 class="text-center mb-3">Informations du loueur</h4>
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
    <?php endif; ?>
    
   
    <div class="admin-section">
        <h3 class="text-center mb-4">Administration des loueurs</h3>
        
        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="ajouter-tab" data-toggle="tab" href="#ajouter" role="tab">Ajouter</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="modifier-tab" data-toggle="tab" href="#modifier" role="tab">Modifier</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="supprimer-tab" data-toggle="tab" href="#supprimer" role="tab">Supprimer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="liste-tab" data-toggle="tab" href="#liste" role="tab">Liste</a>
            </li>
        </ul>
        
        <div class="tab-content" id="adminTabsContent">
          
            <div class="tab-pane fade show active" id="ajouter" role="tabpanel">
                <h5>Ajouter un loueur</h5>
                <form method="post" action="">
                    <input type="hidden" name="action" value="ajouter">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
            
      
            <div class="tab-pane fade" id="modifier" role="tabpanel">
                <h5>Modifier un loueur</h5>
                <form method="post" action="">
                    <input type="hidden" name="action" value="modifier">
                    <div class="form-group">
                        <label for="id_modification">ID:</label>
                        <input type="number" class="form-control" id="id_modification" name="id_modification" required>
                    </div>
                    <div class="form-group">
                        <label for="nom_modification">Nom:</label>
                        <input type="text" class="form-control" id="nom_modification" name="nom_modification" required>
                    </div>
                    <div class="form-group">
                        <label for="appels_ko">Appels KO:</label>
                        <input type="number" class="form-control" id="appels_ko" name="appels_ko" value="0">
                    </div>
                    <div class="form-group">
                        <label for="timeouts">Timeouts:</label>
                        <input type="number" class="form-control" id="timeouts" name="timeouts" value="0">
                    </div>
                    <button type="submit" class="btn btn-warning">Modifier</button>
                </form>
            </div>
            

            <div class="tab-pane fade" id="supprimer" role="tabpanel">
                <h5>Supprimer un loueur</h5>
                <form method="post" action="">
                    <input type="hidden" name="action" value="supprimer">
                    <div class="form-group">
                        <label for="id_suppression">ID:</label>
                        <input type="number" class="form-control" id="id_suppression" name="id_suppression" required>
                    </div>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce loueur?');">Supprimer</button>
                </form>
            </div>
            
         
            <div class="tab-pane fade" id="liste" role="tabpanel">
                <h5>Liste des loueurs</h5>
                <?php if ($tousLesLoueurs && count($tousLesLoueurs) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Appels KO</th>
                                <th>Timeouts</th>
                                <th>Date d'analyse</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tousLesLoueurs as $loueur): ?>
                                <tr>
                                    <td><?= htmlspecialchars($loueur->getId()) ?></td>
                                    <td><?= htmlspecialchars($loueur->getNom()) ?></td>
                                    <td><?= htmlspecialchars($loueur->getAppelsKo() ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($loueur->getTimeouts() ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($loueur->getDateAnalyse() ?? 'N/A') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucun loueur enregistré.</p>
                <?php endif; ?>
            </div>
        </div>
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