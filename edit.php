<?php
// Include database connection
include 'db.php';

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    // Safely get the id from the URL and convert it to an integer
    $id = intval($_GET['id']);

    // Prepare the SQL SELECT query
    $sql = "SELECT * FROM fish WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the record exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "No record found.";
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: index.php");
    exit;
}

// Handle form submission to update the record
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $weight = $_POST['weight'];
    $date_added = $_POST['date_added'];

    $sql = "UPDATE fish SET name=?, species=?, weight=?, date_added=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdsi", $name, $species, $weight, $date_added, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Fish Record</title>
    <style>
        .edit-container {
            background-color: #f0f8ff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: 50px auto;
        }

        .edit-container h2 {
            text-align: center;
            color: #333;
        }

        .edit-container input[type="text"], 
        .edit-container input[type="number"], 
        .edit-container input[type="date"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #fff5f5;
        }

        .edit-container button {
            background-color: #ff7043;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-container button:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>
<div class="edit-container">
    <h2>Edit Fish Record</h2>

    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
        <input type="text" name="species" value="<?php echo $row['species']; ?>" required>
        <input type="number" name="weight" value="<?php echo $row['weight']; ?>" required>
        <input type="date" name="date_added" value="<?php echo $row['date_added']; ?>" required>
        <button type="submit" name="update">Update</button>
    </form>
</div>
</body>
</html>