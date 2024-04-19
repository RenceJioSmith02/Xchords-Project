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

    $accountID =  $_SESSION['UID'];

    if (isset($_POST['save-btn'])) {
        $fullname = $_POST['fullname'];
        $phonenum = $_POST['phonenum'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip_code = $_POST['zipcode'];

        $queryship = new ShippingInfo($connect, $fullname, $phonenum, $address, $city, $state, $zip_code,'','');

        $addressExist = $query->Checkaddress($accountID);
        if ($addressExist) {
            $result =  $queryship->updateShipDetails($accountID);
        } else {
            $result =  $queryship->insertShipDetails($accountID);
        }

        if ($result != 0) {
            $_SESSION['fkey'] = $result;
        }else {
            echo "<script> alert('Error in saving details'); </script>";
        }
        
    }

        if (isset($_POST['order-btn'])) {
            $nameoncard = $_POST['nameoncard'];
            $cardnumber = $_POST['cardnum'];
            
            $querypay = new ShippingInfo($connect, '', '', '', '', '', '', $nameoncard, $cardnumber);
            
            $row = $query->getshippingID($_SESSION['UID']);
            
            $paymentExist = null;
            if (isset($row['shippingID'])) {
                $shippingID = $row['shippingID'];
                $paymentExist = $query->Checkpayment($shippingID);
            
                if ($paymentExist) {
                    $result = $querypay->updatePayment($shippingID);
                } else {
                    $result = $querypay->insertPayment($shippingID);
                }
            }
            
            $addressExist = $query->Checkaddress($accountID);
            if ($addressExist) {

                $result = $query->insertOrder($accountID);
            
                if ($result) {
                    $query->deleteCart($accountID);
                    header("location: products.php?msg=order_success");
                } else {
                    header("location: products.php?msg=order_failed");
                }
                
            }
            else {
                echo "<script>alert('plaese set up your address.')</script>";
            }
        }


    

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


    <!-- #HEADER -->
    
    <?php include 'header&footer/header.php'; ?>
    <?php include 'login/login.php'; ?>

<div class="shipping-container">
    
    <!-- upper-form -->

    <div id="open-ModalAddress">Add New Address</div>

    <!-- <div id="address-overlay"></div> -->

    <form action="" method="post">
        <?php
            // if (isset($_SESSION['userID'])) {
            //     $userID = $_SESSION['userID'];
            // }
            $userID = 5;
            $row = $query->Checkaddress($_SESSION['UID']);

            if (isset($row['shippingID'])) {
                $payID = $row['shippingID'];
            }
            
        ?>
        <div id="address-modal">
            <div class="address-modal-content">
                <span class="address-close">&times;</span>
                
                <div class="row address">
                    <div class="col">

                    <form action="" style="background: red;">
                        <h3 class="title">billing address</h3>

                        <div class="inputBox">
                            <input type="hidden" value="<?php if (isset($row['shippingID'])) echo $row['shippingID']; ?>" name="ID">
                            <span>full name :</span>
                            <input type="text" name="fullname" value="<?php if (isset($row['fullname'])) echo $row['fullname']; ?>" placeholder="Rence Jio Smith Bal-ot" required>
                        </div>

                        <div class="inputBox">
                            <span>Phone number:</span>
                            <input type="number" name="phonenum" value="<?php if (isset($row['phonenum'])) echo $row['phonenum']; ?>" placeholder="09**********" required>
                        </div>

                        <div class="inputBox">
                            <span>address :</span>
                            <input type="text" name="address" value="<?php if (isset($row['address'])) echo $row['address']; ?>" placeholder="room - street - locality" required>
                        </div>
                        <div class="inputBox">
                            <span>city :</span>
                            <input type="text" value="<?php if (isset($row['city'])) echo $row['city']; ?>" name="city" placeholder="San Jose" required>
                        </div>

                        <div class="flex">
                            <div class="inputBox">
                                <span>state :</span>
                                <input type="text" name="state" value="<?php if (isset($row['state'])) echo $row['state']; ?>" placeholder="Philippines" required>
                            </div>
                            <div class="inputBox">
                                <span>zip code :</span>
                                <input type="text" name="zipcode" value="<?php if (isset($row['postalcode'])) echo $row['postalcode']; ?>" placeholder="3119" required>
                            </div>
                        </div>
                        
                        <input type="submit" value="SAVE" name="save-btn" class="save-btn" id="save-btn"/>
                    

                    </div>
                </div>

            </div>
        </div>
    </form>


    <!-- lower form -->

    <form action="" method="post">
        <div class="row">

            <div class="col" style="margin-bottom: 20px;">

                <h3 class="title">payment</h3>

                <div class="inputBox">
                    <span>cards accepted :</span>
                    <img src="./relativeFiles/images/logo&bg/card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>name on card :</span>
                    <input type="text" name="nameoncard" placeholder="Jhero Antonio" required>
                </div>
                <div class="inputBox">
                    <span>credit card number :</span>
                    <input type="text" name="cardnum" placeholder="1111-2222-3333-4444" pattern="[0-9\-]*" title="Please enter numbers and dashes only" required>
                </div>

            </div>
    
        </div>
        <div class="shiping-items">
        <?php

            // oop query na

            $result = $query->Getusercart();

            if (mysqli_num_rows($result) > 0) {

            echo "<ul class='cart-lists'>";
            while ($row = mysqli_fetch_assoc($result)) {

        ?>
                <li class="cart-item">
                    <div class="prod-img">
                        <img src="<?php echo $row['Pimage'];?>" alt="<?php echo $row['Pimage'];?>" loading="lazy" width="40px">
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

    <?php //ginawa kong oop query

        $result = $query->CalculateTotal();
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