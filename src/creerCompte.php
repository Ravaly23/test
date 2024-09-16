<!-- creation d'un compte -->

<?php 
if(isset($_POST['create'])){
    $nomUser = $_POST['USERNAME']; // on recupère le nom d'utilisateur
    $mdpUser = $_POST['mdp'];  // on recupère le mot de passe
    $confMdp = $_POST['mdp2']; // on recupère la confirmation de mot de passe
    $succes ="";
    $echec ="";
    $informationManquante = "";

    $conn = mysqli_connect('localhost','Admin','MIA_L3_GF24','gf');

    //vérifie la connexion

    if(!$conn){
        die("Echec de la connexion :".mysqli_connect_error());
    }

    if(empty($_POST['USERNAME']) || empty($_POST['mdp']) || empty($_POST['mdp2'])){
      $informationManquante =" veuillez remplir les informations pour valider votre inscription ";
    }elseif(isset($_POST['USERNAME']) && isset($_POST['mdp']) && isset($_POST['mdp2'])){
      if($mdpUser == $confMdp){
        $insertion = " INSERT into inscription (NOM,MOTDEPASSE,CONFIRMATIONMOTDEPASSE) values ('$nomUser' ,'$mdpUser','$confMdp ')";
        mysqli_query($conn,$insertion);
        $succes = "Compte creer avec succes ";
      }elseif($mdpUser != $confMdp ){
        $echec = " Ces mots de passe ne correspond pas";
    }
  }
}

?>

     <!DOCTYPE html>
     <html lang="en">
     <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="compte.css">
        <title>CREATION D'UN COMPTE</title>
     </head>
     <body>
           <!-- pour creer un utilisateur -->
      <div id="compte">
      <?php 
         if(!empty($succes)){
          echo "<p class ='succes'>".$succes."</p>";
         }elseif(!empty($echec)){
          echo "<p class ='erreur'>".$echec."</p>";
         }elseif(!empty($informationManquante)){
          echo "<p class ='erreur'>".$informationManquante."</p>";
         }
         ?>
          <fieldset id="createU">
             <img src="fond/lock.png" width="130px" height="130px" id="sary" >

              <form method="post" action="" >
                <p ><label for="USERNAME"></label><input name="USERNAME" type="text" placeholder="    Enter your username" id="creation"></p><br>
                <p ><label for="mdp"></label><input name="mdp" type="password" placeholder="    Enter your password" id="creation"></p><br>
                <p ><label for="mdp2"></label><input name="mdp2" type="password" placeholder="    Re-enter your password" id="creation"></p><br>
                <p><input name="create" type="submit" value="Create your Account" id="CreUserA"></p><br>
              </form>
         </fieldset>
      </div>
        
     </body>
     </html>