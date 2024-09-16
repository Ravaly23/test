<?php
// Connexion à la base de données
$conn = mysqli_connect('localhost', 'Admin', 'MIA_L3_GF24', 'gf');

// Vérifiez la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Traitement des actions GET pour validation ou rejet
$action = isset($_GET['action']) ? $_GET['action'] : '';
$idInscri = isset($_GET['id']) ? intval($_GET['id']) : 0;
$actionEffaceer = isset($_GET['remove']) ? $_GET['remove'] :'';
$idUtilisateur  = isset($_GET['idIns'])  ? $_GET['idIns'] : 0;

if ($action == 'valider' && $idInscri > 0) {
    // Validation de l'inscription
    $validation = "INSERT INTO utilisateur (IDINSCRIPTION, NOM, MOTDEPASSE)
                   SELECT IDINSCRIPTION, NOM, MOTDEPASSE FROM inscription WHERE IDINSCRIPTION = ?";
    $suprression = "DELETE FROM inscription WHERE IDINSCRIPTION = ?";

    $stmt = $conn->prepare($validation);
    $stmt->bind_param("i", $idInscri);
    $stmt->execute();

    $stmt = $conn->prepare($suprression);
    $stmt->bind_param("i", $idInscri);
    $stmt->execute();

    // echo "Inscription validée avec succès.";

    $stmt->close();
} elseif ($action == 'refuser' && $idInscri > 0) {
    // Rejet de l'inscription
    $suprression = "DELETE FROM inscription WHERE IDINSCRIPTION = ?";
    $stmt = $conn->prepare($suprression);
    $stmt->bind_param("i", $idInscri);
    $stmt->execute();

    // echo "Inscription rejetée avec succès.";

    $stmt->close();
}

elseif ($actionEffaceer == 'effacer') {
    // Rejet de l'inscription
    $suprression = "DELETE FROM utilisateur WHERE IDUTILISATEUR = ?";
    $stmt = $conn->prepare($suprression);
    $stmt->bind_param("i", $idUtilisateur);
    $stmt->execute();

    $stmt->close();
}

// Requête pour les inscriptions en attente
$query = "SELECT * FROM inscription";
$res = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="interfaceAdmin.css">
    <title>ADMINISTRATEUR</title>
</head>
<body>
<nav>
    <ul>
        <li><input type="submit" value="Gestion utilisateur" name="" id="GestionUtilisateur"></li>
        <li><input type="submit" value="Gestion Formule" name="" id="GestionFormule"></li>
        <li><input type="submit" value="Retour vers l'accueil" name="" id="Acceuille"></li>
        <li><input type="submit" value="Déconnexion" name="" id="Deconnexion"></li>
    </ul>
</nav>

      <div id="GUtilisateur">
        <article>
         <h3>UTILISATEUR EN ATTENTE DE VALIDATION</h3>
         <table border>
             <thead>
                 <tr>
                     <th>NUMÉRO DE L'INSCRIPTION</th>
                     <th>NOM DE L'UTILISATEUR</th>
                     <th>MOT DE PASSE</th>
                     <th>VALIDATION</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                 if ($res) {
                     while ($donne = mysqli_fetch_array($res)) {
                         echo '<tr>
                                 <td>' . htmlspecialchars($donne['IDINSCRIPTION']) . '</td>
                                 <td>' . htmlspecialchars($donne['NOM']) . '</td>
                                 <td>' . htmlspecialchars($donne['MOTDEPASSE']) . '</td>
                                 <td><a href="?action=valider&id=' . $donne['IDINSCRIPTION'] . '">Valider</a>
                                    <a href="?action=refuser&id=' . $donne['IDINSCRIPTION'] . '">Refuser</a></td>
                             </tr>';
                     }
                 } else {
                     echo "Erreur : " . mysqli_error($conn);
                 }
                 ?>
             </tbody>
         </table>
        </article>
    
            <aside>
             <h3>LISTE DES UTILISATEURS DANS LA BASE</h3>
             <table border id="tableau">
                 <thead>
                     <tr>
                     <th>NOM DE L'UTILISATEUR</th>
                     <th>MOT DE PASSE</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                     $query = "SELECT * FROM utilisateur LIMIT 0, 20";
                     $res = mysqli_query($conn, $query);

                     if ($res) {
                         while ($donne = mysqli_fetch_array($res)) {
                             echo '<tr>
                                     <td>' . htmlspecialchars($donne['NOM']) . '</td>
                                     <td>' . htmlspecialchars($donne['MOTDEPASSE']) . '</td>
                                     <td> <a href="?remove=effacer&idIns=' . $donne['IDUTILISATEUR'] . '">Effacer</a></td>
                                 </tr>';
                         }
                     } else {
                         echo "Erreur : " . mysqli_error($conn);
                     }
                     ?>
                 </tbody>
             </table>
            </aside>
        </div>


      <section class="gestionF">
              <div id="gestionFormule">
                  <table border="">
                      <thead>
                          <tr>
                              <th>Nom du formule</th>
                              <th>Expression de la formule </th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 

                          // Connexion à la base de données
                          $conn = mysqli_connect('localhost', 'Admin', 'MIA_L3_GF24', 'gf');

                          // Vérifiez la connexion
                          if (!$conn) {
                          die("Échec de la connexion : " . mysqli_connect_error());
                          }

                          $requete = "SELECT *FROM formule WHERE IDFORMULE ";
                          $res = mysqli_query($conn,$requete); 

                          if ($res) {
                              while ($donne = mysqli_fetch_array($res)) {
                                  echo '<tr>
                                          <td>' . htmlspecialchars($donne['NOMFORMULE']) . '</td>
                                          <td>' . htmlspecialchars($donne['EXPRESSIONFORMULE']) . '</td>
                                      </tr>';
                              }
                          } else {
                              echo "Erreur : " . mysqli_error($conn);
                          }
                          ?>
                      </tbody>
                  </table>
              </div>
      </section>

    <?php mysqli_close($conn); ?>
    <script src="interfaceAdmin.js"> </script>
</body>
</html>