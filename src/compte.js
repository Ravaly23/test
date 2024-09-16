//recuperation id fieldset
const adm  = document.getElementById('admin');
const gsU  = document.getElementById('user');
const compt = document.getElementById('compte');
const CreUser=document.getElementById('createU');

const erreur = document.getElementById('sec');

adm.hidden = true;
gsU.hidden = true;
compt.hidden = true;
CreUser.hidden=true;

//recuperation id bouttons
const btncreateU = document.getElementById('CreateAccount');
const btnUserG=document.getElementById('userG');
const btnuserAdmin=document.getElementById('userA');

btnuserAdmin.onclick = (event) =>
{
   console.log(event);
   compt.hidden = false;
   adm.hidden = false;
   CreUser.hidden=true;
   gsU.hidden=true;
   erreur.hidden = true;
};
btnUserG.onclick = (event) =>
{
   console.log(event);
   compt.hidden = false;
   gsU.hidden = false;
   adm.hidden=true;
   CreUser.hidden=true;
   erreur.hidden = true;
};
// btncreateU.onclick = (event) =>
// {
//    console.log(event);
//    compt.hidden = false;
//    CreUser.hidden=false;
//    gsU.hidden = true;
//    adm.hidden=true;
//    erreur.hidden = true;
// };



//submit 
const loginUser = document.getElementById('CreUserAc');

loginUser.onclick = (event) =>
{
   console.log(event);
   compt.hidden = false;
   gsU.hidden = false;
   CreUser.hidden=true;
   gsU.hidden=true;

}


