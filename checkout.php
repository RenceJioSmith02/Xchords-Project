<?php

    session_start();

    include 'login/login.php'; 
    include 'header&footer/header.php';

    require_once 'database.php';
    $database = new Database();
    $connection = $database->getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- custom css file link  -->
    <link rel="stylesheet" href="relativeFiles/css/checkout.css">
    <link rel="stylesheet" href="relativeFiles/css/style.css">

    <!-- 
      - google font link
    -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- <link rel="stylesheet" href="../relativeFiles/css/style.css"> -->

</head>
<body>

<div class="shipping-container">
    
    <!-- upper-form -->

    <div id="open-ModalAddress">Add New Address</div>

    <!-- <div id="address-overlay"></div> -->

    <form action="">
        <div id="address-modal">
            <div class="address-modal-content">
                <span class="address-close">&times;</span>
                
                <div class="row address">
                    <div class="col">

                    <form action="" style="background: red;">
                        <h3 class="title">billing address</h3>

                        <div class="inputBox">
                            <span>full name :</span>
                            <input type="text" placeholder="Rence Jio Bal-ot">
                        </div>
                        <div class="inputBox">
                            <span>email :</span>
                            <input type="email" placeholder="example@example.com">
                        </div>
                        <div class="inputBox">
                            <span>address :</span>
                            <input type="text" placeholder="room - street - locality">
                        </div>
                        <div class="inputBox">
                            <span>city :</span>
                            <input type="text" placeholder="Nueva Ecija">
                        </div>

                        <div class="flex">
                            <div class="inputBox">
                                <span>state :</span>
                                <input type="text" placeholder="Philippines">
                            </div>
                            <div class="inputBox">
                                <span>zip code :</span>
                                <input type="text" placeholder="3119">
                            </div>
                        </div>
                        
                        <input type="submit" value="SAVE" name="save-btn" class="save-btn" id="save-btn"/>
                    </form>

                    </div>
                </div>

            </div>
        </div>
    </form>


    <!-- lower form -->

    <form action="">

        <div class="row">

            <div class="col" style="margin-bottom: 20px;">

                <h3 class="title">payment</h3>

                <div class="inputBox">
                    <span>cards accepted :</span>
                    <img src="./relativeFiles/images/logo&bg/card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>name on card :</span>
                    <input type="text" placeholder="Rence Jio Bal-ot">
                </div>
                <div class="inputBox">
                    <span>credit card number :</span>
                    <input type="number" placeholder="1111-2222-3333-4444">
                </div>
                <div class="inputBox">
                    <span>exp month :</span>
                    <input type="text" placeholder="january">
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>exp year :</span>
                        <input type="number" step="1" min="2024" placeholder="2024">
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" placeholder="1234">
                    </div>
                </div>

            </div>
    
        </div>

        <div class="shiping-items">
        <?php

            $query = "SELECT c.cartID, p.Pname, p.Pprice, p.Pimage, c.quantity
            FROM `cart` as c
            INNER JOIN `products` AS p
            ON p.PID=c.PID";

            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {

            echo "<ul class='cart-lists'>";
            while ($row = mysqli_fetch_assoc($result)) {

        ?>
                <li class="cart-item">
                    <div class="prod-img">
                        <img src="./relativeFiles/images/E-guitars/<?php echo $row['Pimage'];?>" alt="<?php echo $row['Pimage'];?>" loading="lazy" width="40px">
                    </div>

                    <div class="text-prod-infos">
                        <div class="upper-part">
                            <p class="prod-name"><?php echo $row['Pname'];?></p>
                        </div>

                        <div class="lower-part">
                            <data class="prod-price" value="<?php echo $row['Pprice'];?>">&#8369;<?php echo $row['Pprice'];?></data>
                            <p class="prod-quantity">x<?php echo $row['quantity']; ?></p>
                        </div>
                    </div>

                </li>
        <?php    
            }       
            echo "</ul>";
        ?>
    </div>

    <?php

        // Calculate total
        $query = "SELECT SUM(p.Pprice * c.quantity) + 200 AS total 
            FROM cart as c
            INNER JOIN products as p
            ON p.PID = c.PID";
            
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
    ?>
        <div class="prod-total">
            <p>Shipping fee: &#8369;200</p>
            <data value="<?php echo ($row['total'] > 9999) ? ($row['total'] - 200) : $row['total']; ?>">
            Total: &#8369;<?php echo ($row['total'] > 9999) ? ($row['total'] - 200) : $row['total']; ?></data>
        </div>

    <?php
        }
    ?>

        <input type="submit" name="order-btn" value="ORDER NOW" class="order-btn">

    </form>

</div>    
    


    <!-- footer -->
    <?php include 'header&footer/footer.html'; ?>
    

    <script>
       document.getElementById('open-ModalAddress').addEventListener('click', function() {
        // document.getElementById('address-overlay').style.display = 'block';
        document.getElementById('address-modal').style.display = 'block';
        });

        document.querySelector('.address-close').addEventListener('click', function() {
        // document.getElementById('address-overlay').style.display = 'none';
        document.getElementById('address-modal').style.display = 'none';
        });
    </script>

      
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