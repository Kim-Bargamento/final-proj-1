<?php
session_start();
require_once "database.php";



// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['remove_to_cart'])) {
        $user_id = $_SESSION['id'];
        $id = trim($_POST['id']);
        $sql = "DELETE FROM carts WHERE user_id = $user_id AND id = '$id'";
        if (!$result = mysqli_query($link, $sql)) {
            echo "<script type='text/javascript'>alert('something went wrong')</script>";
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/style.css">

    <title>finalproj</title>
</head>

<body>
    <div class="container mt-3">
        <div class="back_button"><a href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg></a> </div>
        <h1 id="head1">Products Table</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Item name</th>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Remove</th>


                    </tr>
                </thead>
                <tbody id="table_products">
                    <?php

                    require_once "database.php";

                    $sql = "SELECT * FROM carts ";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['product_name'] . "</td>";
                                echo '<td> <img src="' . $row['thumbnail'] . '" width="200" height="150" alt="" /></td>';
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td>";
                                echo "<form class='remove-form' method='POST'>";
                                echo "<input type='hidden' name='id' value=" . $row['id'] . ">";
                                echo "<input class='remove_button' name='remove_to_cart' type='submit' value='X'>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                    } else {
                        echo "something went wrong";
                    }
                    mysqli_close($link);

                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>


</html>