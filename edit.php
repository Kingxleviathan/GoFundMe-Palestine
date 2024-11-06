<?php
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
    exit();
}

$getcampains = $conn->prepare("SELECT * FROM `campaigns` WHERE id = :id");
$getcampains->bindParam(":id", $id);
$getcampains->execute();
$campains = $getcampains->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $family = $_POST["family"];
    $description = $_POST["description"];
    $link = $_POST["link"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $imagetmp = $_FILES["image"]["tmp_name"];
        $imageExt = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    

        $imagedir = "opgeslagen-img/" . uniqid() . "." . $imageExt;
        if (!move_uploaded_file($imagetmp, $imagedir)) {
            echo "Error uploading the image.";
            exit();
        } 
    } else {
        $imagedir = $campains["image"];
    }
    
    $updatecampain = $conn->prepare("UPDATE `campaigns` SET family = :family, description = :description, link = :link, image = :image WHERE id = :id");
    $updatecampain->bindParam(":family", $family);
    $updatecampain->bindParam(":description", $description);
    $updatecampain->bindParam(":link", $link);
    $updatecampain->bindParam(":image", $imagedir);
    $updatecampain->bindParam(":id", $id);

    if ($updatecampain->execute()) {
        header("Location: detail.php?id=$id");
        exit;
    } else {
        echo "Error updating campaign";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Edit Campaign</title>
    <style>
        body,
        html {
            background-color: black;
            overflow: hidden;
            height: 100%;
            margin: 0;
        }

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 1rem;
        }

        .card {
            max-width: 900px;
            background-color: #222;
            color: white;
        }

        .form-label,
        .btn {
            color: white;
        }
        .form-control {
            background-color: #333;
            border: 1px solid #444;
            color: white;
        }
    </style>
</head>

<body>

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

    <div class="container">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title">Edit Campaign</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="family" class="form-label">Family</label>
                        <input type="text" class="form-control" id="family" name="family" value="<?php echo $campains["family"]; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $campains["description"]; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input type="url" class="form-control" id="link" name="link" value="<?php echo $campains["link"]; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Campaign Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="detail.php?id=<?php echo $campains["id"]; ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>