<?php
// Initialize the session
session_start();
require_once "database.php";
// Check if the user is logged in, if not then redirect him to login page
$isLOGGED = isset($_SESSION["loggedin"]);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['add_to_cart'])) {

        $product_name = trim($_POST['product_name']);
        $price = trim($_POST['price']);
        $thumbnail = trim($_POST['thumbnail']);
        $user_id = $_SESSION['id'];
        $sql_for_find = "SELECT * FROM carts WHERE user_id = $user_id AND product_name = '$product_name'";

        if ($result = mysqli_query($link, $sql_for_find)) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                $new_quantity =  $row['quantity'] + 1;
                $new_price = $price * $new_quantity;

                $sql_for_update = "UPDATE carts SET quantity = $new_quantity, price = $new_price WHERE user_id = $user_id AND product_name = '$product_name'";
                if ($result_for_update = mysqli_query($link, $sql_for_update)) {
                    if ($result_for_update) {
                        echo "<script type='text/javascript'>alert('succesfully updated')</script>";
                    } else {
                        echo "<script type='text/javascript'>alert('somethig went wrong')</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('something went')</script>";
                }
            } elseif (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO carts (user_id, product_name, quantity, price, thumbnail) VALUES (?,?,?,?,?)";

                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "isiis", $param_user_id, $param_product_name, $param_quantity, $param_price, $param_thumbnail);
                    $param_user_id = $user_id;
                    $param_product_name = $product_name;
                    $param_quantity = 1;
                    $param_price = $price;
                    $param_thumbnail = $thumbnail;

                    if (mysqli_stmt_execute($stmt)) {

                        echo "<script type='text/javascript'>alert('added to cart')</script>";
                    } else {
                        echo "<script type='text/javascript'>alert('something went wrong')</script>";
                    }
                } else {
                    echo "<script type='text/javascript'>alert('something went wrong')</script>";
                }
            }
        } else {
            echo "<script type='text/javascript'>alert('something went')</script>";
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css" />

    <title>Ecommerce</title>
</head>

<body>
    <div class="hero_area">
        <!--header section-->

        <header class="header_section">
            <div class="header-top">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg custom_nav-container">
                        <a href="#" class="navbar-brand"><span>FaceWatch</span></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" arial-controls="navbarSupportedContent" aria-expanded="false" aria-label="toggle navigation">
                            <span class=""></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a href="#home" class="nav-link">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#about" class="nav-link">About</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#product" class="nav-link">Product</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#contact" class="nav-link">Contact</a>
                                </li>
                                <?php
                                if ($isLOGGED == false) {
                                    echo '
                                    <li class="nav-item">
                                        <a href="login.php"><input type="button" value="Logn"></a>
                                    </li>
                                    ';
                                } else {
                                    echo '
                                    <li class="nav-item">
                                         <div class="cart">
                                             <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                                         </div>
                                    </li>
                                    <li class="nav-item">
                                        <a href="logout.php"><input type="button" value="Logout"></a>
                                    </li>
                                    
                                    ';
                                }

                                ?>




                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="./img/landscape-1434121578-mb-f-lm101-frost-red-gold-2.jpg" alt="First slide" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./img/cover-homepage-tudor-black-bay-ceramic-landscape.jpg" alt="Second slide" />
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./img/DN1YTC-RolexDaytona-Lifestyle-Landscape.jpg" alt="Third slide" />
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!--slider section-->
        <section class="slider_section" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h1>Welcome to our shop</h1>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Totam, nisi. Optio recusandae quod tenetur facere, id hic
                                iste, consequuntur tempore commodi nam minima sapiente
                                quibusdam vel consequatur molestiae similique? Molestiae.
                            </p>
                            <a href="#">Shop Now</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="img-box">
                            <img src="./img/download (1).jfif" width="500" height="350" alt="img1" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!--product section-->

    <section class="product_section layout_padding" id="product">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Our Products</h2>
            </div>
            <div class="row">
                <?php

                require_once "database.php";

                $sql = "SELECT * FROM products ";
                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<div class="col-sm-6 col-lg-4">';
                            echo '<div class="box">';
                            echo  '<div class="img-box">';
                            echo      '<img src="' . $row['thumbnail'] . '" width="220" height="250" alt="" />';
                            echo     ' <a href="#" class="add_cart_btn "> <span>';
                            echo "<iframe name='norefresh' style='display:none;' ></iframe>";
                            echo "<form method='POST' target='norefresh'>";
                            echo "<input type='hidden' name='product_name' value=" . $row['product_name'] . ">";
                            echo "<input type='hidden' name='price' value=" . $row['price'] . ">";
                            echo "<input type='hidden' name='thumbnail' value=" . $row['thumbnail'] . ">";
                            echo "<input class='buy_button' name='add_to_cart' type='submit' value='Buy'>";
                            echo "</form>";
                            echo '</span></a>';
                            echo '</div>';
                            echo '<div class="detail-box">';
                            echo     '<h5>' . $row['product_name'] . '</h5>';
                            echo    '<div class="product_info">';
                            echo    '<h5><span>$</span> ' . $row['price'] . '</h5>';
                            echo    '<div class="star_container">';
                            echo           '<i class="fa fa-star" aria-hidden="true"></i>';
                            echo           ' <i class="fa fa-star" aria-hidden="true"></i>';
                            echo           ' <i class="fa fa-star" aria-hidden="true"></i>';
                            echo           '<i class="fa fa-star" aria-hidden="true"></i>';
                            echo           '<i class="fa fa-star" aria-hidden="true"></i>';
                            echo       '</div>';
                            echo      '</div>';
                            echo    '</div>';
                            echo   '</div>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo "something went wrong";
                }
                mysqli_close($link);

                ?>

                <!-- 
                <div class="col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/4.jpg " width="220" height="250" alt="" />
                            <a href="#" class="add_cart_btn"><span>Add to Cart</span></a>
                        </div>
                        <div class="detail-box">
                            <h5>Product4</h5>
                            <div class="product_info">
                                <h5><span>$</span>300</h5>
                                <div class="star_container">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/download (4).png" alt="" />
                            <a href="#" class="add_cart_btn"><span>Add to Cart</span></a>
                        </div>
                        <div class="detail-box">
                            <h5>Product5</h5>
                            <div class="product_info">
                                <h5><span>$</span>300</h5>
                                <div class="star_container">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/m128239-0038_modelpage_laying_down_landscape.png" alt="" />
                            <a href="#" class="add_cart_btn"><span>Add to Cart</span></a>
                        </div>
                        <div class="detail-box">
                            <h5>Product6</h5>
                            <div class="product_info">
                                <h5><span>$</span>300</h5>
                                <div class="star_container">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/7.jpg" width="220" height="250" alt="" />
                            <a href="#" class="add_cart_btn"><span>Add to Cart</span></a>
                        </div>
                        <div class="detail-box">
                            <h5>Product7</h5>
                            <div class="product_info">
                                <h5><span>$</span>300</h5>
                                <div class="star_container">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/8.jpg" width="220" height="250" alt="" />
                            <a href="#" class="add_cart_btn"><span>Add to Cart</span></a>
                        </div>
                        <div class="detail-box">
                            <h5>Product8</h5>
                            <div class="product_info">
                                <h5><span>$</span>300</h5>
                                <div class="star_container">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/9.jpg" width="220" height="250" alt="" />
                            <a href="#" class="add_cart_btn"><span>Add to Cart</span></a>
                        </div>
                        <div class="detail-box">
                            <h5>Production9</h5>
                            <div class="product_info">
                                <h5><span>$</span>300</h5>
                                <div class="star_container">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div> -->
            </div>
        </div>
        </div>
        </div>
    </section>

    <!--about section-->
    <section class="about_section" id="about">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 ml-auto">
                    <div class="detail-box pr-md-3">
                        <div class="heading_container">
                            <h2>We Provided Best for you</h2>
                        </div>
                        <p>
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Cumque
                            at, corrupti iure maiores quis iusto magnam suscipit eaque
                            consequuntur ex. Voluptas perspiciatis at enim tenetur neque.
                            Asperiores est itaque labore?
                        </p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="col-md-6 px-0">
                    <div class="img-box">
                        <img src="./img/11.jfif" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--service section-->
    <section class="service_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Services</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/download (1).png" width="90" height="100" alt="" />
                        </div>
                        <div class="detail-box">
                            <h5>Fast Delivery</h5>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Veniam, iure?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/download (2).png" width="90" height="100" alt="" />
                        </div>
                        <div class="detail-box">
                            <h5>Fast Shipping</h5>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Veniam, iure?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="img-box">
                            <img src="./img/download (3).png" width="90" height="100" alt="" />
                        </div>
                        <div class="detail-box">
                            <h5>Best Quality</h5>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Veniam, iure?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--footer section-->
    <section class="info_section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="info_contact">
                        <h5>
                            <a href="#" class="navbar-brand"><span>Face Watch</span></a>
                        </h5>
                        <p>
                            <i class="fa fa-map-marked" aria-hidden="true"></i>Makati City
                        </p>
                        <p><i class="fa fa-phone" aria-hidden="true"></i>773-9452</p>
                        <p>
                            <i class="fa fa-envelope" aria-hidden="true"></i>facewatch@gmail.com
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info_info">
                        <h5>Information</h5>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea,
                            totam!
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info_links">
                        <h5>Useful link</h5>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Products</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info_form">
                        <h5>Newsletter</h5>
                        <form action="">
                            <input type="email" placeholder="Enter your email" />
                            <button>Subscribe</button>
                        </form>
                        <div class="social_box">
                            <a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                            <a href="#">
                                <i class="fab fa-linkedin" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--footer bottom-->
    <footer class="footer_section">
        <div class="container">
            <p>&copy; 2021 All Rights Reserved By <a href="#">Kim Bargamento</a></p>
        </div>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>


</html>