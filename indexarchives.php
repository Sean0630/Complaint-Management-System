<?php
include "dbconn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Complaint Management System Archives</title>
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: maroon; color: whitesmoke;">
    Complaint System Archives

    <a href="index.php" style="background-color: #002D9E; color: whitesmoke; width: 100px; height: 25px; text-decoration: none; font-size: 18px; position: absolute; left: 100px; ">MAIN</a>
  </nav>

  <div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <table class="table table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
          <th scope="col">Phone Number</th>
          <th scope="col">Date</th>
          <th scope="col">Image</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `archivecomplaints`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?php echo $row["id"] ?></td>
            <td><?php echo $row["firstName"] ?></td>
            <td><?php echo $row["lastName"] ?></td>
            <td><?php echo $row["number"] ?></td>
            <td><?php echo $row["date"] ?></td>
            <td>
              <?php
                if (!empty($row['file']) && file_exists('uploads/' . $row['file'])) {
                    echo "<img src='uploads/" . $row['file'] . "' alt='Image' width='100' height='100'>";
                  } else {
                    echo "No image";
                  }
              ?>
            <td>
              <summary>
                <details>
                  <?php echo $row["description"] ?>
                </details>
              </summary>
            </td>
            <td>
              <form action="restore.php" method="GET">
                  <button type="submit" name="restore_id" value="<?php echo $row['id']; ?>" style="background-color: green; color: white; border-radius: 5px;">Restore</button>
              </form>
              <form action="delete.php" method="GET" onsubmit="return confirm('Are you sure you want to delete this record?');">
                  <button type="submit" name="delete_id" value="<?php echo $row['id']; ?>" style="background-color: red; color: white; border-radius: 5px; padding: 5px 10px;">Delete</button>
              </form>
              </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>