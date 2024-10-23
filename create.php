<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add Fish</title>
</head>
<body>
<div class="container">
    <h2>Add New Fish</h2>

    <form action="" method="POST">
        <input type="text" name="name" placeholder="Fish Name" required>
        <input type="text" name="species" placeholder="Fish Species" required>
        <input type="number" name="weight" placeholder="Weight (kg)" required>
        <input type="date" name="date_added" required>
        <button type="submit" name="save">Save</button>
    </form>

    <?php
    if (isset($_POST['save'])) {
        $name = $_POST['name'];
        $species = $_POST['species'];
        $weight = $_POST['weight'];
        $date_added = $_POST['date_added'];  // No need for conversion if the field is DATE type

        $sql = "INSERT INTO fish (name, species, weight, date_added) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssds", $name, $species, $weight, $date_added);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Fish added successfully!</p>";
            header("Location: index.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
    ?>
</div>
</body>
</html>