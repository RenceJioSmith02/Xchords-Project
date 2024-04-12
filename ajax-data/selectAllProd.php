<?php
    session_start();
    
    include '../database.php';
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
            $num_rows =  mysqli_num_rows($result);
            if ($num_rows < 1) {
                echo "<h3>No Search Found...</h3>"; 
            }
        } else {
            $query = "SELECT * FROM `products`";
        }

        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

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