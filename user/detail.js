function validateDates() {
    var dateEmprunt = document.getElementById('dateEmprunt').value;
    var dateRetour = document.getElementById('dateRetour').value;
    var today = new Date();
    today.setHours(0, 0, 0, 0); // Mettre à zéro les heures, minutes, secondes et millisecondes pour comparer uniquement les dates

    if (new Date(dateEmprunt) < today) {
        alert("La date d'emprunt doit être supérieure ou égale à la date du jour.");
        return false;
    }

    if (new Date(dateRetour) <= new Date(dateEmprunt)) {
        alert("La date de retour doit être supérieure à la date d'emprunt.");
        return false;
    }

    var maxReturnDate = new Date(dateEmprunt);
    maxReturnDate.setDate(maxReturnDate.getDate() + 14); // Ajouter 14 jours

    if (new Date(dateRetour) > maxReturnDate) {
        alert("La durée maximale d'emprunt est de deux semaines.");
        return false;
    }

    return true;
}
