<?php
include "dbconn.php";

if (isset($_GET['restore_id'])) {
    $id = $_GET['restore_id'];

    $sql = "SELECT * FROM archivecomplaints WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        echo "Error preparing statement: " . mysqli_error($conn);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $insert_sql = "INSERT INTO complaints (firstName, lastName, number, file, date, description)
                       VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);

        if ($insert_stmt === false) {
            echo "Error preparing insert statement: " . mysqli_error($conn);
            exit;
        }

        mysqli_stmt_bind_param($insert_stmt, "ssssss", $row['firstName'], $row['lastName'], $row['number'], $row['file'], $row['date'], $row['description']);
        $insert_result = mysqli_stmt_execute($insert_stmt);

        if ($insert_result) {
            $delete_sql = "DELETE FROM archivecomplaints WHERE id = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_sql);

            mysqli_stmt_bind_param($delete_stmt, "i", $id);
            $delete_result = mysqli_stmt_execute($delete_stmt);

            if ($delete_result) {
                echo "<script>alert('Record restored successfully!');";
                header("Location: indexarchives.php");
                exit;
            } else {
                echo "Error deleting from archive: " . mysqli_error($conn);
            }
        } else {
            echo "Error restoring record to complaints: " . mysqli_error($conn);
        }
    } else {
        echo "No archived record found with the given ID.";
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($insert_stmt);
    mysqli_stmt_close($delete_stmt);
} else {
    echo "No ID provided.";
}