<?Php
include_once "db.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruiker = $_POST["username"];
    $passw = $_POST["password"];

    $getuser = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $getuser->bindParam(":username", $gebruiker);
    $getuser->execute();
    $user = $getuser->fetch();


    if ($user && password_verify($passw, $user["password"])) {
        $_SESSION["loggedInUser"] = [
            "id" => $user["id"],
            "role" => $user["role"]
        ];
        header("location: index.php");
        exit;
    } else {
        $error = "Invalide username/password, try it again please.";
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
    <title>Login</title>
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
    <?php if (isset($error)) { ?>
        <p style="color: red; font-weight: bold; font-size: 25px"><?php echo $error; ?></p>
    <?php } ?>

    <div class="background-image"></div>
    <div class="container">
        <div class="form-container">
            <h1 class="text-white">Login</h1>
            <form method="post" action="login.php">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button class="btn btn-success btn-block" type="submit">Login</button>

                <div class="nav-item">
                    <a class="nav-link" href="register.php">Registreer</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>