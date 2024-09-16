<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuille</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- header -->
     <header>
        <div class="menu">
            <img src="icône/Menu_50px.png " class="menu_icons">
            <ul>
                <li> <a href="Manuel Projet JAVA.pdf"> Manuel d'utilisation </a> </li>
                <li> <a href="#mon_ancre"> Services </a> </li>
            </ul>

            <img src="image/images (1).png" class="logo">
        </div>

        <div class="header_end">
            <div class="login">
             <button id="seConnecter" > <span>Se connecter </span> </button>
             <hr>
             <p>Vous n'aves pas encore de compte ?</p>
             <button id="rejoigner" > <span>rejoigner</span> </button>
            </div>
        </div>
     </header>
    <!-- header -->

    <!-- home -->
     <section class="home">
     </section>
    <!-- home -->

    <!-- service -->
     <section  class="services">
        <h1 id="mon_ancre" >Découvrer les services offert par notre site</h1>
        <div class="services-list">
            <div class="box">
                <img src="image/CompteAnnuels.jpg">
                <h3>importations et affichage des données financières annuelles</h3>
            </div>

            <div class="box">
                <img src="image/CalculFinance.jpeg">
                <h3>calcul et affichage <br> des ratios clés</h3>
            </div>

            <div class="box">
                <img src="image/AnalyseFinancière.jpeg">
                <h3>analyse de la structure financière</h3>
            </div>

            <div class="box">
                <img src="image/gestion.jpg">
                <h3>simulations des performances financière</h3>
            </div>

            <div class="box">
                <img src="image/etude-de-marche_0.jpg">
                <h3>synthèse d'information financière</h3>
            </div>

        </div>

     </section>
    <!-- service -->

    <!-- footer -->
    <footer>
        <div class="div1">
            <p>Contacter-nous</p>
            
            <a href="#"> <img src="icône/Facebook_48px.png"> </a> 
            <a href="mailto:raladsondanyeric@gmail.com"> <img src="icône/Gmail_48px.png"> </a> 
            <a href="#"> <img src="icône/Phone_48px.png"> </a>  
            <a href="#"> <img src="icône/WhatsApp_48px.png">  </a> 
                         
        </div>
        <hr>
        <div class="div2">
            <p>Fait nous confiance pour gérer votre capital</p>
            <p>&copy;2024 projet gestion financière </p>
        </div>
    </footer>
    <!-- footer -->
    <script src="index.js"></script>
</body>
</html>