<!-- connection en tantque gestionnaire -->
<?php
// on demmare une session 
session_start();
if(isset($_POST['bouton2'])){
  if(isset($_POST['USERNAME']) && isset($_POST['mdpU'])) // verifie si le formulaire a été soumis 
  {      //Récuperer les données POST
         $id = $_POST['USERNAME'];
         $motDepass = $_POST['mdpU'];
         $erreur ="";
 
         //connexion à la base 
         $conn = mysqli_connect('localhost','Admin','MIA_L3_GF24','gf');
 
         //vérifie la connexion 
 
         if(!$conn){
             die("Echec de la connexion :".mysqli_connect_error());
         }
 
        
         
         $res = mysqli_query($conn," SELECT  * FROM utilisateur WHERE NOM='$id' AND MOTDEPASSE='$motDepass' ") ;
         
         $row_cnt = mysqli_num_rows($res); //compte le nombre de resultat obtenue 
         //$donne = mysqli_affected_rows($conn);
         if($row_cnt !=0 ){
          header("Location:interfaceUtilisateur.php");

          $_SESSION['USERNAME'] = $id;
         }else{
          $erreur =" nom ou mot de passe incorrect ";
         }

         if(isset($_POST['USERNAME']) =="Admin"&& isset($_POST['mdpU']) == "MIA_L3_GF24")
         {
          header("Location:interfaceUtilisateur.php");  

          $_SESSION['USERNAME'] = "ADMIN ";
         }
  } 
}

?>
<!-- connection en tant que admin -->
<?php
if(isset($_POST['bouton'])){
  if(isset($_POST['USERNAME']) && isset($_POST['mdp'])) // verifie si le formulaire a été soumis
 {      //Récuperer les données POST
        $id = $_POST['USERNAME'];
        $motDepass = $_POST['mdp'];

        $nomCompteAdmin = 'root';
        $mdpAdmin ='';
        $erreur ='';

        //connexion à la base 
        $conn = mysqli_connect('localhost','Admin','MIA_L3_GF24','gf');

        //vérifie la connexion

        if(!$conn){
            die("Echec de la connexion :".mysqli_connect_error());
        }
        if($id == $nomCompteAdmin && $motDepass == $mdpAdmin )
        {
          header("Location:interfaceAdmin.php");
        }else{
          $erreur = "nom ou mot de passe incorrect ";
        }
 } }
 ?>

  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="compte.css">
    <title>CONNECT TO ACCOUNT</title>
</head>
 <body>
     <header>  
       <button id="userA">Log in Administrator Account</button>   <!--  bouton admin -->
       <button id="userG">Log in User Account</button>            <!--  bouton utilisateur -->
       <a href="index.php"  id="stylImg"><img src="fond/retour.png" width="40px" height="40px"></a>
     </header>
       <section id="sec">
         <?php 
         if(isset($erreur)){
          echo "<p class ='erreur'>".$erreur."</p>";
         }
         ?>
         <?php 
         if(isset($succes)){
          echo "<p class ='succes'>".$succes."</p>";
         }elseif(isset($echec)){
          echo "<p class ='erreur'>".$echec."</p>";
         }elseif(isset($informationManquante)){
          echo "<p class ='erreur'>".$informationManquante."</p>";
         }
         ?>
       </section>
       <div id="compte">

      <!-- compte Admin -->
      <fieldset  id="admin">
        <img src="fond/lock.png" width="130px" height="130px" id="sary" >

        <form method="post" action="" id="administration">
          <p><label for="USERNAME"></label><input name="USERNAME" type="text" placeholder="    Enter your username " id="administrateur"></p><br>
          <p><label for="mdp"></label><input      name="mdp" type="password" placeholder="    Enter your password " id="administrateur"></p><br>
          <p ><input name="bouton" type="submit" value="LOG IN" id="CreUserAA"></p>
         </form>
        </fieldset>
       <!-- compte simple Gestionnaire -->

      <fieldset id="user">
        <img src="fond/lock.png" width="130px" height="130px" id="sary" >
        
        <form method="post" action="">
           <p><label for="USERNAME"></label><input name="USERNAME" type="text" placeholder="Enter your username" id="utilisateur"></p><br>
           <p><label for="mdp"></label>     <input name="mdpU"     type="password" placeholder="Enter your password" id="utilisateur"></p><br>
           <p ><input  name="bouton2" type="submit" value="LOG IN" id="CreUserAc"></p><br>
        </form>
      </fieldset>

      <!-- pour creer un utilisateur -->
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

    <script src="compte.js"></script>
 </body>
</html>
