<?php
  session_start();
  require_once "./admin_panel/backend.php";
  $connect = new Connect_db();
  $query = new Queries($connect);

  if (isset($_SESSION['UID']) && ($query->checkUserExist($_SESSION['UID']) <= 0)) {
    session_destroy();
    header("Location: index.php");
  }
  
  if (isset($_SESSION['type']) && $_SESSION['type'] == 'admin') {
      header("Location: ./admin_panel/admin.php");
  }

  include 'login/login.php'; 
  include 'header&footer/header.php';

  if (isset($_GET['btnProductId'])) {
    $productId = $_GET['btnProductId'];
  }

  if (isset($_GET['msg']) && $_GET['msg']=='order_success') {
    $msg = "Order Success!";
    $icon = "success";
    Accounts::alertMessage($msg, $icon);
  }
  if (isset($_GET['msg']) && $_GET['msg']=='order_failed') {
    $msg = "Order Failed!";
    $icon = "warning";
    Accounts::alertMessage($msg, $icon);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- 
      - custom css link
    -->
    <link rel="stylesheet" href="relativeFiles/css/style.css">

    <!-- 
      - google font link
    -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

    <!-- #PRODUCT-->
      <section class="section product">
        <div class="container">

          <h2 class="h2 section-title">Xchords Guitars</h2>

          <ul class="filter-list">

            <li>
              <button class="1 filter-btn" id="acousticBtn" data-filter="1">Acoustic</button>
            </li>

            <li>
              <button class="2 filter-btn" id="electricBtn" data-filter="2">Electric</button>
            </li>

            <li>
              <button class="3 filter-btn" id="bassBtn" data-filter="3">Bass</button>
            </li>

            <li>
              <button class="4 filter-btn" id="ukaleleBtn" data-filter="4">Ukalele</button>
            </li>

          </ul>

          <ul class="product-list" id="results">
            <!-- result from ajax ay ma pi print dine -->
          </ul>

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