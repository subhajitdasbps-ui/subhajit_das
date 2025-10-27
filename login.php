<?php include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // For demo, use bcrypt in real apps

    $stmt = $conn->prepare("SELECT id, name FROM members WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $name);
        $stmt->fetch();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        header("Location: attendance.php");
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Member Login</title>
  <style>
    body { font-family: Arial; background: #f4f6f8; display: flex; justify-content: center; align-items: center; height: 100vh; }
    form { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    input[type=text], input[type=password] { width: 100%; padding: 10px; margin: 10px 0; }
    input[type=submit] { background: #007BFF; color: white; padding: 10px; border: none; width: 100%; cursor: pointer; }
    .error { color: red; }
  </style>
</head>
<body>
  <form method="post">
    <h2>Member Login</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" value="Login">
  </form>
</body>
</html>
