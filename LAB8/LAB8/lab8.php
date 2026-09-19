<?php 
session_start(); 

$defaultUsername = "JOHN123"; 
$defaultPassword = "123"; 
$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $username = $_POST["username"] ?? ''; 
    $password = $_POST["password"] ?? ''; 

    if ($defaultUsername === $username && $password === $defaultPassword) { 
        $_SESSION["username"] = $username; 
        header("Location: dashboard.php"); 
        exit(); 
    } else { 
        $message = "Invalid credentials"; 
    } 
}
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Login</title> 
</head> 
<body> 
    <h3>Login</h3> 
    
    <!-- Display error message if credentials fail -->
    <?php if(!empty($message)): ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action=""> 
        <label for="username">Enter your username</label> 
        <input type="text" id="username" name="username" required> 
        <br><br>
        <label for="password">Enter your password</label> 
        <input type="password" id="password" name="password" required> 
        <br><br>
        <button type="submit">Submit</button> 
    </form> 
        <p style="color:red">
            <?php echo $message; ?>
            <?php echo $password = "testing";
            
            
            
            
            ?>
        </p>

        echo "password hash: "
</body> 
</html>
