<?php

    session_start();

    require_once 'database.php';
    $database = new Database();
    $connection = $database->getConnection();
    
    if(isset($_POST['productName'])) {
        $productName = $_POST['productName'];
        addtoCart($productName, $connection);

        echo " <script>alert('Item Added to data: $productName');</script>";

    } elseif (isset($_POST['DeleteProductName'])) {
        $DeleteProductName = $_POST['DeleteProductName'];
        deletetoCart($DeleteProductName, $connection);
    }

    function addtoCart($productName, $connection) {

        // ok
        $query = "SELECT p.Pname, cartID, quantity 
                    FROM `cart` as c
                    INNER JOIN  products as p
                    ON c.PID=p.PID
                    WHERE p.Pname = '$productName'";
                    
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);

        if (($no = mysqli_num_rows($result)) > 0) {
            $Updated_quantity = $row["quantity"] + 1;

            // ok
            $query = "UPDATE `cart` SET `quantity`='$Updated_quantity' WHERE cartID = '".$row['cartID']."'";
            mysqli_query($connection, $query);

        } else {
            // ok
            $query = "INSERT INTO cart (PID, quantity)
            SELECT PID, 1
            FROM products as p
            WHERE p.Pname = '$productName'";
        }

        mysqli_query($connection, $query);
    }

    function deletetoCart($DeleteProductName, $connection) {
        
        // ok
        $query = "SELECT PID FROM `products` WHERE Pname = '$DeleteProductName'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);

        $PID = $row['PID'];

        $query = "DELETE FROM `cart` WHERE PID = '$PID'";
        mysqli_query($connection, $query);
    }
        // ok
        $query = "SELECT c.cartID, p.Pname, p.Pprice, p.Pimage, c.quantity
                    FROM `cart` as c
                    INNER JOIN `products` AS p
                    ON p.PID=c.PID";

        $result = mysqli_query($connection, $query);
        $num_rows = mysqli_num_rows($result);
        
        // $_SESSION['numberofitems'] = $num_rows;

        if ($num_rows > 0) {

            echo "<ul class='cart-lists'>";
            while ($row = mysqli_fetch_assoc($result)) {
            
            ?>
                <li class="cart-item">

                    <div class="img-box">
                    <img src="./relativeFiles/images/E-guitars/<?php echo $row['Pimage'];?>" alt="<?php echo $row['Pimage'];?>" loading="lazy" width="40px">
                    <p><?php echo $row['Pname'];?></p>
                    </div>

                    <data value="<?php echo $row['Pprice'];?>">&#8369;<?php echo $row['Pprice'];?></data>

                    <div class="quantity-box">
                        <input type="number" id="<?php echo $row['cartID']; ?>" value="<?php echo $row['quantity']; ?>" name="quantity" min="1">
                    </div>

                    <button class="delete-item">
                        <ion-icon name="trash-outline"></ion-icon>
                    </button>
                </li>
            <?php    
            }       
            echo "</ul>";

                // Calculate total
                $query = "SELECT SUM(p.Pprice * c.quantity) AS total 
                        FROM cart as c
                        INNER JOIN products as p
                        ON p.PID = c.PID";
                        
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_assoc($result);
            ?>
                <div class="cart-buttons">
                    <data value="<?php echo $row['total']; ?>">Total: &#8369;<?php echo $row['total']; ?></data>
                    <button class="btn btn-thin btn-outline" onclick="location.href='checkout.php'" aria-label="Quick view" style="padding: 0 50px;">
                        <ion-icon name="bag-check-outline"></ion-icon>
                        <p>Checkout</p>
                    </button>
                </div>
            
            <?php

        }

    $connection->close();
?>