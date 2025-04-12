document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

 
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

 
    var formData = new FormData();
    formData.append("name", name);
    formData.append("email", email);
    formData.append("password", password);

    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "signup.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            if (xhr.responseText.includes("Error") || xhr.responseText.includes("Email already registered")) {
                alert(xhr.responseText); 
            } else {
                window.location.href = "Home.php"; 
            }
        } else {
            alert("An error occurred during the sign-up process.");
        }
    };
    xhr.send(formData); 
});
