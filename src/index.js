const bt   = document.getElementById('seConnecter');
const rj   = document.getElementById('rejoigner');
const CreUser = document.getElementById('createU');
const compt = document.getElementById('compte');

bt.onclick = (event) =>
{
   console.log(event);
   window.location.href = "compte.php";
};
 rj.onclick = (event) =>
 {
       console.log(event);
       window.location.href = "creerCompte.php";
       CreUser.hidden=false;
       compt.hidden = false;
 };
