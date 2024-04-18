<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $db = getMongoDB();
    $collection = $db->users;

    $user = $collection->findOne(['username' => $_POST['username'], 'password' => md5($_POST['password'])]);

    if ($user) {
        $_SESSION['user_id'] = $user->_id;
        header("Location: liste_restaurants.php");
        exit();
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <form method="post">
        <label>Username:</label><input type="text" name="username" required>
        <label>Password:</label><input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
