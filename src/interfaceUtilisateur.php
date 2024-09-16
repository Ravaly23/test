<?php 
    // on demmare une session 
    session_start();
    // Connexion à la base de données
    $conn = mysqli_connect('localhost', 'Admin', 'MIA_L3_GF24', 'gf');

    // Vérification de la connexion
    if (!$conn) {
     die("Échec de la connexion : " . mysqli_connect_error());
    }
        //initialisation des variables 
        $MargeCommerciale = 0;
        $ProductionExercice = 0;
        $consommationExercice = 0;
        $resultatExeptionnels = 0;
        $valeurAjouter = 0;
        $ExcedentBrutExploitation =0;
        $ResultatExploitation =0;
        $ResultatCourantAvantImpots = 0;
        $ResultatExercice =0;
    
        $chiffreAffaire = 0;
        $productionStocker = 0;
        $productionImmobiliser = 0;
        $venteMarchandise = 0;
        $coutAchatsMarchandiseVendue = 0;
        $achatsConsommer = 0;
        $serviceExterieur = 0;
        $subventionExploitation = 0;
        $chargePersonnel = 0;
        $impotsTaxesVersements = 0;
        $autresProduitsOperationnels = 0;
        $repriseExploitation = 0;
        $autresChargesPersonnels = 0;
        $dotationsAmmortissements = 0;
        $produitsFinanciere = 0;
        $chargeFinanciere = 0;
        $produitExtraOrdinaire = 0;
        $chargeExtraOrdinaire = 0;
        $impotBenefice = 0;
        $impotDiffere = 0;  
    
        $totalActifNonCourants = 0;
        $totalCapitauxPropre = 0;
        $totalActifCourants = 0;
        $totalPassifNonCourants = 0;
        $totalPassifCourants = 0;
        $totalActif = 0;
        $totalPassif = 0;
    
        $tauxVariationCA = 0;
        $tauxMargeCommerciale = 0;
        $tauxMarqueCommerciale = 0;
        $tauxMatierePremiere = 0;
        $tauxChargeExternes = 0;
        $tauxValeurAjouteur = 0;
        $tauxChargePersonnels = 0;
        $tauxEBE = 0;
        $tauxChargesFinanciere = 0;
        $tauxRCAI = 0;
        $IdOperationCA = 0; 
        $IdOperationPS = 0;
        $IdOperationPI = 0;
        $IdOperationMC = 0;
    
        $recuperationMC = 0;
        $recuperationPE = 0;
        $recuperationCE = 0;
        $recuperationVA = 0;
        $recuperationEBE = 0;
        $recuperationRE = 0;
        $recuperationRC = 0;
        $recuperationEX = 0;
        $recuperationEXE = 0;
    
        $De = 0;
        $Raf = 0;
        $Ret = 0;
        $Rlg = 0;
        $Rim = 0;
        $Rpf = 0;
        $DMRCC = 0;
        $DMRF = 0;
        $Rmat = 0;
        $Rimmo = 0;
        $Ractif = 0;
        $ROI = 0;
        $ROE = 0;
        $Rlr = 0;

    if(!isset($_POST['caclulCR'])){

        $nomUtilisateur = $_SESSION['USERNAME'];
        // recuperation id de l'utilisateur connecter 
        $recuperationIDUtilisateur = " SELECT IDUTILISATEUR FROM utilisateur WHERE NOM = '$nomUtilisateur'";
        $resultatIDUtilisateur = mysqli_query($conn,$recuperationIDUtilisateur);
        $IdU = mysqli_fetch_assoc($resultatIDUtilisateur);
        $idUtilisateur = (int)$IdU['IDUTILISATEUR'];

        //recuperation des valeur sur compte de resultats saisie par l'utilisateur
        $chiffreAffaire = isset($_POST['CA']) ? floatval($_POST['CA']) : 0;
        $productionStocker = isset($_POST['PS']) ? floatval($_POST['PS']) : 0;
        $productionImmobiliser = isset($_POST['PI']) ? floatval($_POST['PI']) : 0;
        $venteMarchandise = isset($_POST['VDM']) ? floatval($_POST['VDM']) : 0;
        $coutAchatsMarchandiseVendue = isset($_POST['CAMV']) ? floatval($_POST['CAMV']) : 0;
        $achatsConsommer = isset($_POST['AC']) ? floatval($_POST['AC']) : 0;
        $serviceExterieur = isset($_POST['SEAC']) ? floatval($_POST['SEAC']) : 0;
        $subventionExploitation = isset($_POST['SE']) ? floatval($_POST['SE']) : 0;
        $chargePersonnel = isset($_POST['CP']) ? floatval($_POST['CP']) : 0;
        $impotsTaxesVersements = isset($_POST['IPTVA']) ? floatval($_POST['IPTVA']) : 0;
        $autresProduitsOperationnels = isset($_POST['APO']) ? floatval($_POST['APO']) : 0;
        $repriseExploitation = isset($_POST['RE']) ? floatval($_POST['RE']) : 0;
        $autresChargesPersonnels = isset($_POST['ACP']) ? floatval($_POST['ACP']) : 0;
        $dotationsAmmortissements = isset($_POST['DAPPV']) ? floatval($_POST['DAPPV']) : 0;
        $produitsFinanciere = isset($_POST['PF']) ? floatval($_POST['PF']) : 0;
        $chargeFinanciere = isset($_POST['CF']) ? floatval($_POST['CF']) : 0;
        $produitExtraOrdinaire = isset($_POST['EEP']) ? floatval($_POST['EEP']) : 0;
        $chargeExtraOrdinaire = isset($_POST['EEC']) ? floatval($_POST['EEC']) : 0;
        $impotBenefice = isset($_POST['IER']) ? floatval($_POST['IER']) : 0;
        $impotDiffere = isset($_POST['IPD']) ? floatval($_POST['IPD']) : 0;

        if(!empty($_POST['CA']) && !empty($_POST['PS']) && !empty($_POST['PI']) && !empty($_POST['VDM'])
        && !empty($_POST['CAMV']) && !empty($_POST['AC']) && !empty($_POST['SEAC']) && !empty($_POST['SE'])
        && !empty($_POST['CP']) && !empty($_POST['IPTVA']) && !empty($_POST['APO']) && !empty($_POST['RE'])
        && !empty($_POST['ACP']) && !empty($_POST['DAPPV']) && !empty($_POST['PF']) && !empty($_POST['CF'])
        && !empty($_POST['EEP']) && !empty($_POST['EEC']) && !empty($_POST['IER']) && !empty($_POST['IPD']))
        {
            $sauver = "INSERT INTO operation (NOMRESULTAT,RESULTAT) values 
            ('chiffre affaire',$chiffreAffaire),
            ('production stocker',$productionStocker),
            ('production immobiliser',$productionImmobiliser),
            ('vente marchandise',$venteMarchandise),
            ('cout achats marchandise vendue',$coutAchatsMarchandiseVendue),
            ('achats consommer',$achatsConsommer),
            ('service exterieur',$serviceExterieur),
            ('subvention exploitation',$subventionExploitation),
            ('charge personnel',$chargePersonnel),
            ('impots taxes versements',$impotsTaxesVersements),
            ('autres produits operationnels',$autresProduitsOperationnels),
            ('reprise exploitation',$repriseExploitation),
            ('autres charges personnels',$autresChargesPersonnels),
            ('dotations ammortissements',$dotationsAmmortissements),
            ('produits financiere',$produitsFinanciere),
            ('charges financiere',$chargeFinanciere),
            ('produits extra ordinaire',$produitExtraOrdinaire),
            ('charges extra ordinaire',$chargeExtraOrdinaire),
            ('impot benefice',$impotBenefice),
            ('impot differe',$impotDiffere)";

            mysqli_query($conn,$sauver);

            // recuperation id operation des operations ci-dessous 
            $recuperationIdOperationCA = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='chiffre affaire'";
            $resultatIdOperationCA = mysqli_query($conn,$recuperationIdOperationCA);
            $IdOpCA = mysqli_fetch_assoc($resultatIdOperationCA);
            $IdOperationCA = (float)$IdOpCA['IDOPERATION'];

            $recuperationIdOperationPS = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='production stocker'";
            $resultatIdOperationPS = mysqli_query($conn,$recuperationIdOperationPS);
            $IdOpPS = mysqli_fetch_assoc($resultatIdOperationPS);
            $IdOperationPS = (float)$IdOpPS['IDOPERATION'];

            $recuperationIdOperationPI = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='production immobiliser'";
            $resultatIdOperationPI = mysqli_query($conn,$recuperationIdOperationPI);
            $IdOpPI = mysqli_fetch_assoc($resultatIdOperationPI);
            $IdOperationPI = (float)$IdOpPI['IDOPERATION'];

            $recuperationIdOperationVM = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='vente marchandise'";
            $resultatIdOperationVM = mysqli_query($conn,$recuperationIdOperationVM);
            $IdOpVM = mysqli_fetch_assoc($resultatIdOperationVM);
            $IdOperationVM = (float)$IdOpVM['IDOPERATION'];

            $recuperationIdOperationCAMV = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='cout achats marchandise vendue'";
            $resultatIdOperationCAMV = mysqli_query($conn,$recuperationIdOperationCAMV);
            $IdOpCAMV = mysqli_fetch_assoc($resultatIdOperationCAMV);
            $IdOperationCAMV = (float)$IdOpCAMV['IDOPERATION'];

            $recuperationIdOperationAC = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='achats consommer'";
            $resultatIdOperationAC = mysqli_query($conn,$recuperationIdOperationAC);
            $IdOpAC = mysqli_fetch_assoc($resultatIdOperationAC);
            $IdOperationAC = (float)$IdOpAC['IDOPERATION'];

            $recuperationIdOperationSE = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='service exterieur'";
            $resultatIdOperationSE = mysqli_query($conn,$recuperationIdOperationSE);
            $IdOpSE = mysqli_fetch_assoc($resultatIdOperationSE);
            $IdOperationSE = (float)$IdOpSE['IDOPERATION'];

            $recuperationIdOperationSEE = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='subvention exploitation'";
            $resultatIdOperationSEE = mysqli_query($conn,$recuperationIdOperationSEE);
            $IdOpSEE = mysqli_fetch_assoc($resultatIdOperationSEE);
            $IdOperationSEE = (float)$IdOpSEE['IDOPERATION'];

            $recuperationIdOperationCP = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='charge personnel'";
            $resultatIdOperationCP = mysqli_query($conn,$recuperationIdOperationCP);
            $IdOpCP = mysqli_fetch_assoc($resultatIdOperationCP);
            $IdOperationCP = (float)$IdOpCP['IDOPERATION'];

            $recuperationIdOperationITV = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='impots taxes versements'";
            $resultatIdOperationITV = mysqli_query($conn,$recuperationIdOperationITV);
            $IdOpITV = mysqli_fetch_assoc($resultatIdOperationITV);
            $IdOperationITV = (float)$IdOpITV['IDOPERATION'];

            $recuperationIdOperationAPO = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='autres produits operationnels'";
            $resultatIdOperationAPO = mysqli_query($conn,$recuperationIdOperationAPO);
            $IdOpAPO = mysqli_fetch_assoc($resultatIdOperationAPO);
            $IdOperationAPO = (float)$IdOpAPO['IDOPERATION'];

            $recuperationIdOperationRE = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='reprise exploitation'";
            $resultatIdOperationRE = mysqli_query($conn,$recuperationIdOperationRE);
            $IdOpRE = mysqli_fetch_assoc($resultatIdOperationRE);
            $IdOperationRE = (float)$IdOpRE['IDOPERATION'];

            $recuperationIdOperationACP = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='autres charges personnels'";
            $resultatIdOperationACP = mysqli_query($conn,$recuperationIdOperationACP);
            $IdOpACP = mysqli_fetch_assoc($resultatIdOperationACP);
            $IdOperationACP = (float)$IdOpACP['IDOPERATION'];

            $recuperationIdOperationDA = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='dotations ammortissements'";
            $resultatIdOperationDA = mysqli_query($conn,$recuperationIdOperationDA);
            $IdOpDA = mysqli_fetch_assoc($resultatIdOperationDA);
            $IdOperationDA = (float)$IdOpDA['IDOPERATION'];

            $recuperationIdOperationPF = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='produits financiere'";
            $resultatIdOperationPF = mysqli_query($conn,$recuperationIdOperationPF);
            $IdOpPF = mysqli_fetch_assoc($resultatIdOperationPF);
            $IdOperationPF = (float)$IdOpPF['IDOPERATION'];

            $recuperationIdOperationCF = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='charges financiere'";
            $resultatIdOperationCF = mysqli_query($conn,$recuperationIdOperationCF);
            $IdOpCF = mysqli_fetch_assoc($resultatIdOperationCF);
            $IdOperationCF = (float)$IdOpCF['IDOPERATION'];

            $recuperationIdOperationPEO = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='produits extra ordinaire'";
            $resultatIdOperationPEO = mysqli_query($conn,$recuperationIdOperationPEO);
            $IdOpPEO = mysqli_fetch_assoc($resultatIdOperationPEO);
            $IdOperationPEO = (float)$IdOpPEO['IDOPERATION'];

            $recuperationIdOperationCEO = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='charges extra ordinaire'";
            $resultatIdOperationCEO = mysqli_query($conn,$recuperationIdOperationCEO);
            $IdOpCEO = mysqli_fetch_assoc($resultatIdOperationCEO);
            $IdOperationCEO = (float)$IdOpCEO['IDOPERATION'];

            $recuperationIdOperationIB = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='impot benefice'";
            $resultatIdOperationIB = mysqli_query($conn,$recuperationIdOperationIB);
            $IdOpIB = mysqli_fetch_assoc($resultatIdOperationIB);
            $IdOperationIB = (float)$IdOpIB['IDOPERATION'];

            $recuperationIdOperationID = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='impot differe'";
            $resultatIdOperationID = mysqli_query($conn,$recuperationIdOperationID);
            $IdOpID = mysqli_fetch_assoc($resultatIdOperationID);
            $IdOperationID = (float)$IdOpID['IDOPERATION'];

            // sauvegarder les idopeartion que l'utilisateur a effectué 
            $sauvegarderIdOperationCA = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationCA,now())";
            mysqli_query($conn,$sauvegarderIdOperationCA);
            $sauvegarderIdOperationPS = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationPS,now())";
            mysqli_query($conn,$sauvegarderIdOperationPS);
            $sauvegarderIdOperationPI = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationPI,now())";
            mysqli_query($conn,$sauvegarderIdOperationPI);
            $sauvegarderIdOperationVM = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationVM,now())";
            mysqli_query($conn,$sauvegarderIdOperationVM);
            $sauvegarderIdOperationCAMV = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationCAMV,now())";
            mysqli_query($conn,$sauvegarderIdOperationCAMV);
            $sauvegarderIdOperationAC = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationAC,now())";
            mysqli_query($conn,$sauvegarderIdOperationAC);
            $sauvegarderIdOperationSE = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationSE,now())";
            mysqli_query($conn,$sauvegarderIdOperationSE);
            $sauvegarderIdOperationSEE = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationSEE,now())";
            mysqli_query($conn,$sauvegarderIdOperationSEE);
            $sauvegarderIdOperationCP = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationCP,now())";
            mysqli_query($conn,$sauvegarderIdOperationCP);
            $sauvegarderIdOperationITV = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationITV,now())";
            mysqli_query($conn,$sauvegarderIdOperationITV);
            $sauvegarderIdOperationAPO = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationAPO,now())";
            mysqli_query($conn,$sauvegarderIdOperationAPO);
            $sauvegarderIdOperationRE = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationRE,now())";
            mysqli_query($conn,$sauvegarderIdOperationRE);
            $sauvegarderIdOperationACP = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationACP,now())";
            mysqli_query($conn,$sauvegarderIdOperationACP);
            $sauvegarderIdOperationDA = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationDA,now())";
            mysqli_query($conn,$sauvegarderIdOperationDA);
            $sauvegarderIdOperationPF = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationPF,now())";
            mysqli_query($conn,$sauvegarderIdOperationPF);
            $sauvegarderIdOperationCF = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationCF,now())";
            mysqli_query($conn,$sauvegarderIdOperationCF);
            $sauvegarderIdOperationPEO = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationPEO,now())";
            mysqli_query($conn,$sauvegarderIdOperationPEO);
            $sauvegarderIdOperationCEO = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationCEO,now())";
            mysqli_query($conn,$sauvegarderIdOperationCEO);
            $sauvegarderIdOperationIB = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationIB,now())";
            mysqli_query($conn,$sauvegarderIdOperationIB);
            $sauvegarderIdOperationID = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationID,now())";
            mysqli_query($conn,$sauvegarderIdOperationID);
                    
        }
        
    }
    if(isset($_POST['affchageSIG'])){
        // calculer des valeurs a afficher sur SIG
        $recuperationMargeCommerciale = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'marge commerciale' ";

        $recuperationProductionExercice ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'production exercice' ";
                     
        $recuperationConsommationExercice ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'consommation Exercice' ";

        $recuperationValeurAjouter ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'valeur ajouter' ";

        $recuperationExcedentBrut ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'excedent brut exploitation' ";

        $recuperationResultatExploitation ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'resultat exploitation' ";

        $recuperationResultatCourant ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'resultat courant avant impots' ";

        $recuperationResultatException ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'resultat exceptionnels' ";

        $recuperationResultatExercice ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'resultat exercice' "; 
        
        
        $resultatMC = mysqli_query($conn,$recuperationMargeCommerciale);
        $MargeCommerciale = mysqli_fetch_assoc($resultatMC);
        $recuperationMC = (float)$MargeCommerciale['RESULTAT'];

        $resultatPE = mysqli_query($conn,$recuperationProductionExercice);
        $ProductionExercice = mysqli_fetch_assoc($resultatPE);
        $recuperationPE = (float)$ProductionExercice['RESULTAT'];

        $resultatCE = mysqli_query($conn,$recuperationConsommationExercice);
        $ConsommationExercice = mysqli_fetch_assoc($resultatCE);
        $recuperationCE = (float)$ConsommationExercice['RESULTAT'];

        $resultatVA = mysqli_query($conn,$recuperationValeurAjouter);
        $ValeurAjouter = mysqli_fetch_assoc($resultatVA);
        $recuperationVA = (float)$ValeurAjouter['RESULTAT'];

        $resultatEBE = mysqli_query($conn,$recuperationExcedentBrut);
        $ExcedentBrut = mysqli_fetch_assoc($resultatEBE);
        $recuperationEBE = (float)$ExcedentBrut['RESULTAT'];

        $resultatRE = mysqli_query($conn,$recuperationResultatExploitation);
        $ResultatExploitation = mysqli_fetch_assoc($resultatRE);
        $recuperationRE = (float)$ResultatExploitation['RESULTAT'];

        $resultatRC = mysqli_query($conn,$recuperationResultatCourant);
        $ResultatCourant = mysqli_fetch_assoc($resultatRC);
        $recuperationRC = (float)$ResultatCourant['RESULTAT'];

        $resultatEX = mysqli_query($conn,$recuperationResultatException);
        $ResultatException = mysqli_fetch_assoc($resultatEX);
        $recuperationEX = (float)$ResultatException['RESULTAT'];

        $resultatEXE = mysqli_query($conn,$recuperationResultatExercice);
        $ResultatExercice = mysqli_fetch_assoc($resultatEXE);
        $recuperationEXE =(float)$ResultatExercice['RESULTAT'];
 
        if(empty($recuperationMC) &&  empty($PE) && empty($recuperationCE) && empty($recuperationVA) 
        && empty($recuperationEBE) && empty($recuperationRE) && empty($recuperationRC)
        && empty($recuperationRC) &&  empty($recuperationEX) && empty($recuperationEXE))
        {

        $requete0 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'chiffre affaire' ";

        $requete1 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'production stocker' ";

        $requete2 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'production immobiliser' ";

        $requete3 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'vente marchandise' ";

        $requete4 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'cout achats marchandise vendue' ";

        $requete5 ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'achats consommer' ";

        $requete6 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'service exterieur' ";

        $requete7 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'subvention exploitation' ";

        $requete8 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charge personnel' ";

        $requete9 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impots taxes versements' ";

        $requete10 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'autres produits operationnels' ";

        $requete11 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'reprise exploitation' ";

        $requete12 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'autres charges personnels' ";

        $requete13 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'dotations ammortissements' ";

        $requete14 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'produits financiere' ";

        $requete15 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charges financiere' ";

        $requete16 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'produits extra ordinaire' ";

        $requete17 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charges extra ordinaire' ";

        $requete18 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impot benefice' ";

        $requete19 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impot differe' ";

        
        $CA = mysqli_query($conn,$requete0);
        $PS = mysqli_query($conn,$requete1);
        $PI = mysqli_query($conn,$requete2);
        $VM = mysqli_query($conn,$requete3);
        $CAMV = mysqli_query($conn,$requete4);
        $AC = mysqli_query($conn,$requete5);
        $SE = mysqli_query($conn,$requete6);
        $SDE = mysqli_query($conn,$requete7);
        $CP = mysqli_query($conn,$requete8);
        $ITV = mysqli_query($conn,$requete9);
        $APO = mysqli_query($conn,$requete10);
        $RE = mysqli_query($conn,$requete11);
        $ACP = mysqli_query($conn,$requete12);
        $DA = mysqli_query($conn,$requete13);
        $PF = mysqli_query($conn,$requete14);
        $CF = mysqli_query($conn,$requete15);
        $PEO = mysqli_query($conn,$requete16);
        $CEO = mysqli_query($conn,$requete17);
        $IB = mysqli_query($conn,$requete18);
        $ID = mysqli_query($conn,$requete19);

        $chiffreAffaire = mysqli_fetch_assoc($CA);
        $productionStocker = mysqli_fetch_assoc($PS);
        $productionImmobiliser = mysqli_fetch_assoc($PI); 
        $venteMarchandise = mysqli_fetch_assoc($VM);
        $coutAchatsMarchandiseVendue = mysqli_fetch_assoc($CAMV);
        $achatsConsommer = mysqli_fetch_assoc($AC);
        $serviceExterieur = mysqli_fetch_assoc($AC);
        $subventionExploitation = mysqli_fetch_assoc($SDE);
        $chargePersonnel = mysqli_fetch_assoc($CP);
        $impotsTaxesVersements = mysqli_fetch_assoc($ITV);
        $autresProduitsOperationnels = mysqli_fetch_assoc($APO);
        $repriseExploitation = mysqli_fetch_assoc($RE);
        $autresChargesPersonnels = mysqli_fetch_assoc($ACP);
        $dotationsAmmortissements = mysqli_fetch_assoc($DA);
        $produitsFinanciere = mysqli_fetch_assoc($PF);
        $chargeFinanciere = mysqli_fetch_assoc($CF);
        $produitExtraOrdinaire = mysqli_fetch_assoc($PEO);
        $chargeExtraOrdinaire = mysqli_fetch_assoc($CEO);
        $impotBenefice = mysqli_fetch_assoc($IB);
        $impotDiffere = mysqli_fetch_assoc($ID);
     
        //Marge commercial 
        $MargeCommerciale = (float)$venteMarchandise['RESULTAT']-(float)$coutAchatsMarchandiseVendue['RESULTAT'];
        //production de l'exercice
        $ProductionExercice = (float)$chiffreAffaire['RESULTAT']+(float)$productionStocker['RESULTAT']+(float)$productionImmobiliser['RESULTAT'];
        // consommation de l'exercice 
        $consommationExercice = (float)$achatsConsommer['RESULTAT']+(float)$serviceExterieur['RESULTAT'];
        //valeur ajoutée 
        $valeurAjouter  = $MargeCommerciale+$ProductionExercice-$consommationExercice;
        //Excedent Brut d'exploitation 
        $ExcedentBrutExploitation = ($valeurAjouter+(float)$subventionExploitation['RESULTAT'])-((float)$chargePersonnel['RESULTAT']+(float)$impotsTaxesVersements['RESULTAT']);
        //Résultat Exploitation 
        $ResultatExploitation = ((float)$autresProduitsOperationnels['RESULTAT']+(float)$repriseExploitation['RESULTAT']+$ExcedentBrutExploitation)-((float)$autresChargesPersonnels['RESULTAT']+(float)$dotationsAmmortissements['RESULTAT']);
        //Résultat Courant Avant Impôts
        $ResultatCourantAvantImpots = ((float)$produitsFinanciere['RESULTAT']+$ResultatExploitation)-(float)$chargeFinanciere['RESULTAT'];
        //resultat exceptionnels
        $resultatExeptionnels = (float)$produitExtraOrdinaire['RESULTAT']-(float)$chargeExtraOrdinaire['RESULTAT'];
        //Résultat de l'Exercice 
        $ResultatExercice = ($ResultatCourantAvantImpots+$resultatExeptionnels) - ((float)$impotBenefice['RESULTAT']+(float)$impotDiffere['RESULTAT']);


            $sauvegarderSIG = "INSERT INTO operation (NOMRESULTAT,RESULTAT) values 
            ('marge commerciale',$MargeCommerciale),
            ('production exercice',$ProductionExercice),
            ('consommation Exercice',$consommationExercice),
            ('valeur ajouter',$valeurAjouter),
            ('excedent brut exploitation',$ExcedentBrutExploitation),
            ('resultat exploitation',$ResultatExploitation),
            ('resultat courant avant impots',$ResultatCourantAvantImpots),
            ('resultat exceptionnels',$resultatExeptionnels),
            ('resultat exercice',$ResultatExercice)";
            
            mysqli_query($conn,$sauvegarderSIG);
        
           // recuperation id operation des operations ci-dessous
           $recuperationIdOperationMC = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='marge commerciale'";
           $resultatIdOperationMC = mysqli_query($conn,$recuperationIdOperationMC);
           $IdOpMC = mysqli_fetch_assoc($resultatIdOperationMC);
           $IdOperationMC = (float)$IdOpMC['IDOPERATION'];

           $recuperationIdOperationPE = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='production exercice'";
           $resultatIdOperationPE = mysqli_query($conn,$recuperationIdOperationPE);
           $IdOpPE = mysqli_fetch_assoc($resultatIdOperationPE);
           $IdOperationPE = (float)$IdOpPE['IDOPERATION'];

           $recuperationIdOperationCE = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='consommation Exercice'";
           $resultatIdOperationCE = mysqli_query($conn,$recuperationIdOperationCE);
           $IdOpCE = mysqli_fetch_assoc($resultatIdOperationCE);
           $IdOperationCE = (float)$IdOpCE['IDOPERATION'];

           $recuperationIdOperationVA = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='valeur ajouter'";
           $resultatIdOperationVA = mysqli_query($conn,$recuperationIdOperationVA);
           $IdOpVA = mysqli_fetch_assoc($resultatIdOperationVA);
           $IdOperationVA = (float)$IdOpVA['IDOPERATION'];

           $recuperationIdOperationEBE = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='excedent brut exploitation'";
           $resultatIdOperationEBE = mysqli_query($conn,$recuperationIdOperationEBE);
           $IdOpEBE = mysqli_fetch_assoc($resultatIdOperationEBE);
           $IdOperationEBE = (float)$IdOpEBE['IDOPERATION'];

           $recuperationIdOperationRE = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='resultat exploitation'";
           $resultatIdOperationRE = mysqli_query($conn,$recuperationIdOperationRE);
           $IdOpRE = mysqli_fetch_assoc($resultatIdOperationRE);
           $IdOperationRE = (float)$IdOpRE['IDOPERATION'];

           $recuperationIdOperationRCA = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='resultat courant avant impots'";
           $resultatIdOperationRCA = mysqli_query($conn,$recuperationIdOperationRCA);
           $IdOpRCA = mysqli_fetch_assoc($resultatIdOperationRCA);
           $IdOperationRCA = (float)$IdOpRCA['IDOPERATION'];

           $recuperationIdOperationREX = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='resultat exceptionnels'";
           $resultatIdOperationREX = mysqli_query($conn,$recuperationIdOperationREX);
           $IdOpREX = mysqli_fetch_assoc($resultatIdOperationREX);
           $IdOperationREX = (float)$IdOpREX['IDOPERATION'];

           $recuperationIdOperationREXE = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='resultat exercice'";
           $resultatIdOperationREXE = mysqli_query($conn,$recuperationIdOperationREXE);
           $IdOpREXE = mysqli_fetch_assoc($resultatIdOperationREXE);
           $IdOperationREXE = (float)$IdOpREXE['IDOPERATION'];

        

          // sauvegarder les idopeartion que l'utilisateur a effectué 
          $sauvegarderIdOperationMC = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationMC,now())";
          mysqli_query($conn,$sauvegarderIdOperationMC);
          $sauvegarderIdOperationPE = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationPE,now())";
          mysqli_query($conn,$sauvegarderIdOperationPE);
          $sauvegarderIdOperationCE = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationCE,now())";
          mysqli_query($conn,$sauvegarderIdOperationCE);
          $sauvegarderIdOperationVA = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationVA,now())";
          mysqli_query($conn,$sauvegarderIdOperationVA);
          $sauvegarderIdOperationEBE = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationEBE,now())";
          mysqli_query($conn,$sauvegarderIdOperationEBE);
          $sauvegarderIdOperationRE = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationRE,now())";
          mysqli_query($conn,$sauvegarderIdOperationRE);
          $sauvegarderIdOperationRCA = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationRCA,now())";
          mysqli_query($conn,$sauvegarderIdOperationRCA);
          $sauvegarderIdOperationREX = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationREX,now())";
          mysqli_query($conn,$sauvegarderIdOperationREX);
          $sauvegarderIdOperationREXE = "INSERT INTO effectuer VALUES ($idUtilisateur,$IdOperationREXE,now())";
          mysqli_query($conn,$sauvegarderIdOperationREXE);
        }else{
        $requete0 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'chiffre affaire' ";

        $requete1 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'production stocker' ";

        $requete2 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'production immobiliser' ";

        $requete3 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'vente marchandise' ";

        $requete4 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'cout achats marchandise vendue' ";

        $requete5 ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'achats consommer' ";

        $requete6 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'service exterieur' ";

        $requete7 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'subvention exploitation' ";

        $requete8 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charge personnel' ";

        $requete9 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impots taxes versements' ";

        $requete10 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'autres produits operationnels' ";

        $requete11 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'reprise exploitation' ";

        $requete12 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'autres charges personnels' ";

        $requete13 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'dotations ammortissements' ";

        $requete14 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'produits financiere' ";

        $requete15 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charges financiere' ";

        $requete16 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'produits extra ordinaire' ";

        $requete17 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charges extra ordinaire' ";

        $requete18 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impot benefice' ";

        $requete19 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impot differe' ";

        
        $CA = mysqli_query($conn,$requete0);
        $PS = mysqli_query($conn,$requete1);
        $PI = mysqli_query($conn,$requete2);
        $VM = mysqli_query($conn,$requete3);
        $CAMV = mysqli_query($conn,$requete4);
        $AC = mysqli_query($conn,$requete5);
        $SE = mysqli_query($conn,$requete6);
        $SDE = mysqli_query($conn,$requete7);
        $CP = mysqli_query($conn,$requete8);
        $ITV = mysqli_query($conn,$requete9);
        $APO = mysqli_query($conn,$requete10);
        $RE = mysqli_query($conn,$requete11);
        $ACP = mysqli_query($conn,$requete12);
        $DA = mysqli_query($conn,$requete13);
        $PF = mysqli_query($conn,$requete14);
        $CF = mysqli_query($conn,$requete15);
        $PEO = mysqli_query($conn,$requete16);
        $CEO = mysqli_query($conn,$requete17);
        $IB = mysqli_query($conn,$requete18);
        $ID = mysqli_query($conn,$requete19);

        $chiffreAffaire = mysqli_fetch_assoc($CA);
        $productionStocker = mysqli_fetch_assoc($PS);
        $productionImmobiliser = mysqli_fetch_assoc($PI); 
        $venteMarchandise = mysqli_fetch_assoc($VM);
        $coutAchatsMarchandiseVendue = mysqli_fetch_assoc($CAMV);
        $achatsConsommer = mysqli_fetch_assoc($AC);
        $serviceExterieur = mysqli_fetch_assoc($AC);
        $subventionExploitation = mysqli_fetch_assoc($SDE);
        $chargePersonnel = mysqli_fetch_assoc($CP);
        $impotsTaxesVersements = mysqli_fetch_assoc($ITV);
        $autresProduitsOperationnels = mysqli_fetch_assoc($APO);
        $repriseExploitation = mysqli_fetch_assoc($RE);
        $autresChargesPersonnels = mysqli_fetch_assoc($ACP);
        $dotationsAmmortissements = mysqli_fetch_assoc($DA);
        $produitsFinanciere = mysqli_fetch_assoc($PF);
        $chargeFinanciere = mysqli_fetch_assoc($CF);
        $produitExtraOrdinaire = mysqli_fetch_assoc($PEO);
        $chargeExtraOrdinaire = mysqli_fetch_assoc($CEO);
        $impotBenefice = mysqli_fetch_assoc($IB);
        $impotDiffere = mysqli_fetch_assoc($ID);
     
        //Marge commercial 
        $MargeCommerciale = (float)$venteMarchandise['RESULTAT']-(float)$coutAchatsMarchandiseVendue['RESULTAT'];
        //production de l'exercice
        $ProductionExercice = (float)$chiffreAffaire['RESULTAT']+(float)$productionStocker['RESULTAT']+(float)$productionImmobiliser['RESULTAT'];
        // consommation de l'exercice 
        $consommationExercice = (float)$achatsConsommer['RESULTAT']+(float)$serviceExterieur['RESULTAT'];
        //valeur ajoutée 
        $valeurAjouter  = $MargeCommerciale+$ProductionExercice-$consommationExercice;
        //Excedent Brut d'exploitation 
        $ExcedentBrutExploitation = ($valeurAjouter+(float)$subventionExploitation['RESULTAT'])-((float)$chargePersonnel['RESULTAT']+(float)$impotsTaxesVersements['RESULTAT']);
        //Résultat Exploitation 
        $ResultatExploitation = ((float)$autresProduitsOperationnels['RESULTAT']+(float)$repriseExploitation['RESULTAT']+$ExcedentBrutExploitation)-((float)$autresChargesPersonnels['RESULTAT']+(float)$dotationsAmmortissements['RESULTAT']);
        //Résultat Courant Avant Impôts
        $ResultatCourantAvantImpots = ((float)$produitsFinanciere['RESULTAT']+$ResultatExploitation)-(float)$chargeFinanciere['RESULTAT'];
        //resultat exceptionnels
        $resultatExeptionnels = (float)$produitExtraOrdinaire['RESULTAT']-(float)$chargeExtraOrdinaire['RESULTAT'];
        //Résultat de l'Exercice 
        $ResultatExercice = ($ResultatCourantAvantImpots+$resultatExeptionnels) - ((float)$impotBenefice['RESULTAT']+(float)$impotDiffere['RESULTAT']);
        }     
  }

    // fonction pour calculer les ratios à partir du SIG 
    
    function calculRatioDuSIG($var1,$var2,$var3,$var4,$var5){
                           
        // connexion à la base des données 
        $conn = mysqli_connect('localhost','Admin','MIA_L3_GF24','gf');

        
                       
        // Vérification de la connexion
        if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error()); 
        }
 
        //réquetes de récuperation des formules des ratios à partir du SIG dans la base de donées
                       
        // Préparation de la requête SQL
          $stmt = mysqli_prepare($conn, "SELECT EXPRESSIONFORMULE FROM formule WHERE NOMFORMULE = ?");
          mysqli_stmt_bind_param($stmt, "s", $var1);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
                               
        // recuperation du résultat générer par le requete 
                                              
          while ($row = mysqli_fetch_assoc($result)) {
            $formule = $row['EXPRESSIONFORMULE'];
                             
            // Remplacement des variables dans la formule
              $formule = str_replace([$var2, $var3], [$var4, $var5], $formule);

            // Évaluation des formules
            if($var4 !=0 && $var5 != 0){ // pour eviter l'erreur avant que l'utilisateur entre les données 
              $resultat = eval('return ' . $formule . ';');
            }
           // Fermeture de la connexion
           mysqli_close($conn);
          
        return isset($resultat) ? $resultat : null;
        }
    }

    $MargeCommercialeNew = 0;
    $ProductionExerciceNew = 0;
    $consommationExerciceNew = 0;
    $valeurAjouterNew  = 0;
    $ExcedentBrutExploitationNew = 0;
    $ResultatExploitationNew = 0;
    $ResultatCourantAvantImpotsNew = 0;
    $resultatExeptionnelsNew = 0;
    $ResultatExerciceNew = 0;

    if(isset($_POST['ratioSIG']))
    {

        $requete0 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'chiffre affaire' ";

        $requete1 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'production stocker' ";

        $requete2 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'production immobiliser' ";

        $requete3 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'vente marchandise' ";

        $requete4 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'cout achats marchandise vendue' ";

        $requete5 ="SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                    operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                    AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'achats consommer' ";

        $requete6 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'service exterieur' ";

        $requete7 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'subvention exploitation' ";

        $requete8 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charge personnel' ";

        $requete9 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                     operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                     AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impots taxes versements' ";

        $requete10 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'autres produits operationnels' ";

        $requete11 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'reprise exploitation' ";

        $requete12 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'autres charges personnels' ";

        $requete13 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'dotations ammortissements' ";

        $requete14 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'produits financiere' ";

        $requete15 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charges financiere' ";

        $requete16 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'produits extra ordinaire' ";

        $requete17 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'charges extra ordinaire' ";

        $requete18 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impot benefice' ";

        $requete19 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
                      operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
                      AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'impot differe' ";

        $requete20 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'marge commerciale' ";

        $requete21 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'production exercice' ";

        $requete22 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'consommation Exercice' ";

        $requete23 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'valeur ajouter' ";
        
        $requete24 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'excedent brut exploitation' ";

        $requete25 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'resultat courant avant impots' ";

        $requete26 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'resultat exploitation' ";

        $requete27 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'resultat exceptionnels' ";

        $requete28 = "SELECT RESULTAT FROM operation,effectuer,utilisateur WHERE 
        operation.IDOPERATION = effectuer.IDOPERATION AND utilisateur.IDUTILISATEUR = effectuer.IDUTILISATEUR 
        AND utilisateur.IDUTILISATEUR = $idUtilisateur AND NOMRESULTAT = 'resultat exercice' ";

        $CA = mysqli_query($conn,$requete0);
        $PS = mysqli_query($conn,$requete1);
        $PI = mysqli_query($conn,$requete2);
        $VM = mysqli_query($conn,$requete3);
        $CAMV = mysqli_query($conn,$requete4);
        $AC = mysqli_query($conn,$requete5);
        $SE = mysqli_query($conn,$requete6);
        $SDE = mysqli_query($conn,$requete7);
        $CP = mysqli_query($conn,$requete8);
        $ITV = mysqli_query($conn,$requete9);
        $APO = mysqli_query($conn,$requete10);
        $RE = mysqli_query($conn,$requete11);
        $ACP = mysqli_query($conn,$requete12);
        $DA = mysqli_query($conn,$requete13);
        $PF = mysqli_query($conn,$requete14);
        $CF = mysqli_query($conn,$requete15);
        $PEO = mysqli_query($conn,$requete16);
        $CEO = mysqli_query($conn,$requete17);
        $IB = mysqli_query($conn,$requete18);
        $ID = mysqli_query($conn,$requete19);

        $MC = mysqli_query($conn,$requete20);
        $PE = mysqli_query($conn,$requete21);
        $CE = mysqli_query($conn,$requete22);
        $VA = mysqli_query($conn,$requete23);
        $EBE = mysqli_query($conn,$requete24);
        $RCA = mysqli_query($conn,$requete25);
        $REE = mysqli_query($conn,$requete26);
        $REX = mysqli_query($conn,$requete27);
        $REC = mysqli_query($conn,$requete28);

        $chiffreAffaire = mysqli_fetch_assoc($CA);
        $productionStocker = mysqli_fetch_assoc($PS);
        $productionImmobiliser = mysqli_fetch_assoc($PI); 
        $venteMarchandise = mysqli_fetch_assoc($VM);
        $coutAchatsMarchandiseVendue = mysqli_fetch_assoc($CAMV);
        $achatsConsommer = mysqli_fetch_assoc($AC);
        $serviceExterieur = mysqli_fetch_assoc($SE);
        $subventionExploitation = mysqli_fetch_assoc($SDE);
        $chargePersonnel = mysqli_fetch_assoc($CP);
        $impotsTaxesVersements = mysqli_fetch_assoc($ITV);
        $autresProduitsOperationnels = mysqli_fetch_assoc($APO);
        $repriseExploitation = mysqli_fetch_assoc($RE);
        $autresChargesPersonnels = mysqli_fetch_assoc($ACP);
        $dotationsAmmortissements = mysqli_fetch_assoc($DA);
        $produitsFinanciere = mysqli_fetch_assoc($PF);
        $chargeFinanciere = mysqli_fetch_assoc($CF);
        $produitExtraOrdinaire = mysqli_fetch_assoc($PEO);
        $chargeExtraOrdinaire = mysqli_fetch_assoc($CEO);
        $impotBenefice = mysqli_fetch_assoc($IB);
        $impotDiffere = mysqli_fetch_assoc($ID);

        $MargeCommercialeNew = mysqli_fetch_assoc($MC);
        $ProductionExerciceNew = mysqli_fetch_assoc($PE);
        $consommationExerciceNew = mysqli_fetch_assoc($CE);
        $valeurAjouterNew  = mysqli_fetch_assoc($VA);
        $ExcedentBrutExploitationNew = mysqli_fetch_assoc($EBE);
        $ResultatExploitationNew = mysqli_fetch_assoc($RCA);
        $ResultatCourantAvantImpotsNew = mysqli_fetch_assoc($REE);
        $resultatExeptionnelsNew = mysqli_fetch_assoc($REX);
        $ResultatExerciceNew = mysqli_fetch_assoc($REC);

        $tauxVariationCA = calculRatioDuSIG('TauxProbabilite','ResultatNet','CA',(float)$ResultatExerciceNew['RESULTAT'],(float)$chiffreAffaire['RESULTAT']);
        $tauxMargeCommerciale = calculRatioDuSIG('TauxMargeCommercial','MargeCommerciale','CAMV',(float)$MargeCommercialeNew['RESULTAT'],(float)$coutAchatsMarchandiseVendue['RESULTAT']);
        $tauxMarqueCommerciale = calculRatioDuSIG('TauxMarqueCommercial','MargeCommerciale','VenteMarchandise',(float)$MargeCommercialeNew['RESULTAT'],(float)$venteMarchandise['RESULTAT']);
        $tauxMatierePremiere = calculRatioDuSIG('TauxMatierePremiere','CAMPC','ProductionExercice',(float)$achatsConsommer['RESULTAT'],(float)$ProductionExerciceNew['RESULTAT']);
        $tauxChargeExternes = calculRatioDuSIG('TauxChargeExterne','ChargeExterne','CA',(float)$serviceExterieur['RESULTAT'],(float)$chiffreAffaire['RESULTAT']);
        $tauxValeurAjouteur = calculRatioDuSIG('TauxValeurAjoute','ValeurAjouter','CA',(float)$valeurAjouterNew['RESULTAT'],(float)$chiffreAffaire['RESULTAT']);
        $tauxChargePersonnels = calculRatioDuSIG('TauxChargePersonnel','ChargePersonnel','ValeurAjouter',(float)$chargePersonnel['RESULTAT'],(float)$valeurAjouterNew['RESULTAT']);
        $tauxEBE = calculRatioDuSIG('TauxEBE','EBE','CA',(float)$ExcedentBrutExploitationNew['RESULTAT'],(float)$chiffreAffaire['RESULTAT']);
        $tauxChargesFinanciere = calculRatioDuSIG('TauxChargeFinanciere','ChargeFinanciere','CA',(float)$chargeFinanciere['RESULTAT'],(float)$chiffreAffaire['RESULTAT']);
        $tauxRCAI = calculRatioDuSIG('TauxRCAI','RCAI','CA',(float)$ResultatCourantAvantImpotsNew['RESULTAT'],(float)$chiffreAffaire['RESULTAT']);
    }

    // bilan comptable

    if(isset($_POST['calculBilan']))
    {
        // Connexion à la base de données
        $mysqli = mysqli_connect("localhost", "Admin", "MIA_L3_GF24", "gf");

        if (!$mysqli) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Initialisation des totaux
        $totalActifNonCourants = 0;
        $totalCapitauxPropre = 0;
        $totalActifCourants = 0;
        $totalPassifNonCourants = 0;
        $totalPassifCourants = 0;
        $totalActif = 0;
        $totalPassif = 0;
        // Calcul des totaux pour les Actif Non Courants
        if (!empty($_POST['actifNoncourantsMontant'])) {
            foreach ($_POST['actifNoncourantsMontant'] as $montant) {
                $totalActifNonCourants += floatval($montant);
            }
        }
        // Calcul des totaux pour les Capitaux Propres
        if (!empty($_POST['CapitauxPropreMontant'])) {
            foreach ($_POST['CapitauxPropreMontant'] as $montant) {
                $totalCapitauxPropre += floatval($montant);
            }
        }
        // Calcul des totaux pour les Actif Courants
        if (!empty($_POST['actifCourantsMontant'])) {
            foreach ($_POST['actifCourantsMontant'] as $montant) {
                $totalActifCourants += floatval($montant);
            }
        }
        // Calcul des totaux pour les Passif Non Courants
        if (!empty($_POST['passifNoncourantsMontant'])) {
            foreach ($_POST['passifNoncourantsMontant'] as $montant) {
                $totalPassifNonCourants += floatval($montant);
            }
        }
        // Calcul des totaux pour les Passif Courants
        if (!empty($_POST['passifCourantsMontant'])) {
            foreach ($_POST['passifCourantsMontant'] as $montant) {
                $totalPassifCourants += floatval($montant);
            }
        }
        $totalActif = $totalActifCourants+$totalActifNonCourants;
        $totalPassif = $totalCapitauxPropre+$totalPassifCourants+$totalPassifNonCourants;



      // Vérifiez l'équilibre du bilan
       $erreurComparaisonBilan = "";
       if ($totalActif != $totalPassif) {
        $erreurComparaisonBilan = "Le bilan n'est pas équilibré, veuillez vérifier les données.";
       }else{

            // Insertion des Actif Non Courants
          if (!empty($_POST['actifNoncourantsMontant'])) {
           foreach ($_POST['actifNoncourantsMontant'] as $index => $montant) {
               $idOperation = $_POST['numeroCompteActifNoncourants'][$index];
               $libelle = $_POST['actifNoncourants'][$index];
               $montant = floatval($montant);
               $query = "INSERT INTO OPERATION (NOMRESULTAT, RESULTAT) VALUES ('$idOperation', '$montant')";
               mysqli_query($mysqli, $query);
           }
         }

          // Insertion des Capitaux Propres
          if (!empty($_POST['CapitauxPropreMontant'])) {
            foreach ($_POST['CapitauxPropreMontant'] as $index => $montant) {
                $idOperation = $_POST['numeroCompteCapitauxPropre'][$index];
                $libelle = $_POST['CapitauxPropre'][$index];
                $montant = floatval($montant);
                $query = "INSERT INTO OPERATION (NOMRESULTAT, RESULTAT) VALUES ('$idOperation', '$montant')";
                mysqli_query($mysqli, $query);
            }
         }

          // Insertion des Actif Courants 
          if(!empty($_POST['actifCourantsMontant'])){
            foreach($_POST['actifCourantsMontant'] as $index => $montant){
                $idOperation = $_POST['numeroCompteActifcourants'][$index];
                $libelle = $_POST['actifCourants'][$index];
                $montant = floatval($montant);
                $query = "INSERT INTO OPERATION (NOMRESULTAT, RESULTAT) VALUES ('$idOperation', '$montant')";
                mysqli_query($mysqli, $query);
            }
          }

          // Insertion des Passif Non Courants 
          if(!empty($_POST['passifNoncourantsMontant'])){
            foreach($_POST['passifNoncourantsMontant'] as $index => $montant){
                $idOperation = $_POST['numeroComptePassifNoncourants'][$index];
                $libelle = $_POST['passifNoncourants'][$index];
                $montant = floatval($montant);
                $query = "INSERT INTO OPERATION (NOMRESULTAT, RESULTAT) VALUES ('$idOperation', '$montant')";
                mysqli_query($mysqli, $query);
            }
          }

           // Insertion des Passif Courants 
           if(!empty($_POST['passifCourantsMontant'])){
               foreach($_POST['passifCourantsMontant'] as $index => $montant){
               $idOperation = $_POST['numeroComptePassifcourants'][$index];
               $libelle = $_POST['passifCourants'][$index];
               $montant = floatval($montant);
               $query = "INSERT INTO OPERATION (NOMRESULTAT, RESULTAT) VALUES ('$idOperation', '$montant')";
               mysqli_query($mysqli, $query);
            }
           }

           // Insertion du total des actifs Non courants
           $queryActifNonCourants = "INSERT INTO operation (NOMRESULTAT, RESULTAT) VALUES ('Total actif non courants',$totalActifNonCourants)";
           mysqli_query($mysqli,$queryActifNonCourants);
           // Insertion du total des actifs courants 
           $queryActifCourants = "INSERT INTO operation (NOMRESULTAT, RESULTAT) VALUES ('Total actif courants',$totalActifCourants)";
           mysqli_query($mysqli,$queryActifCourants);
           // Insertion du total des actifs
           $queryActif = "INSERT INTO operation (NOMRESULTAT, RESULTAT) VALUES ('Total actif ',$totalActif)";
           mysqli_query($mysqli,$queryActif);
           // Insertion du total des capitaux propres
           $queryCapitauxPropre = "INSERT INTO operation (NOMRESULTAT, RESULTAT) VALUES ('Total capitaux propre ',$totalCapitauxPropre)";
           mysqli_query($mysqli,$queryCapitauxPropre);
           // Insertion du total des passifs Non courants
           $queryPassifsNonCourants = "INSERT INTO operation (NOMRESULTAT, RESULTAT) VALUES ('Total passifs non courants ',$totalPassifNonCourants)";
           mysqli_query($mysqli,$queryPassifsNonCourants);
           // Insertion du total des passifs courants 
           $queryPassifsCourants = "INSERT INTO operation (NOMRESULTAT, RESULTAT) VALUES ('Total passifs courants ',$totalPassifCourants)";
           mysqli_query($mysqli,$queryPassifsCourants);
           // Inserion du total des passifs 
           $queryPassifs = "INSERT INTO operation (NOMRESULTAT, RESULTAT) VALUES ('Total passifs ',$totalPassif)";
           mysqli_query($mysqli,$queryPassifs);


        }
    
    }

    // affichage ratio de gestion 
    if(isset($_POST['AfficherRatioGestion']))
    {
        // recuperation de la valeur de la vente 
        $recuperationVente = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'vente marchandise'";
        $resultatVente = mysqli_query($conn,$recuperationVente);
        $VT = mysqli_fetch_assoc($resultatVente);
        // recuperation de valeur des stocks
        $recuperationStockMP = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '31'";
        $resultatStockMP = mysqli_query($conn,$recuperationStockMP);
        $MP = mysqli_fetch_assoc($resultatStockMP);

        $recuperationStockPC = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '32'";
        $resultatStockPC = mysqli_query($conn,$recuperationStockPC);
        $PC = mysqli_fetch_assoc($resultatStockPC);

        $recuperationStockPF = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '33'";
        $resultatStockPF = mysqli_query($conn,$recuperationStockPF);
        $PF = mysqli_fetch_assoc($resultatStockPF);

        $recuperationStockMS = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '34'";
        $resultatStockMS = mysqli_query($conn,$recuperationStockMS);
        $MS = mysqli_fetch_assoc($resultatStockMS);

        // recuparation de la montant du compte créances
        $recuperationClientsVenteBien = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '411'";
        $resultatClientsVenteBien = mysqli_query($conn,$recuperationClientsVenteBien);
        $clientsVenteBien = mysqli_fetch_assoc($resultatClientsVenteBien);

        $recuperationClientsEffets = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '413'";
        $resultatClientsEffets = mysqli_query($conn,$recuperationClientsEffets);
        $clientsEffets = mysqli_fetch_assoc($resultatClientsEffets);

        $recuperationClientsDouteuses = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '414'";
        $resultatClientsDouteuses = mysqli_query($conn,$recuperationClientsDouteuses);
        $clientsDouteuses = mysqli_fetch_assoc($resultatClientsDouteuses);

        // recuperation de la valeur du total des passifs Non Courants 
        $recuperationPassifNonCourants = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total passifs non courants'";
        $resultatPassifsfNC = mysqli_query($conn,$recuperationPassifNonCourants);
        $passifsNC = mysqli_fetch_assoc($resultatPassifsfNC);

        // recuperation de la valeur du total des passifs Courants 
        $recuperationPassifsCourants = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total passifs courants'";
        $resultatPassifC = mysqli_query($conn,$recuperationPassifsCourants);
        $passifC = mysqli_fetch_assoc($resultatPassifC);

        // recuperation des achats consomées 
        $recuperationAchatConsommer = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'achats consommer'";
        $resultatAchatConsommer = mysqli_query($conn,$recuperationAchatConsommer);
        $achatConso = mysqli_fetch_assoc($resultatAchatConsommer);

        // recuperation du total des actifs non courants 
        $recuperationActifNonCourants = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total actif non courants'";
        $resultatActifNonCourants = mysqli_query($conn,$recuperationActifNonCourants);
        $actifNC = mysqli_fetch_assoc($resultatActifNonCourants);

        // recuperation de la valeur du totals des actifs
        $recuperationTotalActifs =  "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total actif'";
        $resultatAC = mysqli_query($conn,$recuperationTotalActifs);
        $TotalActif = mysqli_fetch_assoc($resultatAC);

        // recuperation de la valeur de la sous-traintance 
        $recuperationSousTraintance = "SELECT EXPRESSIONFORMULE FROM formule WHERE NOMFORMULE = 'service exterieur' ";
        $resultatSousTraintance = mysqli_query($conn,$recuperationSousTraintance);
        $St = mysqli_fetch_assoc($resultatSousTraintance);

        $stockFinal = (float)$MP['RESULTAT']+(float)$PC['RESULTAT']+(float)$PF['RESULTAT']+(float)$MS['RESULTAT'];
        $ventes = (float)$VT['RESULTAT'];
        $stockMoyen = ($stockFinal/2);
        $detteTotal = (float)$passifsNC['RESULTAT'] + (float)$passifC['RESULTAT'];
        $achatConsommer = (float)$achatConso['RESULTAT'];
        $totalActifNC = (float)$actifNC['RESULTAT'];
        $actifTotal = (float)$TotalActif['RESULTAT'];
        $créances = (float)$clientsVenteBien['RESULTAT']+(float)$clientsEffets['RESULTAT']+(float)$clientsDouteuses['RESULTAT'];
        $sousTraintance = (float)$St['RESULTAT'];


        // calcul du Rotation produits finis
        $Rpf = calculRatioDuSIG('RotationProduitFinis','Vente','StockMoyen',$ventes,$stockMoyen);
        // calcul du Délai moyen de recouvrement des comptes clients
        $DMRCC = calculRatioDuSIG('DelaiMoyenRecouvrementCompteClient','(Creance*360)','Vente',($créances*360),$ventes);
        // calcul du Délai moyen de règlement fournisseurs
        $DMRF = calculRatioDuSIG('DelaiMoyenReglementFournisseurs','(Dettes*360)','(Achats+SousTraitances)',($detteTotal*360),($ventes+$sousTraintance));
        // calcul de Rotation matières premières 
        $Rmat = calculRatioDuSIG('RotationMatieresPremiere','AchatsConsommes','StocksMoyens',$achatConsommer,$stockMoyen);
        // calcul de Rentabilité immobilisation 
        $Rimmo = calculRatioDuSIG('RentabiliteImmobilisation','Ventes','Immobilisations',$ventes,$totalActifNC);
        // calcul Rentabilité actif
        $Ractif = calculRatioDuSIG('RentabiliteActif','Ventes','ActifTotal',$ventes,$actifTotal);

        $recuperationID = "SELECT IDOPERATION FROM operation WHERE NOMRESULTAT ='Total passifs'";
        $resultatID = mysqli_query($conn,$recuperationID);
        $ID = mysqli_fetch_assoc($resultatID);

        $id = (int)$ID['IDOPERATION'];

        $insertion = "INSERT INTO effectuer (IDUTILISATEUR,IDOPERATION) value(1,$id)";
        mysqli_query($conn,$insertion);

    }
    // affichage ratio de solvabilité
    if(isset($_POST['AffichageRatioSolvabiliter']))
    {
        // recuperation du total des actifs courants 
        $recuperationActifCourants = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total actif courants'";
        $resultatActifCourants = mysqli_query($conn,$recuperationActifCourants);
        $actifC = mysqli_fetch_assoc($resultatActifCourants);
        // recuperation du total des passifs courants 
        $recuperationPassifsCourants = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total passifs courants'";
        $resultatPassifC = mysqli_query($conn,$recuperationPassifsCourants);
        $passifC = mysqli_fetch_assoc($resultatPassifC);
        // recuparation de la montant du compte tresorerie
        $recuperationTresorerie = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '53'";
        $resultatTresorerie = mysqli_query($conn,$recuperationTresorerie);
        $tr = mysqli_fetch_assoc($resultatTresorerie);
        // recuperation de valeur des stocks
        $recuperationStockMP = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '31'";
        $resultatStockMP = mysqli_query($conn,$recuperationStockMP);
        $MP = mysqli_fetch_assoc($resultatStockMP);
        
        $recuperationStockPC = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '32'";
        $resultatStockPC = mysqli_query($conn,$recuperationStockPC);
        $PC = mysqli_fetch_assoc($resultatStockPC);
        
        $recuperationStockPF = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '33'";
        $resultatStockPF = mysqli_query($conn,$recuperationStockPF);
        $PF = mysqli_fetch_assoc($resultatStockPF);
        
        $recuperationStockMS = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '34'";
        $resultatStockMS = mysqli_query($conn,$recuperationStockMS);
        $MS = mysqli_fetch_assoc($resultatStockMS);


        $totalActifC = (float)$actifC['RESULTAT'];
        $totalPassifC = (float)$passifC['RESULTAT'];
        $tresorerie = (float)$tr['RESULTAT'];
        $stocks = (float)$MP['RESULTAT']+(float)$PC['RESULTAT']+(float)$PF['RESULTAT']+(float)$MS['RESULTAT'];

        // calcul du Ratio de liquidité général
        $Rlg = calculRatioDuSIG('RatioLiquiditeGeneral','ActifCT','PassifCT',$totalActifC,$totalPassifC);
        // calcul du Ratio de liquidité réduite 
        $Rlr = calculRatioDuSIG('RatioLiquiditeReduite','(ActifCT-Stocks)','PassifCT',($totalActifC-$stocks), $totalPassifC);
        // calcul du Ratio de liquidité immédiate
        $Rim = calculRatioDuSIG('RatioLiquiditeImmediate','Tresorerie','PassifCT',$tresorerie,$totalPassifC);

    }
    // affichage ratio d'endettemnet 
    if(isset($_POST['AffichageRatioEndettement']))
    {
        // recuperation de la valeur du total des passifs Non Courants 
        $recuperationPassifNonCourants = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total passifs non courants'";
        $resultatPassifsfNC = mysqli_query($conn,$recuperationPassifNonCourants);
        $passifsNC = mysqli_fetch_assoc($resultatPassifsfNC);
        // recuperation de la valeur du total des passifs Courants 
        $recuperationPassifsCourants = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total passifs courants'";
        $resultatPassifC = mysqli_query($conn,$recuperationPassifsCourants);
        $passifC = mysqli_fetch_assoc($resultatPassifC);
        // recuperation de la valeur du totals des actifs
        $recuperationTotalActifs =  "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total actif'";
        $resultatAC = mysqli_query($conn,$recuperationTotalActifs);
        $TotalActif = mysqli_fetch_assoc($resultatAC);
        // recuperation du capitaux propre 
        $recuperationCapitauxPropre = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '101'";
        $resultatCP = mysqli_query($conn,$recuperationCapitauxPropre);
        $capitauxPropre = mysqli_fetch_assoc($resultatCP);




        $detteTotal = (float)$passifsNC['RESULTAT'] + (float)$passifC['RESULTAT'];
        $actifTotal = (float)$TotalActif['RESULTAT'];
        $capitale = (float)$capitauxPropre['RESULTAT'];
        $totalPassifsNC = (float)$passifsNC['RESULTAT'];

        // calcul du Degré d'endettement
        $De = calculRatioDuSIG('DegreeEndetement','DetteTotal','ActifTotal',$detteTotal,$actifTotal);
        // calcul Ratio de l'autonomie financière
        $Raf = calculRatioDuSIG('RatioAutonomieFinanciere','CapitauxPropres','DetteTotale',$capitale,$detteTotal);
        // calcul Ratio d'endettement à terme
        $Ret = calculRatioDuSIG('RatioEndettementTerme','CapitauxPropres','DetteLT',$capitale,$totalPassifsNC);


    }
    // affichage ratio de rentabilité
    if(isset($_POST['AffichageRatioRentabiliter']))
    {
        // recuperation de resultat de l'exercice 
        $recuperationResultatExercice = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'resultat exercice'";
        $resultatResExercice = mysqli_query($conn,$recuperationResultatExercice);
        $resExercice = mysqli_fetch_assoc($resultatResExercice);

        // recuperation de la valeur du totals des actifs
        $recuperationTotalActifs =  "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = 'Total actif'";
        $resultatAC = mysqli_query($conn,$recuperationTotalActifs);
        $TotalActif = mysqli_fetch_assoc($resultatAC);

        // recuperation du capitaux propre 
        $recuperationCapitauxPropre = "SELECT RESULTAT FROM operation WHERE NOMRESULTAT = '101'";
        $resultatCP = mysqli_query($conn,$recuperationCapitauxPropre);
        $capitauxPropre = mysqli_fetch_assoc($resultatCP);


        $resultatExercice = (float)$resExercice['RESULTAT'];
        $actifTotal = (float)$TotalActif['RESULTAT'];
        $capitale = (float)$capitauxPropre['RESULTAT'];


        // calcul Return on Investment (ROI)
        $ROI = calculRatioDuSIG('ReturnOnInvestment','Benefices','Actifs',$resultatExercice,$actifTotal);
        // calcul Return on equity (ROE)
        $ROE = calculRatioDuSIG('ReturnOnEquity','Benefices','CapitauxPropres',$resultatExercice,$capitale);
    }


  mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="interfaceUtilisateur.css">
        <title>Résultat</title>
    </head>
    <body>
        <h3 class="bienvenue"> <?php echo "Bienvenue  ".$nomUtilisateur;?> </br> </h3>
        <form action="" method="post">
        <aside class="donnerEntrer">
            <div class="compteResultat">
                <h3>COMPTE DE RESULTAT</h3>
                <table border>
                    <thead>
                        <tr>
                            <th>Numero de Compte</th>
                            <th>Compte de Résultat par nature</th>
                            <th>N</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>70</td>
                            <td>Chiffre d'affaire</td>
                            <td><input type="text" name="CA"></td>
                        </tr> 
                        <tr>
                            <td>71</td>
                            <td>Production stockée</td>
                            <td><input type="text" name="PS"></td>
                        </tr>
                        <tr>
                            <td>72</td>
                            <td>Production immobilisée</td>
                            <td><input type="text" name="PI"></td>
                        </tr>
                        <tr>
                            <td>707</td>
                            <td>Vente des marchandises</td>
                            <td><input type="text" name="VDM"></td>
                        </tr>
                        <tr>
                            <td>607</td>
                            <td>Coût d'achat des marchandises vendues</td>
                            <td><input type="text" name="CAMV"></td>
                        </tr>
                        <tr>
                            <td>60</td>
                            <td>Achats consommés</td>
                            <td><input type="text" name="AC"></td>
                        </tr>
                        <tr>
                            <td>61/62</td>
                            <td>Services extérieurs et autres consommations</td>
                            <td><input type="text" name="SEAC"></td>
                        </tr>
                        <tr>
                            <td>74</td>
                            <td>Subvention d'exploitation</td>
                            <td><input type="text" name="SE"></td>
                        </tr>
                        <tr>
                            <td>64</td>
                            <td>Charges de personnel</td>
                            <td><input type="text" name="CP"></td>
                        </tr>
                        <tr>
                            <td>63</td>
                            <td>Impôts, taxes et versements assimilés</td>
                            <td><input type="text" name="IPTVA"></td>
                        </tr>
                        <tr>
                            <td>75</td>
                            <td>Autres produits opérationnels</td>
                            <td><input type="text" name="APO"></td>
                        </tr>
                        <tr>
                            <td>65</td>
                            <td>Autres charges opérationnelles</td>
                            <td><input type="text" name="ACP"></td>
                        </tr>
                        <tr>
                            <td>78</td>
                            <td>Reprise d'exploitation</td>
                            <td><input type="text" name="RE"></td>
                        </tr>
                        <tr>
                            <td>68</td>
                            <td>Dotations aux amortissements, aux provisions et pertes de valeur</td>
                            <td><input type="text" name="DAPPV"></td>
                        </tr>
                        <tr>
                            <td>76</td>
                            <td>Produits financiers</td>
                            <td><input type="text" name="PF"></td>
                        </tr>
                        <tr>
                            <td>66</td>
                            <td>Charges financières</td>
                            <td><input type="text" name="CF"></td>
                        </tr>
                        <tr>
                            <td>695/698</td>
                            <td>Impôts exigibles sur résultats</td>
                            <td><input type="text" name="IER"></td>
                        </tr>
                        <tr>
                            <td>692/693</td>
                            <td>Impôts différés (variations)</td>
                            <td><input type="text" name="IPD"></td>
                        </tr>
                        <tr>
                            <td>77</td>
                            <td>Éléments extraordinaires (produits)</td>
                            <td><input type="text" name="EEP"></td>
                        </tr>
                        <tr>
                            <td>67</td>
                            <td>Éléments extraordinaires (charges)</td>
                            <td><input type="text" name="EEC"></td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" value="Valider Le Compte de Résultat" name="calculCR">
            </div>
        </aside>
    
        <aside class="donnerEntrer">
            <div class="bilanComptable">
                <h3>BILAN COMPTABLE</h3>
                 <table border="">
                <thead>
                    <tr> 
                        <td >ACTIF</td>
                        <td >PASSIF</td>
                    </tr>
                </thead>
    
                <tbody>
                    <tr>
                        <td>
                            <div id="div1">
                                <table id="actifNonCourants" >
                                    <thead>
                                        <tr>
                                            <th colspan="3">ACTIF NON COURANT</th>
                                            <td><button class="btn" type="button" onclick="addactifNonCourants()">Ajouter une ligne</button> </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td>Numéro de Compte</td>
                                            <td>Libellé</td>
                                            <td>Montant</td>
                                            <td>Action</td>
                                         </tr>
                                    </tbody>
                                </table>
                             </div>
                     
                        </td>
    
                        <td>
                            <div id="div3">
                                <table id="capitauxPropre" >
                                    <thead>
                                        <tr>
                                            <th colspan="3">CAPITAUX PROPRE</th>
                                            <td><button class="btn" type="button" onclick="addCapitauxPropre()">Ajouter une ligne</button> </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td>Numéro de Compte</td>
                                            <td>Libellé</td>
                                            <td>Montant</td>
                                            <td>Action</td>
                                         </tr>
                                    </tbody>
                                </table>
                             </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            <div id="div2">
                                <table id="actifCourants" >
                                    <thead>
                                        <tr>
                                            <th colspan="3">ACTIF  COURANT</th>
                                            <td><button class="btn" type="button" onclick="addActifCourants()">Ajouter une ligne</button> </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td>Numéro de Compte</td>
                                            <td>Libellé</td>
                                            <td>Montant</td>
                                            <td>Action</td>
                                         </tr>
                                    </tbody>
                                </table>
                             </div>
                        </td>
    
                        <td >
                            <div id="div4">
                                <table  id="passifNonCourants" >
                                    <thead>
                                        <tr>
                                            <th colspan="3">PASSIF NON COURANTS</th>
                                            <td><button class="btn" type="button" onclick="addpassifNonCourants()">Ajouter une ligne</button> </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td>Numéro de Compte</td>
                                            <td>Libellé</td>
                                            <td>Montant</td>
                                            <td>Action</td>
                                         </tr>
                                    </tbody>
                                </table>
                             </div>
                    
                        </td>
    
                        
                    </tr>
    
                    <tr>
                        <td>
                            <div id="div5">
                                <table id="passifCourants" >
                                    <thead>
                                        <tr>
                                            <th colspan="3">PASSIF COURANTS</th>
                                            <td><button class="btn" type="button" onclick="addpassifCourants()">Ajouter une ligne</button> </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td>Numéro de Compte</td>
                                            <td>Libellé</td>
                                            <td>Montant</td>
                                            <td>Action</td>
                                         </tr>
                                    </tbody>
                                </table>
                             </div>
                        </td>
                    </tr>
    
                    <tr>
                        <td>Total actif non courants </br>
                            <input type="text" name="" id="" value=".<?php echo $totalActifNonCourants;  ?>." > </td>
                        <td>Total capitaux Propre </br>
                            <input type="text" name="" id="" value= ".<?php echo $totalCapitauxPropre;  ?>." >
                        </td>
                     </tr>
    
                     <tr>
                        <td rowspan="2">Total actif  courants </br>
                            <input type="text" name="" id="" value= ".<?php echo $totalActifCourants;  ?>." > </td>
                        <td>Total passif non courants </br>
                            <input type="text" name="" id="" value= ".<?php echo $totalPassifNonCourants;  ?>." >
                        </td>
                     </tr>
    
                     <tr>
                        <td>Total passif  courants </br>
                            <input type="text" name="" id="" value= ".<?php echo $totalPassifCourants;  ?>." >
                        </td>
                     </tr>
    
                     <tr>
                        <td>Total actif  </br>
                            <input type="text" name="" id="" value= ".
                            <?php 
                            if($totalActif == $totalPassif){
                             echo ($totalActifCourants+$totalActifNonCourants);
                            } 
                            ?>." > </td>
                        <td>Total passif  </br>
                            <input type="text" name="" id="" value= ".
                            <?php if($totalActif == $totalPassif){ 
                             echo ($totalCapitauxPropre+$totalPassifCourants+$totalPassifNonCourants);
                            }
                            ?>.">
                        </td>
                     </tr>
                </tbody>
                <?php 
                  if(!empty($erreurComparaisonBilan))
                  {
                    echo $erreurComparaisonBilan;
                  }
                ?>
             </table>
    
                <input type="submit" value="Valider le Bilan Comptable" name="calculBilan" class="validationBC">            
            </div>
        </aside>
        
        <hr>
    
        <aside>
            <div class="SIG">
                 <h3>SOLDE INTERMEDIAIRE DES GESTION</h3>
                   <table border>
                     <thead>
                       <tr>
                         <th>Libellé</th>
                         <th>MONTANT N</th>
                       </tr>
                     </thead>
        
                     <tbody>
                      <tr>
                        <td>production de l'exercice</td>
                        <td> <?php echo number_format($ProductionExercice,2,',',' '); ?> </td>
                      </tr>
        
                      <tr>
                        <td>marge commerciale</td>
                        <td><?php echo number_format($MargeCommerciale,2,',',' '); ?> </td> 
                      </tr>
        
                      <tr>
                        <td>consommations de l'exercice</td>
                        <td> <?php echo number_format($consommationExercice,2,',',' '); ?> </td>
                      </tr>
        
                      <tr>
                        <td>valeur ajouter</td>
                        <td> <?php echo number_format($valeurAjouter,2,',',' ') ; ?> </td>
                      </tr>
        
                      <tr>
                        <td>excedent brut d'exploitation</td>
                        <td> <?php echo number_format($ExcedentBrutExploitation,2,',',' '); ?> </td>
                      </tr>
        
                      <tr>
                        <td>resultat d'exploitation</td>
                        <td> <?php echo number_format($ResultatExploitation,2,',',' '); ?> </td>
                      </tr>
        
                      <tr>
                        <td>resultat courants avant impôts</td>
                        <td> <?php echo number_format($ResultatCourantAvantImpots,2,',',' '); ?> </td>
                      </tr>
        
                      <tr>
                        <td>resultas exceptionnels</td>
                        <td> <?php echo number_format($resultatExeptionnels,2,',',' '); ?> </td>
                      </tr>
        
                      <tr>
                        <td>resulta de l'exercice</td>
                        <td> <?php echo number_format($ResultatExercice ,2,',',' '); ?></td>
                      </tr>
        
                     </tbody>
                   </table>    
                   <input type="submit" value="Afficher SIG" name="affchageSIG">
            </div>
        </aside>
    
        <hr>
    
        <aside>
            <div class="ratioSIG">
                <h3> RATIO A PARTIR DU SIG </h3>
                <table border="">
                    <thead>
                        <th>Libellé</th>
                        <th>Taux en %</th>
                    </thead>
    
                    <tbody>
                        <tr>
                            <td>Taux de variation chiffre d"affaire </td>
                            <td> <?php echo number_format($tauxVariationCA,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Taux de marge commerciale </td>
                            <td> <?php echo number_format($tauxMargeCommerciale,2,',',' '); ?></td>
                        </tr>
    
                        <tr>
                            <td>Taux de marque commercial </td>
                            <td> <?php echo number_format($tauxMarqueCommerciale,2,',',' '); ?> </td>
                        </tr>

                        <tr>
                            <td>Taux de matière première </td>
                            <td> <?php echo number_format($tauxMatierePremiere,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Taux de charge externes </td>
                            <td> <?php echo number_format($tauxChargeExternes,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Taux de valeur ajoutée </td>
                            <td> <?php echo number_format($tauxValeurAjouteur,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Taux de charges du personnel </td>
                            <td> <?php echo number_format($tauxChargePersonnels,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Taux d"EBE </td>
                            <td> <?php echo number_format($tauxEBE,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Taux de resultat comptable avant impôt </td>
                            <td> <?php echo number_format($tauxRCAI,2,',',' '); ?> </td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" value="Afficher les ratios du SIG" name="ratioSIG">
            </div>
    
            <div class="ratioGestion">
                <h3>RATIO DE GESTION</h3>
                <table border="">
                    <thead>
                        <tr>
                            <th>Libellé</th>
                            <th>Taux en %</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        <tr>
                            <td>Rotation produits finis</td>
                            <td> <?php echo number_format($Rpf,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Délai moyen de recouvrement des comptes clients</td>
                            <td> <?php echo number_format($DMRCC,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Délai moyen de règlement fournisseurs</td>
                            <td> <?php echo number_format($DMRF,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Rotation matières premières</td>
                            <td> <?php echo number_format($Rmat,2,',',''); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Rentabilité immobilisation</td>
                            <td> <?php echo number_format($Rimmo,2,',',' '); ?> </td>
                        </tr>
    
                        <tr>
                            <td>Rentabilité actif</td>
                            <td> <?php echo number_format($Ractif,2,',',' '); ?> </td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" value="Afficher les ratios de gestion" name="AfficherRatioGestion"> 
            </div>
        </aside>
     
        <hr>
    
        <aside>
            <div class="ratioSolvabiliter">
                   <h3>RATIO DE SOLABILITÉ</h3>
                   <table border="">
                       <thead>
                           <th>Libellé</th>
                           <th>Taux en %</th>
                       </thead>
           
                       <tbody>
                           <tr>
                             <td>Ratio de liquidité général</td> 
                             <td> <?php echo number_format($Rlg,2,',',' '); 0?> </td>
                           </tr>
           
                           <tr>
                             <td>Ratio de liquidité réduite</td> 
                             <td> <?php echo number_format($Rlr,2,',',' '); ?> </td>
                           </tr>
           
                           <tr>
                             <td>Ratio de liquidité immédiate</td> 
                             <td> <?php echo number_format($Rim,2,',',' '); ?> </td>
                           </tr>
           
                       </tbody>
                   </table>
                   <input type="submit" value="Afficher les ratios de solvabilité" name="AffichageRatioSolvabiliter">
            </div>
        
            <div class="ratioEndettement">
                <h3>RATIO D'ENDETTEMENT</h3>
                <table border="">
                    <thead>
                        <th>Libellé</th>
                        <th>Taux en %</th>
                    </thead>
        
                    <tbody>
                        <tr>
                            <td>Degré d'endettement</td>
                            <td> <?php echo number_format($De,2,',',''); ?> </td>
                        </tr>
        
                        <tr>
                            <td>Ratio de l'autonomie financière</td>
                            <td> <?php echo number_format($Raf,2,',',''); ?> </td>
                        </tr>
        
                        <tr>
                            <td>Degré d'endettement à terme</td>
                            <td> <?php echo number_format($Ret,2,',',''); ?> </td>
                        </tr>
                    </tbody>
                </table> 
                <input type="submit" value="Afficher les ratios d'endettement" name="AffichageRatioEndettement">
            </div>
            
                         
            <div class="ratioRentabiliter">
                <h3>RATIO DE RENTABILITE</h3>
                <table border="">
                    <thead>
                        <th>Libellé</th>
                        <th>Taux en %</th>
                    </thead>
        
                    <tbody>
                        <tr>
                            <td>Return on Investment</td>
                            <td> <?php echo number_format($ROI,2,',',' '); ?> </td>
                        </tr>
        
                        <tr>
                            <td>Return on equity</td>
                            <td> <?php echo number_format($ROE,2,',',' '); ?> </td>
                        </tr>
                    </tbody>
                </table>  
                <input type="submit" value="Afficher les ratios de  rentabilité" name="AffichageRatioRentabiliter">
          </div>
        </aside>
        </form>
    </body>
    
    <footer>
            <button  id="top"> <img src="icône/icons8_Up_Squared_64px.png" alt=""> </button>
            <button  id="Acceuille"> <img src="icône/icons8_Back_Arrow_64px.png" alt=""></button>
            <button  id="Deconnexion"> <img src="icône/icons8_Shutdown_64px.png" alt=""> </button>
    </footer>
    
    <script src="interfaceUtilisateur.js"></script>
</html>
