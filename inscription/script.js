document.getElementById('registrationForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas.');
        event.preventDefault(); // Empêche la soumission du formulaire
    }
});


function validateForm() {
    var nom = document.getElementById('inputField1').value;
    var prenom = document.getElementById('inputField2').value;
    var telephone = document.getElementById('inputField3').value;
    var adresse = document.getElementById('inputField4').value;
    var mail = document.getElementById('inputField5').value;
    var mot_de_passe = document.getElementById('inputField6').value;

    if (nom === "" || prenom === "" || telephone === "" || adresse === "" || mail === "" || mot_de_passe === "") {
        alert("Tous les champs doivent être remplis !");
        return false; // Empêche la soumission du formulaire
    }

    // Optionnel : Validation de l'email
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(mail)) {
        alert("Veuillez entrer une adresse email valide !");
        return false; // Empêche la soumission du formulaire
    }

    // Optionnel : Validation du numéro de téléphone
    var phonePattern = /^\+221 \d{2} \d{3} \d{2} \d{2}$/;
    if (!phonePattern.test(telephone)) {
        alert("Veuillez entrer un numéro de téléphone valide au format +221 XX XXX XX XX !");
        return false; // Empêche la soumission du formulaire
    }

    return true; // Permet la soumission du formulaire
}
