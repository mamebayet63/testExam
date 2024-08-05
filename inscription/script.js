document.getElementById('registrationForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas.');
        event.preventDefault(); // Empêche la soumission du formulaire
    }
});
