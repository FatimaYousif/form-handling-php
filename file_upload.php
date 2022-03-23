<!DOCTYPE html>
<html lang="en">
<head>
  <title>File Uploading mechanism using PHP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php  
  
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["user_file"]) && $_FILES["user_file"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["user_file"]["name"];
        $filetype = $_FILES["user_file"]["type"];
        $filesize = $_FILES["user_file"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("uploads/" . $filename)){
                echo $filename . " is already exists.";
            } else{
                move_uploaded_file($_FILES["user_file"]["tmp_name"], "uploads/" . $filename);
                echo "Your file was uploaded successfully.";
            } 
        } else{
            echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } else{
        echo "Error: " . $_FILES["user_file"]["error"];
    }
}
?>  

<div class="container">
  <h2>File Uploading</h2>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="file">Upload Images:</label>
      <input type="file" class="form-control" name="user_file">
    </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </form>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>