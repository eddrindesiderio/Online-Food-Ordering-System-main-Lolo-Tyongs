<?php
session_start();
require 'connection.php';
  $conn = Connect();

if(!isset($_SESSION['login_customer'])){ //if customer logged in
  header('location: index.php');
}

if(isset($_SESSION['login_manager'])){ //if manager logged in
  header('location: manager.php');
}

if(isset($_SESSION['login_admin'])){ //if manager logged in
  header('location: admin.php');
}


if(isset($_POST["choose"])) {
    $R_ID = $_POST["R_ID"];

    $sql = "select * from restaurant where R_ID = $R_ID";
    $result = mysqli_query($conn,$sql);

    $rest = mysqli_fetch_assoc($result);
}

if(isset($_GET["action"])) {
  if($_GET["action"] == "add") {
    $RID = $_GET["rid"];
    echo '<script>console.log($RID)</script>';
    if(isset($_SESSION["cart"])) {
        $item_array_id = array_column($_SESSION["cart"], "item_ID");
        if(!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION["cart"]);
  
            $item_array = array(
                'item_ID' => $_GET["id"],
                'name' => $_POST["name"],
                'price' => $_POST["price"],
                'R_ID' => $_POST["R_ID"],
                'quantity' => $_POST["quantity"]
            );
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>window.location="restaurant.php?rid='.$_GET["rid"].'"</script>';
        } else {
            echo '<script>alert("Item already present in cart.\n To change quantity remove from cart.")</script>';
            echo '<script>window.location="restaurant.php?rid='.$_GET["rid"].'"</script>';
        }
    } else {
        $item_array = array(
            'item_ID' => $_GET["id"],
            'name' => $_POST["name"],
            'price' => $_POST["price"],
            'R_ID' => $_POST["R_ID"],
            'quantity' => $_POST["quantity"]
        );
        $_SESSION["cart"][0] = $item_array;
        echo '<script>window.location="restaurant.php?rid='.$_GET["rid"].'"</script>';
    }
  }
}

if(isset($_GET["rid"])) {
  $R_ID = $_GET["rid"];
  $sql = "select * from restaurant where R_ID = $R_ID";
  $result = mysqli_query($conn,$sql);

  $rest = mysqli_fetch_assoc($result);
}

if(!(isset($_GET["rid"]) || isset($_POST["R_ID"]))) {
    unset($_SESSION["cart"]);
    header("location: restaurant_choose.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>OFOS &#9824;</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">



    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">

    <style>
        @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        #team {
            background: #eee !important;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #108d6f;
            border-color: #108d6f;
            box-shadow: none;
            outline: none;
        }

        .btn-primary {
            color: #fff;
            background-color: #007b5e;
            border-color: #007b5e;
        }

        section {
            padding: 60px 0;
        }

        section .section-title {
            text-align: center;
            color: #007b5e;
            margin-bottom: 50px;
            text-transform: uppercase;
        }

        #team .card {
            border: none;
            background: #ffffff;
        }

        .image-flip:hover .backside,
        .image-flip.hover .backside {
            -webkit-transform: rotateY(0deg);
            -moz-transform: rotateY(0deg);
            -o-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);
            transform: rotateY(0deg);
            border-radius: .25rem;
        }

        .image-flip:hover .frontside,
        .image-flip.hover .frontside {
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            -o-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }

        .mainflip {
            -webkit-transition: 1s;
            -webkit-transform-style: preserve-3d;
            -ms-transition: 1s;
            -moz-transition: 1s;
            -moz-transform: perspective(1000px);
            -moz-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transition: 1s;
            transform-style: preserve-3d;
            position: relative;
        }

        .frontside {
            position: relative;
            -webkit-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);
            z-index: 2;
            margin-bottom: 30px;
        }

        .backside {
            position: absolute;
            top: 0;
            left: 0;
            background: white;
            -webkit-transform: rotateY(-180deg);
            -moz-transform: rotateY(-180deg);
            -o-transform: rotateY(-180deg);
            -ms-transform: rotateY(-180deg);
            transform: rotateY(-180deg);
            -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
            -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
            box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
        }

        .frontside,
        .backside {
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            -ms-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transition: 1s;
            -webkit-transform-style: preserve-3d;
            -moz-transition: 1s;
            -moz-transform-style: preserve-3d;
            -o-transition: 1s;
            -o-transform-style: preserve-3d;
            -ms-transition: 1s;
            -ms-transform-style: preserve-3d;
            transition: 1s;
            transform-style: preserve-3d;
        }

        .frontside .card,
        .backside .card {
            min-height: 312px;
        }

        .backside .card a {
            font-size: 18px;
            color: #007b5e !important;
        }

        .frontside .card .card-title,
        .backside .card .card-title {
            color: #007b5e !important;
        }

        .frontside .card .card-body img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
        }
    </style>
    
  </head>
  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="200">

  <div id="overlay" style="
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5);
    z-index: 2;
    cursor: pointer;
  ">
  <div id="signupDialog" tabindex="-1" role="dialog" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);-ms-transform: translate(-50%,-50%);" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <h3>
        <div  id="dialogMsg" class="modal-body bg-primary">
          Item Added to Cart
        </div>
        </h3>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
  <!-- <div class="site-wrap"> -->

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    
    <header class="site-navbar py-3 js-site-navbar site-navbar-target" role="banner" id="site-navbar">

      <div class="container">
        <div class="row align-items-center">
          
          <div class="col-11 col-xl-2 site-logo">
            <h1 class="mb-0"><a href="index.php" class="text-white h2 mb-0">OFOS</a></h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">

              <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block">
              <li><a href="customer.php" class="nav-link">Welcome, <?php echo $_SESSION["login_customer"]?></a></li>
              <li><a href="restaurant_choose.php"><span class="glyphicon glyphicon-shopping-cart"></span>Restaurants</a></li>
                <li><a href="cart.php?rid=<?php echo $R_ID;?>"><span class="glyphicon glyphicon-shopping-cart"></span> Cart  (<?php
                if(isset($_SESSION["cart"])){
                    $count = count($_SESSION["cart"]); 
                    echo "$count"; 
                } else
                    echo "0";
                ?>) </a></li>
                <li><a href="logout.php" class="nav-link">Logout</a></li>
              </ul>
            </nav>
          </div>


          <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu h3"></span></a></div>

          </div>

        </div>
      </div>
      
    </header>

    <div class="jumbotron" style="color: #FFFFFF; margin-bottom: 0rem; background: #333333; border-radius:0rem">
        <div class="container text-center">
            <?php 
                if(!$rest["name"]) {
                  unset($_SESSION["cart"]);
                  header("location: restaurant_choose.php");
                }
            ?>
            <h1><?php echo $rest["name"]; ?></h1>      
            <p>Choose Wisely</p>
            <?php
                echo '<a href="cart.php?rid='.$R_ID.'" class="btn btn-primary btn-sm">Proceed to Checkout</a>'
            ?>
        </div>
    </div>

    <div class="site-section" style="background-image: url(images/food_bg.jpg); background-size: cover" id="section-home">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center" data-aos="fade-up" data-aos-delay="400">
        <?php
                $sql = "select * from menu_item where R_ID=".$R_ID." order by item_ID";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while($row = mysqli_fetch_assoc($result)){
            ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="image-flip1">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p><img class=" img-fluid" src="images/menu_items/item_<?php echo $row["item_ID"]; ?>.jpg" alt="card image"></p>
                                        <form method="post" action="restaurant.php?action=add&id=<?php echo $row["item_ID"]; ?>&rid=<?php echo $row["R_ID"]; ?>">
                                        <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
                                        <input type="hidden" name="price" value="<?php echo $row["price"]; ?>">
                                        <input type="hidden" name="R_ID" value="<?php echo $row["R_ID"]; ?>">
                                        <h4 class="card-title" style="margin-bottom:0px"><?php echo $row["name"]; ?></h4>
                                        <p class="card-text" style="color: rgb(77,77,77); margin-bottom:0px">Price: ₱<?php echo $row["price"]; ?></p>
                                        <p class="card-text" style="color: rgb(77,77,77)"><input type="number" min="1" max="25" name="quantity" value="1" style="width: 60px"></p>
                                        <button type="submit" name="add" class="btn btn-primary btn-sm">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
                    }
                } else {
            ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="image-flip1">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p><img class=" img-fluid" src="images/cross.jpeg" alt="card image"></p>
                                        <h4 class="card-title">Oops! No food is available.</h4>
                                        <p class="card-text" style="color: rgb(77,77,77)">Come back later.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
      </div>
    </div>  
    
    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-5 mr-auto">
                <h2 class="footer-heading mb-4">About Us</h2>
                <p>This is an Online Food Ordering System, developed as a part of project of the Database Management System.</p>
              </div>
              
              
              <div class="col-md-6">
                <h2 class="footer-heading mb-4">Follow Us</h2>
                <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <h2 class="footer-heading mb-4">Subscribe Newsletter</h2>
            <form action="#" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control border-secondary text-white bg-transparent" placeholder="Enter Email" aria-label="Enter Email" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-primary text-white" type="button" id="button-addon2">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <div class="border-top pt-5">
              <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
            </div>
          </div>
          
        </div>
      </div>
    </footer>
  <!-- </div> -->

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>


  <script>
    $('form').submit( function(event) {

        document.getElementById("overlay").style.display = "block";
        var form = this;
        event.preventDefault();

        setTimeout( function () { 
            form.submit();
        }, 500);
    }); 
  </script>

  </body>
</html>