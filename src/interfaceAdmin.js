// récuperation des submit sur nav 
const gestionUtilisateur = document.getElementById('GestionUtilisateur');
const gestionFormule     = document.getElementById('GestionFormule');
const acceuille          = document.getElementById('Acceuille');
const deconnexion        = document.getElementById('Deconnexion');

const gestionU = document.getElementById('GUtilisateur');

const formule = document.getElementById('gestionFormule');
formule.hidden = true;

gestionUtilisateur.onclick = (event)=>{
    console.log(event);
    gestionU.hidden = false;
    formule.hidden = true;
}

gestionFormule.onclick = (event)=>{
    console.log(event);
    formule.hidden = false;
    gestionU.hidden = true;
}

acceuille.onclick = (event)=>{
    console.log(event);
    window.location.href = "index.php";
}

deconnexion.onclick = (event)=>{
    console.log(event);
    window.location.href = "compte.php";
}
