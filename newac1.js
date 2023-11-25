function submitForm() {
    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let pancard = document.getElementById("pancardno").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm-password").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    // Submit form data to server
    alert(`Username: ${username}\nEmail: ${email}\nPassword: ${password}\nPan Card : ${pancard}`);
    return true;
}