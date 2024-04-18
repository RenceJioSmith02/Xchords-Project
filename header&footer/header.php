<?php

  require_once './admin_panel/backend.php';
  $connect = new Connect_db();
  $query = new Queries($connect);
  
  
  $toSearch = "";
  if (isset($_GET['search'])) {
    $toSearch = $_GET['search'];
  }

  if (isset($_GET['orderRecieved'])) {
    $query->insertSales($_GET['orderRecieved']);

    $query->updateSalesChart (1);
    $query->updateSalesChart (2);
    $query->updateSalesChart (3);
    $query->updateSalesChart (4);

    $query->deleteOrder($_GET['orderRecieved']);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- Boxiocns CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

  <!-- Include SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>

  <!-- Include SweetAlert2 library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<header class="header" data-header>
    <div class="container">

      <div class="overlay" data-overlay></div>

      <a href="#" class="logo">
        <img src="relativeFiles/images/logo&bg/logo.png" alt="Xxchord" width="130" height="31">
      </a>

      <!-- search here dati -->
      <div class="header-actions">

          <button class="header-action-btn search" id="show-search" onclick="openSearch('true')">
            <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
            <p class="header-action-label"> Search</p>
          </button>

        <div class="setting-container">

          <button class="header-action-btn" <?php echo (isset($_SESSION['type']) && $_SESSION['type'] == 'user') ? "onclick=\"openPopup('accountSetting')\"" : "id='show-login1'"; ?>">
            <?php 
              if (isset($_SESSION['type']) && $_SESSION['type'] == 'user') {
                echo "<ion-icon name='person-circle-outline' class='hide'></ion-icon>
                  <p class='header-action-label hide'>Account</p>";
              } else {
                echo "<ion-icon name='person-outline'></ion-icon>
                <p class='header-action-label'>Sign In</p>";
              }
            ?>
          </button>
          <div class="account-option"  id="accountOption"> 
              <div class="account-btn">
                <button onclick="openPopup('orders')"><i class='bx bx-receipt'></i>Orders</button>
              </div>

              <div class="account-btn">
                <button onclick="openPopup('logout')"><i class='bx bx-log-out'></i>Logout</button>
              </div>
          </div>

        </div>
        
        <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'user') { ?>
          <button class="header-action-btn" id="show-cart">
            <ion-icon name="cart-outline" aria-hidden="true"></ion-icon>

            <p class="header-action-label">Cart</p>

            <div class="btn-badge green" id="numCarts">
              
            </div>

          </button>
        <?php } ?>


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

          <button class="nav-close-btn" data-nav-close-btn aria-label="Close Menu">
            <ion-icon name="close-outline"></ion-icon>
          </button>

        </div>

        <ul class="navbar-list">

          <div class="header-search desktop">

            <form action="productDetails.php" method="GET" enctype="multipart/form-data" class="form">
              <input type="text" id="search" name="search" placeholder="Search Product..." class="input-field" value="<?php echo $toSearch ?>" required>
      
              <button type="submit" name=searchBtn class="search-btn" aria-label="Search">
                <ion-icon name="search-outline"></ion-icon>
              </button>
            </form>

          </div>

          <li>
            <a href="index.php" class="navbar-link"><ion-icon name="home-outline"></ion-icon>Home</a>
          </li>

          <li>
            <a href="#blog" class="navbar-link"><ion-icon name="information-circle-outline"></ion-icon>About</a>
          </li>

          <li>
            <a href="products.php?prodPage=true" class="navbar-link"><ion-icon name="cube-outline"></ion-icon>Products</a>
          </li>

          <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'user') { ?>
              <li>
                <a href="#" class="navbar-link account-btn" onclick="openPopup('orders')"><ion-icon name="newspaper-outline"></ion-icon>Orders</a>
              </li>
              <li>
                  <div class="profile-details">
                      <button onclick="openPopup('logout')">
                        <i class='bx bx-log-out'></i>
                      </button>
                      <div class="name-job">
                          <div class="profile_name"><?php echo $_SESSION['Uname'] ?></div>
                      </div>
                  </div>
              </li>
          <?php } ?>


        </ul>
      </nav>

      <?php
        $result = $query->selectOrder();
      ?>

      <div id="popup-order" class="popup-order">

        <center><h2>Orders</h2></center>

        <ul class="orders-container">
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <li class="order-list">
              <div class="o-image">
                <img src="<?php echo $row['Pimage']; ?>" alt="">
                <p><?php echo $row['Pname']; ?></p>
              </div>
              <div class="price">
                <p>&#8369;<?php echo $row['Pprice']; ?></p>
              </div>
              <div class="quantity">
                <span><?php echo $row['quantity']; ?></span>
              </div>
              <button class="received-btn" onclick="location.href='<?php echo $_SERVER['PHP_SELF'] . '?orderRecieved=' . $row['orderID'] ?>'">Received</button>
            </li>

          <?php } ?>
        </ul>

        <div class="order-close">
          <button onclick="closePopup()">Close</button>
        </div>

      </div>

      <div id="overlay" class="overlay"></div>

    </div>

    <div class="header-search mobile">

      <form action="productDetails.php" method="GET" enctype="multipart/form-data" class="form">
        <input type="text" id="search-mobile" name="search" placeholder="Search Product..." class="input-field" value="<?php echo $toSearch ?>" required>

        <button type="submit" name=searchBtn class="search-btn" aria-label="Search">
          <ion-icon name="search-outline"></ion-icon>
        </button>
      </form>

    </div>
      
  </header>


  <script>
    function openSearch(open) {
      if (open = true) {
        document.querySelector('.header-search.mobile').classList.toggle("active");
      }
    }

    function openPopup(action) {
      var title, content;
      if (action === 'orders') {
        

        // document.getElementById('popupTitle').innerText = title;
        // document.getElementById('popupContent').innerText = content;
        
        document.getElementById('popup-order').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';

      } else if (action === 'logout') {
          Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!'

          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href='<?php echo "index.php?logout=true"?>';
              //alert("Logout successful!"); // For demonstration, you can replace this with actual logout action
            }
          })
      } else if (action = 'accountSetting') {
        document.getElementById('accountOption').classList.toggle("active");
      } 
    }

    function closePopup() {
      document.getElementById('popup-order').style.display = 'none';
      document.getElementById('overlay').style.display = 'none';
    }
  </script>

           
</body>
</html>

  
