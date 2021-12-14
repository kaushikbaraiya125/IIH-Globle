<?php
// Include database connection file
require_once "connection.php";
if (count($_POST) > 0) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $hobbies = implode(",", $_POST['hobbies']);

    
    if (isset($_FILES['profile_image'])) {    
        $filename = $_FILES["profile_image"]["name"];
        $tempname = $_FILES["profile_image"]["tmp_name"];    
        $folder = "image/".$filename;            
    }
     
    mysqli_query($conn, "UPDATE users set name='" . $name . "', contact_number='" . $contact_number . "' ,email='" . $email . "',hobbies='" . $hobbies . "',city='" . $city . "',state='" . $state . "',profile_image='" . $filename . "' WHERE id='" . $_POST['id'] . "'");

    if (move_uploaded_file($tempname, $folder))  {
        $msg = "Image uploaded successfully";
    }
    header("location: index.php");
    exit();
}
$result = mysqli_query($conn, "SELECT * FROM users WHERE id='" . $_GET['id'] . "'");
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <?php include "head.php"; ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Update Record</h2>
                </div>
                <p>Please edit the input values and submit to update the record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $row["name"]; ?>" maxlength="50" required="">
                    </div>
                    <div class="form-group ">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $row["email"]; ?>" maxlength="30" required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="contact_number" name="contact_number" class="form-control" value="<?php echo $row["contact_number"]; ?>" maxlength="12" required="" pattern="[0-9]{10}">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <select name="city" id="city"  class="form-control">
                            <option value="">Select City</option>
                            <option value="ahmedabad" <?php echo $row["city"] == "ahmedabad" ? 'selected="selected"' : '';  ?>>Ahmedabad</option>
                            <option value="jaipur" <?php echo $row["city"] == "jaipur" ? 'selected="selected"' : '';  ?>>Jaipur</option>
                            <option value="mumbai" <?php echo $row["city"] == "mumbai" ? 'selected="selected"' : '';  ?>>Mumbai</option>
                            <option value="bangalore" <?php echo $row["city"] == "bangalore" ? 'selected="selected"' : '';  ?>>Bangalore</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <select name="state" id="state"  class="form-control">
                            <option value="">Select State</option>
                            <option value="gujarat" <?php echo $row["state"] == "gujarat" ? 'selected="selected"' : '';  ?> >Gujarat</option>
                            <option value="rajasthan" <?php echo $row["state"] == "rajasthan" ? 'selected="selected"' : '';  ?>>Rajasthan</option>
                            <option value="maharashtra" <?php echo $row["state"] == "maharashtra" ? 'selected="selected"' : '';  ?>>Maharashtra</option>
                            <option value="karnataka" <?php echo $row["state"] == "karnataka" ? 'selected="selected"' : '';  ?> >Karnataka</option>
                        </select>
                    </div>
                    <?php
                    $hobbies = explode(",", $row["hobbies"]);
                    ?>
                    <div class="form-group">
                        <label>Hobbies</label><br>
                        <input type="checkbox" name="hobbies[]" value="sports" id="sport" <?php if (in_array("sports", $hobbies)) { ?> checked <?php }; ?>>
                        <label for="sport">Sports</label>&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="hobbies[]" value="music" id="music" <?php if (in_array("music", $hobbies)) { ?> checked <?php }; ?>>
                        <label for="music">Music</label>&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="hobbies[]" value="reading" id="read" <?php if (in_array("reading", $hobbies)) { ?> checked <?php }; ?>>
                        <label for="read">Reading</label>
                    </div>
                    <div class="form-group">
                        <label for="image">Profile Image:</label>
                        <input type="file" class="form-control" name="profile_image" id="profile_image"  value="<?php echo $row["profile_image"]; ?>">
                        <?php 
                        if( !empty($row["profile_image"]) ){
                            echo '<img src="image/'.$row["profile_image"].'" style="width: 100px;">'; 
                        } ?>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>" />
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>