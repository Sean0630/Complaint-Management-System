<?php
include "dbconn.php";

if (isset($_POST['submit'])) {

   $firstName = htmlspecialchars($_POST['firstName']);
   $lastName = htmlspecialchars($_POST['lastName']);
   $number = $_POST['number'];
   $date = $_POST['date'];
   $description = htmlspecialchars($_POST['description']);
  
   $file = $_FILES['file'];
   $fileName = $file['name'];
   $fileTmpName = $file['tmp_name'];
   $fileSize = $file['size'];
   $fileError = $file['error'];
   $fileType = $file['type'];

   
   $allowed = array('jpg', 'jpeg', 'png');
   $fileExt = strtolower(end(explode('.', $fileName)));


   if (in_array($fileExt, $allowed)) {

       if ($fileError === 0) {
 
           if ($fileSize < 5000000) {

               $fileNewName = uniqid('', true) . "." . $fileExt;

               $fileDestination = 'uploads/' . $fileNewName;
               

               if (move_uploaded_file($fileTmpName, $fileDestination)) {

                   include 'dbconn.php';

                   $sql = "INSERT INTO `complaints`(`firstName`, `lastName`, `number`, `file`, `date`, `description`) 
                           VALUES ('$firstName', '$lastName', '$number', '$fileNewName', '$date', '$description')";

                   $result = mysqli_query($conn, $sql);

  
                   if ($result) {
                       header("Location: formsubmitted.php");
                       exit();
                   } else {
                       echo "Error: " . mysqli_error($conn);
                   }
               } else {
                   echo "There was an error uploading your file.";
               }
           } else {
               echo "Your file is too big. Max size is 5MB.";
           }
       } else {
           echo "There was an error uploading your file.";
       }
   } else {
       echo "You cannot upload files of this type. Only jpg, jpeg, and png are allowed.";
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>Barangay Complaint Management System</title>
</head>

<body>
   <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #002D9E; color: whitesmoke;">
      <img src="logo.png" alt="" width="50px" height="50px">Barangay Complaint Form
   </nav>

   <div class="container">
      <div class="text-center mb-4">
         <h3></h3>
      </div>

      <div class="container d-flex justify-content-center">
         <form action="" method="post" style="width:50vw; min-width:300px;" enctype="multipart/form-data">
            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">First Name:</label>
                  <input type="text" class="form-control" name="firstName" placeholder="Enter your first name" required>
               </div>

               <div class="col">
                  <label class="form-label">Last Name:</label>
                  <input type="text" class="form-control" name="lastName" placeholder="Enter your last name" required>
               </div>
            </div>

            <div class="mb-3">
               <label class="form-label">Phone Number:</label>
               <input type="number" class="form-control" name="number" placeholder="123-456-7890" required>
            </div>

            <div class="mb-3">
               <label for="file" class="form-label">Select file:</label>
               <input type="file" class="form-control" name="file" id="file">
            </div>

            <div class="mb-3">
               <label class="form-label">Date:</label>
               <input type="date" class="form-control" name="date" id="date" required>
            </div>

            <div class="mb-3">
               <label class="form-label">Description (Address, Location of Complaint, & Describe the Complaint)</label>
               <textarea name="description" id="description" class="form-control" style="resize: none;" required></textarea>
            </div>

            <div>
               <button type="submit" class="btn btn-success" name="submit" style="background-color: #002D9E; color: whitesmoke;">Submit</button>
            </div>
         </form>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>

