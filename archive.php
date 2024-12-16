<?php
include "dbconn.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM archivecomplaints WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {

        $insert_sql = "INSERT INTO archivecomplaints(`id`, `firstName`, `lastName`, `number`, `file`, `date`, `description`)
                       SELECT id, firstName, lastName, number, file, date, description 
                       FROM complaints WHERE id=?";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "i", $id);
        $insert_result = mysqli_stmt_execute($insert_stmt);

        if ($insert_result) {
            $delete_sql = "DELETE FROM complaints WHERE id=?";
            $delete_stmt = mysqli_prepare($conn, $delete_sql);
            mysqli_stmt_bind_param($delete_stmt, "i", $id);
            $delete_result = mysqli_stmt_execute($delete_stmt);

            if ($delete_result) {
                echo "<script>alert('Record archived and deleted successfully.');</script>";
                header("Location: index.php");
                exit;
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
        } else {
            echo "Error archiving record: " . mysqli_error($conn);
        }
    } else {
        echo "Record already exists in the archive.";
        header("Location: index.php");
        exit;
    }
} else {
    echo "Error: No ID provided.";
    header("Location: index.php");
    exit;
}