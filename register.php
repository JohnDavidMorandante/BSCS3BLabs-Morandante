<?php
include('db.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($username)) {
        $errors[] = "Username is required";
    } elseif (strlen($username) < 8) {
        $errors[] = "Username must be 8 characters or more";
    }

    // Check if username contains any whitespace
    if (preg_match('/\s/', $username)) {
        $errors[] = "Username must not have white space";
    }

    // FIXED: Changed 'name' to 'username' to match your table schema
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    
    // Safety check in case the prepare fails
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Username already exists";
    }
    $stmt->close();

    if ($password != $confirmPassword) {
        $errors[] = "Password did not match";
    }
    if (empty($password) || empty($confirmPassword)) {
        $errors[] = "Please provide a password";
    }

    $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\W_]).+$/';
    if (!preg_match($pattern, $password)) {
        $errors[] = "Password must contain lower, upper case and special characters";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be 8 or more characters long";
    }

    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        $stmt->bind_param("ss", $username, $passwordHash);
        
        if ($stmt->execute()) {
            echo "Registered Successfully";
        } else {
            $errors[] = "Registration failed: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
        <br><br>
        <label for="password">Password:</label>
        <input type="password" name="password">
        <br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password">
        <br><br>
        <button type="submit">Register</button>
    </form>
    <br><br>
    <a href="login.php">Login</a>
    <br><br>
    <?php
    foreach ($errors as $error) {
        echo "<span style='color:red;'>$error</span><br>";
    }
    ?>
</body>
</html>