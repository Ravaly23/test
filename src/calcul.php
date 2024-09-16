<?php

   class calculeFormule{

        public static function calc($var1,$var2,$var3,$var4){
            // Connexion à la base de données
         $conn = mysqli_connect('localhost', 'root', '', 'gestionfinanciere');

         // Vérification de la connexion
         if (!$conn) {
          die("Échec de la connexion : " . mysqli_connect_error());
         }
            if (isset($_POST[$var1]) && isset($_POST[$var2])) {
                // Exécution de la requête
                $query = "SELECT expressionFormule FROM formule WHERE nomFormule='$var3'";
                $res = mysqli_query($conn, $query);
            
                // Vérification si la requête a réussi
                if ($res) {
                    while(($donne = mysqli_fetch_assoc($res)) ) {
                        $formule = $donne['expressionFormule'];
            
                        // Récupération des données du formulaire
                        $Achatconso = $_POST[$var1];
                        $ServiceextConso = $_POST[$var2];

                        $split  = explode('+',$formule);
                        $varSplit1 = $split[0];
                        $varSplit2 = $split[1];
            
                        // Remplacement des variables dans la formule
                        $formule = str_replace([$varSplit1,$varSplit2], [$Achatconso, $ServiceextConso], $formule);
            
                        // Évaluation des formules
                        eval($var4 = $formule . ';');
                    }
                    mysqli_free_result($res);
                } else {
                    echo "Erreur : " . mysqli_error($conn);
                }
            }
            return $var4;
            }
          
        }



   

?>