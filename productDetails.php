<?php
    require_once "./admin_panel/backend.php";
    $connect = new Connect_db();
    $query = new Queries($connect);

    $toSearch="";
    if (isset($_GET['searchBtn'])) {
        $toSearch = $_GET['search'];
        
    } elseif (isset($_GET['Pname'])) {
        $toSearch = $_GET['Pname'];
    }
    $result = $query->Searchproduct($toSearch);
    $num_rows =  mysqli_num_rows($result);

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

</head>
<body>

    <!-- #HEADER -->
    <?php include 'header&footer/header.php'; ?>
    <?php include 'login/login.php'; ?>


    <!-- #PRODUCT-->
    <section class="section product">
        <div class="container">

            <ul class="filter-list">

                <?php
                    if ($num_rows < 1) {
                        echo "<h3>No Search Found...</h3>"; 
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                
                    ?>
                        <li class="product-card view-itemDetails">
                            <div class="box-detail image">
                                <img src="<?php echo $row['Pimage'] ?>" alt="guitar1" loading="guitar1" class="img">
                                <div class="box-specs">
                                    <button class="">
                                        <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                                        <p>Add to Cart</p>
                                    </button>


                                    <!-- cart btn -->
                                    <button 
                                    <?php 
                                        if (isset($_SESSION['type']) && $_SESSION['type'] == 'user') {
                                            echo "class='btn btn-outline add-to-cart'";
                                        } else {
                                            echo "class='btn btn-outline' onclick='trylang()'";
                                        }
                                    ?>
                                    >
                                        <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>

                                        <p>Add to Cart</p>
                                    </button>

                                </div>
                            </div>
                            <div class="box-detail specs">
                                <div class="card-content">
                                    <h3 class="h4 card-title">
                                        <a href="#"><?php echo $row['Pname'] ?></a>
                                    </h3>
                                    <div class="card-price">
                                        <p>&#8369;<?php echo $row['Pprice'] ?></p>
                                    </div>
                                </div>
                                <br>
                                <h3>About This Product</h3>

                                <p> <?php echo $row['Pdescription'] ?> </p>

                                <h3>Specification</h3>
                                <ul>
                                    <li>
                                        <strong>Body Material:</strong>
                                        <p><?php echo $row['bodymaterial'] ?></p>
                                    </li>
                                    <li>
                                        <strong>Body Finish:</strong>
                                        <p><?php echo $row['bodyfinish'] ?></p>
                                    </li>
                                    <li>
                                        <strong>Number of Frets:</strong>
                                        <p><?php echo $row['numoffrets'] ?></p>
                                    </li>
                                    <li>
                                        <strong>Fretboard Material:</strong>
                                        <p><?php echo $row['fretboardmaterial'] ?></p>
                                    </li>
                                    <li>
                                        <strong>Strings:</strong>
                                        <p><?php echo $row['strings'] ?></p>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    <?php   
                                
                            }
                        }
                ?>

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