<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success = "";
$username = $_SESSION['username'];

// Fetch current user data securely
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);

    // Validation
    if (empty($address)) {
        $errors[] = "Address is required";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (!preg_match('/^[0-9\+\-\s\(\)]+$/', $phone)) {
        // Optional basic format check for phone numbers
        $errors[] = "Invalid phone number format";
    }

    if (empty($gender)) {
        $errors[] = "Please select a gender";
    }

    if (empty($errors)) {
        // Updated query to include phone and gender
        $updateStmt = $conn->prepare("UPDATE users SET address = ?, phone = ?, gender = ? WHERE username = ?");
        $updateStmt->bind_param("ssss", $address, $phone, $gender, $username);
        
        if ($updateStmt->execute()) {
            $success = "Profile updated successfully";
            // Refresh user array data to reflect changes instantly
            $user['address'] = $address;
            $user['phone'] = $phone;
            $user['gender'] = $gender;
        } else {
            $errors[] = "Failed to update profile: " . $conn->error;
        }
        $updateStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h3>Edit Profile</h3>
    <form method="POST">
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
        <br><br>
        
        <label for="phone">Phone #:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
        <br><br>

        <label for="gender">Gender:</label>
        <select name="gender">
            <option value="">-- Select Gender --</option>
            <option value="Male" <?php echo (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo (isset($user['gender']) && $user['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
        </select>
        <br><br>

        <button type="submit">Update</button>
        <br><br>
    </form>
    <br><br>
    
    <p><strong>Current Address:</strong> <?php echo htmlspecialchars($user['address'] ?? 'None'); ?></p>
    <p><strong>Current Phone #:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'None'); ?></p>
    <p><strong>Current Gender:</strong> <?php echo htmlspecialchars($user['gender'] ?? 'None'); ?></p>
    
    <a href="dashboard.php">Back to Dashboard</a>
    <br><br>
    <?php
    if ($success) {
        echo "<span style='color:green;'>$success</span><br>";
    }

    foreach ($errors as $error) {
        echo "<span style='color:red;'>$error</span><br>";
    }
    ?>
</body>
</html>