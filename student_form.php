<?php 
include('header.php');
include('navbar.php');
include('dbcon.php');

if(isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $roll = $_POST['roll'];
    $contact = $_POST['contact'];
    $type = $_POST['type'];
    $year_level = $_POST['year_level'];
    $password = $_POST['password'];

    $query = "INSERT INTO member (firstname, lastname, username, gender, address, roll, contact, type, year_level, password)
              VALUES ('$firstname', '$lastname', '$username', '$gender', '$address', '$roll', '$contact', '$type', '$year_level', '$password')";
    mysql_query($query) or die(mysql_error());

    // Redirect to success page after successful insertion
    header('Location: success.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <!-- Add your CSS stylesheets and any other meta tags, links, or scripts here -->
</head>
<body>
    <div class="container">
        <div class="margin-top">
            <div class="row">
                <?php include('head.php'); ?>
                    
                <div class="span12">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"> 
                        <div class="span5">
                            <div class="form-horizontal">
                                <div class="control-group">
                                    <label class="control-label" for="inputEmail">First Name:</label>
                                    <div class="controls">
                                        <input type="text" id="inputEmail" name="firstname" placeholder="First Name" required>
                                    </div>
                                </div>
                                <!-- Add other form fields similar to the one above -->
                                
                                <div class="control-group">
                                    <div class="controls">
                                        <button name="submit" type="submit" class="btn btn-info"><i class="icon-signin icon-large"></i>&nbsp;Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
