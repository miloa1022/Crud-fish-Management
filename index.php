<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Fish Management System</title>
</head>
<body>
<div class="container">
    <h1>Fish Management System</h1>
    <a href="create.php" class="button">Add New Fish</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Species</th>
                <th>Weight (kg)</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Modify SQL to explicitly select the id
            $sql = "SELECT id, name, species, weight, date_added FROM fish"; 
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Safely get the 'id' from the row
                    $id = $row['id']; 
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['species']}</td>
                            <td>{$row['weight']}</td>
                            <td>{$row['date_added']}</td>
                            <td>
                                <a href='edit.php?id=$id'>Edit</a> | 
                                <a href='delete.php?id=$id' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>