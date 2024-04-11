
<!--  #HEADER -->
<?php
  $toSearch = "";
    if (isset($_GET['search'])) {
      $toSearch = $_GET['search'];
    }   

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<header class="header" data-header>
    <div class="container">

      <div class="overlay" data-overlay></div>

      <a href="#" class="logo">
        <img src="relativeFiles/images/logo&bg/logo.png" alt="Xxchord" width="130" height="31">
      </a>

      <!-- search here dati -->

      <div class="header-actions">

        <button class="header-action-btn" id="show-login">
          <ion-icon name="person-outline" aria-hidden="true"></ion-icon>

          <p class="header-action-label">Sign in</p>
        </button>

        <button class="header-action-btn" id="show-cart">
          <ion-icon name="cart-outline" aria-hidden="true"></ion-icon>

          <p class="header-action-label">Cart</p>

          <!-- <?php
            if (isset( $_SESSION["numberofitems"])) {
              echo "<div class='btn-badge green' aria-hidden='true' id='numCarts'>";
                echo $_SESSION['numberofitems'];
              echo "</div>";
            }
          ?> -->
          <div class="btn-badge green" id="numCarts">
            
          </div>

        </button>


      </div>

      <!-- cart -->
      <div class="cart-overlay" cart-overlay></div>
      <div class="cart-container">

        <div class="close-btn"><span>&times</span></div>
          
        <h2>Shopping Cart</h2>

        <!-- cart lists -->
        <div id="cart-items">
            <!-- yung mga nasa cart ma priprint dito from ajax -->
        </div>

        <!-- total -->
        <div id="total-box">
            <!-- total from ajax print din dine -->
        </div>

      </div>

      <button class="nav-open-btn" data-nav-open-btn aria-label="Open Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <nav class="navbar" data-navbar>

        <div class="navbar-top">

          <a href="#" class="logo">
            <img src="relativeFiles/images/logo&bg/logo.png" alt="Xxchord" width="130" height="31">
          </a>

          <button class="nav-close-btn" data-nav-close-btn aria-label="Close Menu">
            <ion-icon name="close-outline"></ion-icon>
          </button>

        </div>

        <ul class="navbar-list">

          <div class="header-search ">

            <form action="productDetails.php" method="GET" enctype="multipart/form-data" class="form">
              <input type="text" id="search" name="search" placeholder="Search Product..." class="input-field" value="<?php echo $toSearch ?>" required>
      
              <button type="submit" name=searchBtn class="search-btn" aria-label="Search">
                <ion-icon name="search-outline"></ion-icon>
              </button>
            </form>

          </div>

          <li>
            <a href="index.php" class="navbar-link">Home</a>
          </li>

          <li>
            <a href="#blog" class="navbar-link">About</a>
          </li>

          <li>
            <a href="products.php?prodPage=true" class="navbar-link">Products</a>
          </li>

          <li>
            <a href="#" class="navbar-link">Contact</a>
          </li>

        </ul>

      </nav>

    </div>
  </header>


</body>
</html>

  
