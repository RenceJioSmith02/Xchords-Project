<?php
    session_start();

    require_once 'database.php';
    $database = new Database();
    $connection = $database->getConnection();

// update quantity
if(isset($_POST['quantity']) && isset($_POST['cartID'])) {
    $quantity = intval($_POST['quantity']);
    $cartID = intval($_POST['cartID']);

    // Ensure quantity is at least 1
    if ($quantity < 1) {
        $quantity = 1;
    }

    // $query = "SELECT Pprice FROM `cart` WHERE cartID = ?";

    $query = "SELECT p.Pprice, c.quantity
            FROM products as p
            INNER JOIN cart as c
            ON c.PID = p.PID
            WHERE c.cartID = ? AND c.accountID = '".$_SESSION['UID']."'";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $cartID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $current_quantity = $row['quantity'];

    // Ensure quantity is at least 1
    $new_quantity = max(1, $current_quantity + $quantity);

    // Update quantity in the cart table
    $query = "UPDATE `cart` SET `quantity` = ? WHERE `cartID` = ? AND `accountID` = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("iii", $quantity, $cartID, $_SESSION['UID']);
    $stmt->execute();

        // Calculate total
    $query = "SELECT SUM(p.Pprice * c.quantity) AS total 
            FROM cart as c
            INNER JOIN products as p
            ON p.PID = c.PID
            WHERE c.accountID = ?";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $_SESSION['UID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
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
?>
