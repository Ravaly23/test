<?php 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['USERNAME']) && isset($_POST['mdp']) && isset($_POST['mdp2']) ){

    $nomUser = $_POST['USERNAME']; // on recupère le nom d'utilisateur
    $mdpUser = $_POST['mdp'];  // on recupère le mot de passe
    $confMdp = $_POST['mdp2']; // on recupère la confirmation de mot de passe
    if($mdpUser == $confMdp){
        $conn = mysqli_connect('localhost','root','','gestionfinanciere');
        $insertion = " INSERT into inscription (NOM,MOTDEPASSE,CONFIRMATIONMOTDEPASSE) values ('$nomUser' ,'$mdpUser','$confMdp ')";
        mysqli_query($conn,$insertion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation Comptet</title>
</head>
<body>
       <p>Compte creer avec succes </p>
</body>
</html>

<?php

}else{    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation Comptet</title>
</head>
<body>
       <p>Les deux mot de passe sont differents </p>
</body>
</html>

<?php     

}

}else if(!isset($_POST['USERNAME']) && !isset($_POST['mdp']) && !isset($_POST['mdp2'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation Comptet</title>
</head>
<body>
       <p> Veuillez remplir votre information </p>
</body>
</html>

<?php
}
?>

