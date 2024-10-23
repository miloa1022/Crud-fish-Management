<?php
// Include database connection
include 'db.php';

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    // Safely get the id from the URL and prevent SQL injection by using prepared statements
    $id = intval($_GET['id']); // Convert the id to an integer to avoid SQL injection

    // Prepare the SQL DELETE query
    $sql = "DELETE FROM fish WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the id parameter to the statement
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to index.php after successful deletion
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // If no id is provided, redirect back to index.php
    header("Location: index.php");
}
?>
