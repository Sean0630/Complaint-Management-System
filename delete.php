<?php
include "dbconn.php";

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql_complaints = "DELETE FROM complaints WHERE id = ?";
    $stmt_complaints = mysqli_prepare($conn, $sql_complaints);
    
    if ($stmt_complaints) {
        mysqli_stmt_bind_param($stmt_complaints, "i", $id);
        $result_complaints = mysqli_stmt_execute($stmt_complaints);

        if ($result_complaints) {
            echo "<script>alert('Record deleted from complaints table';.</script>";
            header("Location: index.php");
            exit;
        } else {

            $sql_archive = "DELETE FROM archivecomplaints WHERE id = ?";
            $stmt_archive = mysqli_prepare($conn, $sql_archive);

            if ($stmt_archive) {
                mysqli_stmt_bind_param($stmt_archive, "i", $id);
                $result_archive = mysqli_stmt_execute($stmt_archive);

                if ($result_archive) {
                    echo "Record deleted from archive table.";
                    header("Location: archive.php");
                    exit;
                } else {
                    echo "Error deleting record from archive: " . mysqli_error($conn);
                }
            } else {
                echo "Error preparing delete statement for archive: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error preparing delete statement for complaints: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_complaints);
    mysqli_stmt_close($stmt_archive);
} else {
    echo "No ID provided.";
}
