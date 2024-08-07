function validateDates() {
    var dateEmprunt = document.getElementById('dateEmprunt').value;
    var dateRetour = document.getElementById('dateRetour').value;
    
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