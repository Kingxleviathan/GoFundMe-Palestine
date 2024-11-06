<?php
include_once "db.php";

session_start();

if (!isset($_SESSION["loggedInUser"])) {
    header("location: login.php");
    exit;
}

$getcampains = $conn->prepare("SELECT * FROM `campaigns` ");
$getcampains->execute();
$campains = $getcampains->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Home</title>
</head>

<body style="background-color: black;">

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

    <div class="container-fluid mt-5">
        <div class="row">
            <?php foreach ($campains as $campain) { ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex align-items-stretch">
                    <div class="card w-100">
                        <img src="<?php echo $campain["image"] ?>" class="card-img-top" alt="gofundme logo">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $campain["family"]; ?></h5>
                            <div class="mt-auto d-flex gap-2">
                                <a href="<?php echo $campain["link"]; ?>" target="_blank" class="btn btn-primary flex-fill">Link naar family gofundme</a>
                                <a href="detail.php?id=<?php echo $campain["id"] ?>" class="btn btn-primary flex-fill">More Detail</a>
                            </div>
                            <?php if ($_SESSION["loggedInUser"]["role"] == 'admin') { ?>
                                <form action="delete.php" method="POST" class="mt-2">
                                    <input type="hidden" name="delete_id" value="<?php echo $campain["id"]; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this campaign?');">Delete</button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>