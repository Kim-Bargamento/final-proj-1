<?php
// Initialize the session
session_start();
require_once "database.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

$username = "";
$email = "";
$password = "";
$confirm_password = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        echo "pls type your username";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    echo "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate password
    if (empty(trim($_POST["password"]))) {
        echo "pls enter password";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        echo "pls enter confirm password";
    } else {
        $password = trim($_POST["confirm_password"]);
    }
    $email = trim($_POST["email"]);
    // Prepare an insert statement
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);

        // Set parameters
        $param_username = $username;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to login page
            header("location: login.php");
        } else {
            echo "something went wrong";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Poppins:wght@200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Kimstore</title>

</head>

<body>

    <div class="regis-box">
        <h1>Registration Form</h1>
        <a href="index.php"></a>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <!-- <label>Firstname</label>
        <input type="text" name="firstname">
        
        <label>Lastname</label>
        <input type="text" name="lastname">-->



            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
            <label>Email</label>
            <input type="text" name="email">

            <label>Password</label>
            <input type="password" name="password">

            <label>confirm password</label>
            <input type="password" name="confirm_password">

            <input class="submit_button" type="submit" value="Submit">

            <p>already have an account? <a href="login.php">Login now</a>.</p>
        </form>
    </div>
</body>

</html>