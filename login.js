document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

 
    var formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            if (xhr.responseText.includes("Invalid email or password")) {
                alert(xhr.responseText);
            } else if (xhr.responseText.includes("No account found")) {
                alert(xhr.responseText); 
            } else {
                window.location.href = "Home.php"; 
            }
        } else {
            alert("An error occurred during the login process.");
        }
    };
    xhr.send(formData); 
});
