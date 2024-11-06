<?Php
include_once "db.php";
session_start();

if (!isset($_SESSION["loggedInUser"])) {
    header("location: login.php");
    exit;
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    echo "ERROR: PROGRAM WORDT NIET UITGEVOERD!";
    exit;
}


$getcampains = $conn->prepare("SELECT * FROM `campaigns` WHERE id = :id");
$getcampains->bindParam(":id", $id);
$getcampains->execute();
$campains = $getcampains->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Details</title>
</head>

<body style="background-color: black; overflow: hidden;">

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($_SESSION["loggedInUser"]["role"] == 'admin') { ?>
                        <li class="nav-item"><a class="nav-link" href="add.php">Add New Campaign</a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container vh-100 d-flex justify-content-center align-items-center my-4 px-2">
        <div class="card w-100" style="max-width: 900px;">
            <img src="<?php echo $campains["image"] ?>" class="card-img-top" alt="gofundme logo" style="height: 50vh; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $campains["family"]; ?></h5>
                <p class="card-text"><?php echo $campains["description"]; ?></p>
                <a href="<?php echo $campains["link"]; ?>" target="_blank" class="btn btn-primary">Link naar family gofundme</a>
                <?php if ($_SESSION["loggedInUser"]["role"] == 'admin') { ?>
                    <a href="edit.php?id=<?php echo $campains["id"] ?>" class="btn btn-primary">Edit Campain</a>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>