<?php
include 'DB.php';

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Ensure the ID is an integer

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM users WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the main page after deletion
        header("Location: admin.php?message=User deleted successfully");
        exit();
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
    