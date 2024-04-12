<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Xchords - Guitar Shop</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./relativeFiles/css/style.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

  <!-- #HEADER -->

  <?php include 'header&footer/header.php'; ?>
  <?php include 'login/login.php'; ?>


  <main>
    <article>

      <!-- 
        - #welcome
      -->

      <section class="welcome" id="home" style="background-image: url('./relativeFiles/images/logo&bg/acoustic.png')">
        <div class="container">

          <div class="welcome-content">

            <p class="welcome-subtitle">Play Everyday</p>

            <h2 class="h1 welcome-title">Shop Guitars Online</h2>

            <button class="btn btn-primary"  onclick="location.href='index.php#service';">Shop Now</button>

          </div>

        </div>
      </section>





      <!-- 
        - #SERVICE
      -->

      <section class="service" id="service">
        <div class="container">

          <ul class="service-list">

            <li class="service-item">
              <div class="service-item-icon">
                <img src="./relativeFiles/images/service-icon-2.svg" alt="Service icon">
              </div>

              <div class="service-content">
                <p class="service-item-title">Easy Returns</p>

                <p class="service-item-text">30 Day Returns Policy</p>
              </div>
            </li>

            <li class="service-item">
              <div class="service-item-icon">
                <img src="./relativeFiles/images/service-icon-3.svg" alt="Service icon">
              </div>

              <div class="service-content">
                <p class="service-item-title">Secure Payment</p>

                <p class="service-item-text">100% Secure Gaurantee</p>
              </div>
            </li>

            <li class="service-item">
              <div class="service-item-icon">
                <img src="./relativeFiles/images/service-icon-1.svg" alt="Service icon">
              </div>

              <div class="service-content">
                <p class="service-item-title">Free Shipping</p>

                <p class="service-item-text">Order Over &#8369;9,999</p>
              </div>
            </li>

            <li class="service-item">
              <div class="service-item-icon">
                <img src="./relativeFiles/images/service-icon-4.svg" alt="Service icon">
              </div>

              <div class="service-content">
                <p class="service-item-title">Special Support</p>

                <p class="service-item-text">24/7 Dedicated Support</p>
              </div>
            </li>

          </ul>

        </div>
      </section>



      <!-- 
        - #PRODUCT
      -->

      <section class="section product">
        <div class="container">

          <h2 class="h2 section-title">New Arival Guitars</h2>

          <ul class="product-list">

          <?php

            $database = new Database();
            $connection = $database->getConnection();
                
                if (isset($_POST['filterValue'])) {
                    $filterValue = $_POST['filterValue'];
                    $query = "SELECT * FROM `products`
                            INNER JOIN `category`
                            ON category.CID = products.CID
                            WHERE category.CID = '$filterValue'";
                } elseif (isset($_POST['input'])) {
                
                    $input = $_POST['input'];

                    $query = "SELECT * FROM `products` WHERE `Pname` LIKE '%$input%'";
                    $result = mysqli_query($connection, $query);
                } else {
                    $query = "SELECT * FROM `products`";
                }

                $result = mysqli_query($connection, $query);

                if (mysqli_num_rows($result) > 0) {
                    for ($i = 0; $i < 6 && $row = mysqli_fetch_assoc($result); $i++) {

                        ?>


                            <li>
                                <div class="product-card">

                                    <figure class="card-banner">

                                    <a href="#">
                                        <img src="relativeFiles/images/E-guitars/<?php echo $row['Pimage'] ?>" alt="<?php echo $row['Pname'] ?>" loading="lazy" width="800"
                                        height="1034" class="w-100">
                                    </a>

                                    <div class="card-actions">

                                        <button class="card-action-btn" aria-label="Quick view" onclick="location.href='productDetails.php?Pname=<?php echo $row['Pname'] ?>';">
                                        <ion-icon name="eye-outline"></ion-icon>
                                        </button>

                                        <!-- cart btn -->
                                        <button 
                                        <?php 
                                            if (isset($_SESSION['type']) && $_SESSION['type'] == 'user') {
                                                echo "class='card-action-btn cart-btn add-to-cart'";
                                            } else {
                                                echo "class='card-action-btn cart-btn' onclick='trylang()'";
                                            }
                                        ?>
                                        >
                                            <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>

                                            <p>Add to Cart</p>
                                        </button>

                                    </div>

                                    </figure>

                                    <div class="card-content">
                                        <h3 class="h4 card-title">
                                            <a href="#"><?php echo $row['Pname'] ?></a>
                                        </h3>

                                        <div class="card-price">
                                            <p>&#8369;<?php echo $row['Pprice'] ?></p>
                                        </div>
                                    </div>

                                </div>
                            </li>

                        <?php   
                        
                        }
                    
                }
          ?>
          
        </ul>

          <button class="btn btn-outline" onclick="location.href='products.php';">View All Products</button>

        </div>
      </section>



  <!-- footer -->
  <?php include 'header&footer/footer.html'; ?>

      
  <!-- ajax -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


  <!-- 
    - custom js link
  -->
  <script src="./relativeFiles/js/script.js"></script>
  <script src="./relativeFiles/js/login.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>