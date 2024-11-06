<?php 
include_once "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruiker = $_POST["username"];
    $passw = $_POST["password"];
    $role = $_POST["role"];

    $hoeveel = $conn->query("SELECT * FROM users WHERE role = 'admin'");
    $admins = $hoeveel->fetchAll();
    $aantal = count($admins);

    if ($role == 'admin' && $aantal >= 2) { 
        $error = "Er kunnen maximaal twee beheerders worden aangemaakt.";
    } else {
        $passwordhash = password_hash($passw, PASSWORD_DEFAULT); 

        $adduser = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $adduser->bindParam(":username", $gebruiker);
        $adduser->bindParam(":password", $passwordhash);
        $adduser->bindParam(":role", $role);

        if ($adduser->execute()) {
            $_SESSION["loggedInUser"] = [
                "username" => $gebruiker,
                "role" => $role
            ];
            header("location: index.php");
            exit();
        } else {
            $error = "Er is een fout opgetreden tijdens registratie.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registreren</title>
    <style>
        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('./img/pic2.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.8;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="form-container">
            <h1 class="text-center">Registreer je!</h1>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php } ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="user">Member</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button class="btn btn-success btn-block" type="submit">Registreren</button>
            </form>
        </div>
    </div>
</body>
</html>
