<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_POST['update'])) {
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $contactNo = $_POST['contactno'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $originalEmail = $_GET['email']; // Get the original email from the GET parameter

    $query = "UPDATE userregistration SET firstName=?, middleName=?, lastName=?, contactno=?, email=?, course=? WHERE email=?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('sssisss', $firstName, $middleName, $lastName, $contactNo, $email, $course, $originalEmail);
        if (!$stmt->execute()) {
            echo "Error updating userregistration: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement for userregistration: " . $mysqli->error;
    }

    $query1 = "UPDATE registration SET firstName=?, middleName=?, lastName=?, contactno=?, email=?, course=? WHERE email=?";
    if ($stmt = $mysqli->prepare($query1)) {
        $stmt->bind_param('sssisss', $firstName, $middleName, $lastName, $contactNo, $email, $course, $originalEmail);
        if (!$stmt->execute()) {
            echo "Error updating registration: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement for registration: " . $mysqli->error;
    }
    echo "<script>alert('Student details updated successfully');</script>";
    echo "<script>window.location.href='manage-students.php';</script>";
}

$email = isset($_GET['email']) ? $_GET['email'] : '';
$query = "SELECT * FROM userregistration WHERE email=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <title>Edit Student Profile</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/edit-student.css">
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Edit Student Profile</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">Student Details</div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="firstName">First Name:</label>
                                        <input type="text" class="form-control" name="firstName" value="<?php echo htmlspecialchars($row->firstName); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="middleName">Middle Name:</label>
                                        <input type="text" class="form-control" name="middleName" value="<?php echo htmlspecialchars($row->middleName); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastName">Last Name:</label>
                                        <input type="text" class="form-control" name="lastName" value="<?php echo htmlspecialchars($row->lastName); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contactno">Contact Number:</label>
                                        <input type="text" class="form-control" name="contactno" value="<?php echo htmlspecialchars($row->contactNo); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($row->email); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="seater">Course:</label>
                                        <select name="course" id="course" class="form-control" required>
                                            <?php
                                            $selected_course = htmlspecialchars($row->course);
                                            echo "<option value='$selected_course'>$selected_course</option>";
                                            $query = "SELECT * FROM courses";
                                            $stmt2 = $mysqli->prepare($query);
                                            $stmt2->execute();
                                            $res = $stmt2->get_result();
                                            while ($course_row = $res->fetch_object()) {
                                                echo "<option value='$course_row->course_fn'>$course_row->course_fn ($course_row->course_sn)</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="update" class="align-right">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
