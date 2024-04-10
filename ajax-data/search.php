<?php
    include '../database.php';
    $database = new Database();
    $connection = $database->getConnection();

    if (isset($_POST['input'])) {
        
        $input = $_POST['input'];

        $query = "SELECT * FROM `products` WHERE `Pname` LIKE '%$input%'";
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

                            <button class="card-action-btn cart-btn add-to-cart">
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
                            <data value="<?php echo $row['Pprice'] ?>">&#8369;<?php echo $row['Pprice'] ?></data>

                            <!-- <data value="65.00">&#8369;65.00</data> -->
                        </div>
                        </div>

                    </div>
                </li>

            <?php   
            
            }
        }

    }
?>