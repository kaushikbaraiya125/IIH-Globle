<?php
require_once "connection.php";
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $hobbies = implode(",", $_POST['hobbies']);
    
    // If upload button is clicked ...
    if (isset($_FILES['profile_image'])) {    
        $filename = $_FILES["profile_image"]["name"];
        $tempname = $_FILES["profile_image"]["tmp_name"];    
        $folder = "image/".$filename;            
    }
  
    $sql = "INSERT INTO users (name,email,contact_number,state,city,hobbies,profile_image) VALUES ('$name','$email','$contact_number','$state','$city','$hobbies','$filename')";
    if (mysqli_query($conn, $sql)) {
        if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
        }   
        header("location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    mysqli_close($conn);

    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <?php include "head.php"; ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Create Record</h2>
                </div>
                
                <?php 
                if(!empty($msg)){
                    echo '<div class="alert alert-danger">' . $msg . '</div>';
                }        
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="" maxlength="50" required="">
                    </div>
                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30" required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="contact_number" name="contact_number" class="form-control" value="" maxlength="12" pattern="[0-9]{10}" required="">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <select name="city" id="city" class="form-control">
                            <option value="ahmedabad">Ahmedabad</option>
                            <option value="jaipur">Jaipur</option>
                            <option value="mumbai">Mumbai</option>
                            <option value="bangalore">Bangalore</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <select name="state" id="state" class="form-control">
                            <option value="gujarat">Gujarat</option>
                            <option value="rajasthan">Rajasthan</option>
                            <option value="maharashtra">Maharashtra</option>
                            <option value="karnataka">Karnataka</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Hobbies</label><br>
                        <input type="checkbox" name="hobbies[]" value="sports" id="sport">
                        <label for="sport">Sports</label>&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="hobbies[]" value="music" id="music">
                        <label for="music">Music</label>&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="hobbies[]" value="reading" id="read">
                        <label for="read">Reading</label>
                    </div>
                    <div class="form-group">
                        <label for="profile_image">Profile Image:</label>
                        <input type="file" class="form-control" name="profile_image" id="profile_image" required>
                    </div>

                    <input type="submit" class="btn btn-primary" name="save" value="submit">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>