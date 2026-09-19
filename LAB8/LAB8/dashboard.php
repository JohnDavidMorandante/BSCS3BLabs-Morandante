<?php 
session_start(); 

// FIX: If the session username is NOT set, kick them back to login
if (!isset($_SESSION['username'])) { 
    header("Location: lab8.php"); 
    exit();
} 
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Dashboard</title> 
</head> 
<body> 
    <h1>Welcome to the Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This is secure content only visible to logged-in users.</p>
    
    <p><a href="logout.php">Click here to Logout</a></p>
</body> 
</html>
