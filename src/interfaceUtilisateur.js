const acc = document.getElementById('Acceuille');
const dec = document.getElementById('Deconnexion');
const haut = document.getElementById('top');

acc.onclick = (event) =>
{
   console.log(event);
   window.location.href = "index.php";
};

dec.onclick = (event) =>
{
   console.log(event);
   window.location.href = "compte.php";
};
haut.onclick = (event) =>
{
   console.log(event);
   window.location.href = "interfaceUtilisateur.php";
};
/*-------------------------------------------------------------------------------------*/

// actif non courants 
function addactifNonCourants(){
    var newRow = document.createElement('tr');

    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);
    const cell4 = newRow.insertCell(3);

    cell1.innerHTML =  '<input type="number" name="numeroCompteActifNoncourants[]" /> ';
    cell2.innerHTML =  '<input type="text" name="actifNoncourants[]" /> ';
    cell3.innerHTML =  '<input type="number" name="actifNoncourantsMontant[]" />';
    cell4.innerHTML =  '<button class="btn" onclick="removeRowactifNonCourants(this)">Supprimer</button>';
    document.getElementById('actifNonCourants').appendChild(newRow);
}
function removeRowactifNonCourants(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

// actif courants
function addActifCourants(){
    var newRow = document.createElement('tr');

    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);
    const cell4 = newRow.insertCell(3);

    cell1.innerHTML =  '<input type="number" name="numeroCompteActifcourants[]" /> ';
    cell2.innerHTML =  '<input type="text" name="actifCourants[]" /> ';
    cell3.innerHTML =  '<input type="number" name="actifCourantsMontant[]" />';
    cell4.innerHTML =  '<button class="btn" onclick="removeRowActifCourants(this)">Supprimer</button>';
    document.getElementById('actifCourants').appendChild(newRow);
}
function removeRowActifCourants(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

// capitaux propre 
function addCapitauxPropre(){
    var newRow = document.createElement('tr');

    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);
    const cell4 = newRow.insertCell(3);

    cell1.innerHTML =  '<input type="number" name="numeroCompteCapitauxPropre[]" /> ';
    cell2.innerHTML =  '<input type="text" name="CapitauxPropre[]" /> ';
    cell3.innerHTML =  '<input type="number" name="CapitauxPropreMontant[]" />';
    cell4.innerHTML =  '<button class="btn" onclick="removeRowCapitauxPropre(this)">Supprimer</button>';
    document.getElementById('capitauxPropre').appendChild(newRow);
}
function removeRowCapitauxPropre(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

//passif non courants 

function addpassifNonCourants(){
    var newRow = document.createElement('tr');

    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);
    const cell4 = newRow.insertCell(3);

    cell1.innerHTML =  '<input type="number" name="numeroComptePassifNoncourants[]" /> ';
    cell2.innerHTML =  '<input type="text" name="passifNoncourants[]" />';
    cell3.innerHTML =  '<input type="number" name="passifNoncourantsMontant[]" />';
    cell4.innerHTML =  '<button class="btn" onclick="removeRowpassifNonCourants(this)">Supprimer</button>';
    document.getElementById('passifNonCourants').appendChild(newRow);
}
function removeRowpassifNonCourants(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

// passif courants 
function addpassifCourants(){
    var newRow = document.createElement('tr');

    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);
    const cell4 = newRow.insertCell(3);

    cell1.innerHTML =  '<input type="number" name="numeroComptePassifcourants[]" /> ';
    cell2.innerHTML =  '<input type="text" name="passifCourants[]" /> ';
    cell3.innerHTML =  '<input type="number" name="passifCourantsMontant[]" />';
    cell4.innerHTML =  '<button class="btn" onclick="removeRowpassifCourants(this)">Supprimer</button>';
    document.getElementById('passifCourants').appendChild(newRow);
}
function removeRowpassifCourants(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

/*------------------------------------------------------------------------------------------------*/

function addRow(){
    var newRow = document.createElement('tr');

    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);
    const cell4 = newRow.insertCell(3)
    const cell5 = newRow.insertCell(4)
    const cell6 = newRow.insertCell(5)
    const cell7 = newRow.insertCell(6)

    cell1.innerHTML =  '<input type="number" name="numeroCompte[]" /> ';
    cell2.innerHTML =  '<input type="text" name="libelleCompte[]" />';
    cell3.innerHTML =  '<input type="number" name="debit[]" />';
    cell4.innerHTML =  '<input type="number" name="credit[]" />';
    cell5.innerHTML =  '<input type="number" name="totalCredit[]" />';
    cell6.innerHTML =  '<input type="number" name="totalDebit[]" />';
    cell7.innerHTML =  '<button class="btn" onclick="removeRow(this)">Supprimer</button>';
    document.getElementById('balance').appendChild(newRow);
}
function removeRow(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
/*-----------------------------------------------------------------------*/
