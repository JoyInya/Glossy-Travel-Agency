<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

       
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "glossy travel agency"; 

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO subscriptions (email) VALUES (?)");
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
               
                echo "Thank you for subscribing! We will send you updates soon.";

               
                header("Refresh: 3; url=Home.php");
                exit(); 
            } else {
                echo "Sorry, something went wrong. Please try again later.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Please enter a valid email address.";
        }
    } else {
        echo "Please enter a valid email address.";
    }
}
?>
