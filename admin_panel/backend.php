<?php
    class Connect_db {
        private $servername = "localhost";
        private $username ="root";
        private $password = "";
        private $database = "e-commercedb";
        private $conn;

        function  __construct() {

            $conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
            

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $this->conn=$conn;
        }

        public function getConn(){  
            return $this->conn;
        }
        
        function closeConn(){
            $this->conn->close();
        }    
                
    }

    class Queries {
        private $connection;

        public function __construct(Connect_db $connect) {
            $this->connection = $connect->getConn();
        }

        public function Print($start,$limit,$tablename,$primarykey) {
            switch ($tablename) {
                case 'products':
                    $sql = "SELECT p.PID, p.Pname, c.category, p.Pprice, p.Pdescription, p.Pimage 
                    FROM " . $tablename . " AS p 
                    JOIN category AS c ON p.CID = c.CID 
                    ORDER BY p.PID ASC LIMIT ?, ?";

                    break;
                case 'orders':
                    $sql = "SELECT o.orderID, p.PID, a.name, p.Pname, c.quantity , p.Pprice 
                    FROM orders AS o
                        JOIN accounts AS a ON o.accountID = a.accountID
                            JOIN cart as c ON c.accountID = a.accountID
                            JOIN products AS p ON  c.PID = p.PID
                                ORDER BY o.productID ASC LIMIT  ?, ?";
                    break;
                case 'sales':
                    $sql = "SELECT * FROM sales
                    ORDER BY salesID ASC LIMIT  ?, ?";
                    break;
                case 'accounts':
                    $sql = "SELECT * FROM " . $tablename . " ORDER BY " . $primarykey . " ASC LIMIT  ?, ?";
                    break;
                case 'acoustic':
                    $sql = "SELECT p.* , c.category FROM products as p
                            JOIN category as c
                            ON c.CID = p.CID
                            WHERE p.CID = '1'
                            ORDER BY PID ASC LIMIT  ?, ?";
                    break;
                case 'electric':
                    $sql = "SELECT p.* , c.category FROM products as p
                            JOIN category as c
                            ON c.CID = p.CID
                            WHERE p.CID = '2'
                            ORDER BY PID ASC LIMIT  ?, ?";
                    break;
                case 'bass':
                    $sql = "SELECT p.* , c.category FROM products as p
                            JOIN category as c
                            ON c.CID = p.CID
                            WHERE p.CID = '3'
                            ORDER BY PID ASC LIMIT  ?, ?";
                    break;
                case 'ukalele':
                    $sql = "SELECT p.* , c.category FROM products as p
                            JOIN category as c
                            ON c.CID = p.CID
                            WHERE p.CID = '4'
                            ORDER BY PID ASC LIMIT  ?, ?";
                    break;

                default:
                    # code...
                    break;
            }
            

            $stmt  = $this->connection->prepare($sql);

            $stmt->bind_param("ii", $start, $limit);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result;
        }

        public  function getTotalRows($tablename){
            $stmt = $this->connection->prepare("SELECT COUNT(*) AS total FROM products");
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            
            return $row["total"];
        }

        public function deleteProduct($productId)
        {
            $stmt_select = $this->connection->prepare("SELECT Pimage FROM products WHERE PID = ?");
            $stmt_select->bind_param("i", $productId);
            $stmt_select->execute();
            $result_select = $stmt_select->get_result();
            $row = $result_select->fetch_assoc();
            $imagePath = $row['Pimage'];
        
            // Delete the image path from the database
            $stmt_delete = $this->connection->prepare("DELETE FROM products WHERE PID = ?");
            $stmt_delete->bind_param("i", $productId);
            $result = $stmt_delete->execute();
        
            // Delete the image file from the folder
            if ($imagePath && file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            return $result;
        }

        public function selectAll($tablename,$id) {
            $query="SELECT * FROM ".$tablename." WHERE productID=?";
            $stmt =  $this->connection->prepare($query);
            $stmt->bind_param('i',$id);
            $stmt->execute();
            $results = $stmt->get_result();

            return $results;
        }

        public function printUpdateproducts($id){
            $stmt = $this->connection->prepare("SELECT * FROM products JOIN specs ON products.PID= specs.productID WHERE products.PID = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $results = $stmt->get_result();
        
            return $results;
        }

        public function getProductImageById($id) {
            $stmt_select = $this->connection->prepare("SELECT Pimage FROM products WHERE PID = ?");
            $stmt_select->bind_param("i", $id);
            $stmt_select->execute();
            $result_select = $stmt_select->get_result();
            $row = $result_select->fetch_assoc();
        
            return $row['Pimage'];
        }
        
        public function Getusercart(){
            $query = "SELECT c.cartID, p.Pname, p.Pprice, p.Pimage, c.quantity
            FROM `cart` as c
            INNER JOIN `products` AS p
            ON p.PID=c.PID
            WHERE c.accountID = '".$_SESSION['UID']."'";

            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $results = $stmt->get_result();

            return $results;
        }

        public function CalculateTotal(){
            $query = "SELECT SUM(p.Pprice * c.quantity) + 200 AS total 
            FROM cart as c
            INNER JOIN products as p
            ON p.PID = c.PID";
            
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $results = $stmt->get_result();

            return $results;
        }

        public function Searchproduct($toSearch){
            $query = "SELECT * 
            FROM `products` as p
            INNER JOIN specs as s
            ON s.productID = p.PID
            WHERE p.Pname LIKE '%$toSearch%'";

            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $results = $stmt->get_result();

            return $results;
        }

        public function Checkaddress($userID){
            $stmt = $this->connection->prepare("SELECT * FROM shipping WHERE accountID = ?");
            $stmt-> bind_param('s', $userID);
            $stmt-> execute();
            $res = $stmt-> get_result()-> fetch_assoc();
            return $res;
        }

        public function Checkpayment($payID){
            $stmt = $this->connection->prepare("SELECT * FROM payment WHERE shippingID = ?");
            $stmt-> bind_param('i', $payID);
            $stmt-> execute();
            $res = $stmt-> get_result()-> fetch_assoc();
            return $res;
        }

        public  function getshippingID($accountID){

            $stmt = $this->connection->prepare("SELECT shippingID FROM `shipping` WHERE `accountID`=?");
                $stmt->bind_param( "i",  $accountID );
                $stmt->execute();
                $result_select = $stmt->get_result()->fetch_assoc();
                return $result_select;
        }

        public function insertOrder($accountID) {
            $stmt = $this->connection->prepare("SELECT p.PID, c.quantity, s.shippingID
                                                FROM products as p
                                                INNER JOIN cart as c
                                                ON c.accountID = ?
                                                INNER JOIN shipping as s
                                                ON s.accountID = ?");
                $stmt->bind_param( "ii",  $accountID, $accountID);
                $stmt->execute();
                $row = $stmt->get_result()->fetch_assoc();
                
            $stmt =  $this->connection->prepare("INSERT INTO `orders` (`productID`, `shippingID`, `accountID`,`quantity`) VALUES(?,?,?,?)");
        
                $stmt->bind_param("isis", $row['PID'], $row['shippingID'], $accountID, $row['quantity']);
                $success = $stmt->execute();
                return $success;
        }
        public function selectOrder() {
            if (isset($_SESSION['UID'])) {
                $accountID = $_SESSION['UID'];
            }
            $stmt = $this->connection->prepare("SELECT p.Pimage, p.Pname, p.Pprice, o.quantity
                                                FROM orders as o
                                                INNER JOIN products as p
                                                ON o.productID = p.PID
                                                WHERE o.accountID = ?");
            $stmt->bind_param( "i",  $accountID );
            $stmt->execute();
            $result_select = $stmt->get_result();
            return $result_select;
        }


    }

    class Accounts {
        protected $connection;
        private $name;
        protected $email;
        protected $password;

        public function __construct(Connect_db $connect, $name, $email, $password) {
            $this->connection = $connect->getConn();
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
        } 

        public function checkIfUserExists() {
            $stmt = $this->connection->prepare("SELECT * FROM accounts WHERE email = ?");
            $stmt->bind_param("s", $this->email);
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            return $result->num_rows > 0;
        }

        public function createAccount() {
            $passwordhashed = password_hash($this->password, PASSWORD_BCRYPT);
            $role = 1;
            $datetime = date('Y-m-d H:i:s');
        
            $stmt =  $this->connection->prepare("INSERT INTO `accounts` (`name`, `email`, `password`,`created_at`, `role`) VALUES(?,?,?,?,?)");
        
            $stmt->bind_param("sssss", $this->name, $this->email, $passwordhashed, $datetime, $role);
            $success = $stmt->execute();
        
            return $success;
        }

        
    }

    class AccountLogin extends Accounts {
        public function __construct(Connect_db $connect, $email, $password) {
            parent::__construct($connect, '', $email, $password);
        }
    
        public function loginAccount(){
            $stmt = $this->connection->prepare("SELECT * FROM `accounts` WHERE `email` = ?");
                $stmt->bind_param( "s", $this->email );
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();

                if ($user && password_verify($this->password, $user['password'])) {
                    return $user;
                }
            return null;
        }
    }
    

    class Products {
        protected $connection;
        private $productName;
        private $productType;
        private $productPrice;
        private $aboutProduct;
        private $productPictures;
        protected $bodymaterial;
        protected $bodyfinish;
        protected $fretboardmaterial;
        protected $numoffrets;
        protected $strings;
        
    
        public function __construct(Connect_db $connect, $productName, $productType, $productPrice, $aboutProduct, $productPictures, $bodymaterial, $bodyfinish, $fretboardmaterial, $numoffrets, $strings) {

            $this->connection = $connect->getConn();
            $this->productName = $productName;
            $this->productType = $productType;
            $this->productPrice = $productPrice;
            $this->aboutProduct = $aboutProduct;
            $this->productPictures = $productPictures;
            $this->bodymaterial = $bodymaterial;
            $this->bodyfinish = $bodyfinish;
            $this->fretboardmaterial = $fretboardmaterial;
            $this->numoffrets = $numoffrets;
            $this->strings = $strings;
        }

        public function InsertProducts() {
            $stmt = $this->connection->prepare("INSERT INTO `products` (`Pname`, `CID`, `Pprice`, `Pdescription`, `Pimage`) VALUES(?,?,?,?,?)");
            $stmt->bind_param("sidss" , $this->productName, $this->productType, $this->productPrice, $this->aboutProduct, $this->productPictures);
            $result = $stmt->execute();

            if ($result) {
                $foreignkey = mysqli_insert_id( $this->connection ); 

                $stmt = $this->connection->prepare("INSERT INTO `specs`(`bodymaterial`,`bodyfinish`,`fretboardmaterial`,`numoffrets`,`strings`,`productID`) VALUES (?,?,?,?,?,?)");

                $stmt->bind_param("sssisi",$this->bodymaterial, $this->bodyfinish, $this->fretboardmaterial, $this->numoffrets, $this->strings, $foreignkey);
                $success = $stmt->execute();
                if($success){
                    return $success;
                }else{
                    return  false;
                }
            }
        }

        public function Update($id){

            $stmt = $this->connection->prepare("UPDATE `products` SET `Pname`= ?, `CID`= ?, `Pprice`= ?, `Pdescription`= ?, `Pimage`=? WHERE `PID`= ?");
            $stmt->bind_param("sidssi", $this->productName, $this->productType, $this->productPrice, $this->aboutProduct, $this->productPictures, $id);
            $result = $stmt->execute();
        
            if ($result) {
                $stmt = $this->connection->prepare("UPDATE `specs` SET `bodymaterial`=?, `bodyfinish`=?, `fretboardmaterial`=?, `numoffrets`=?, `strings`=? WHERE `specsID`= ?");
                $stmt->bind_param("sssisi", $this->bodymaterial, $this->bodyfinish, $this->fretboardmaterial, $this->numoffrets, $this->strings, $id);
                $success = $stmt->execute();

                if ($success) {
                    return $success;
                }
            } else {
                return $stmt->error;
            }
        }

    }


    class ShippingInfo {
        protected $connection;
        private $fullname;
        private $phonenum;
        private $address;
        private $city;
        private $state;
        private $postalcode;

        private $nameoncard;
        private $cardnumber;
    
        public function __construct(Connect_db $connect, $fullname, $phonenum, $address, $city, $state, $postalcode, $nameoncard, $cardnumber) {
            $this->connection = $connect->getConn();
            $this->fullname = $fullname;
            $this->phonenum = $phonenum;
            $this->address = $address;
            $this->city = $city;
            $this->state = $state;
            $this->postalcode = $postalcode;
            $this->nameoncard = $nameoncard;
            $this->cardnumber = $cardnumber; 
        }
    
        public function insertShipDetails($accountID){

            $stmt = $this->connection->prepare("INSERT INTO `shipping`(`fullname`, `phonenum`, `address`, `city`, `state`, `postalcode`, `accountID`) VALUES(?,?,?,?,?,?,?)");
            $stmt->bind_param("sisssii" , $this->fullname, $this->phonenum, $this->address, $this->city, $this->state, $this->postalcode, $accountID);
            $result = $stmt->execute();

            if ($result) {
                $foreignkey =  mysqli_insert_id($this->connection);
                return $foreignkey;
            }else{
                return 0;
            }
        }

        public function updateShipDetails($accountID){

            $stmt = $this->connection->prepare("UPDATE `shipping` SET `fullname`= ?,`phonenum`= ?,`address`= ?,`city`= ?,`state`= ?,`postalcode`= ? WHERE `accountID` = ?");
            $stmt->bind_param("sisssii" , $this->fullname, $this->phonenum, $this->address, $this->city, $this->state, $this->postalcode, $accountID);
            $result = $stmt->execute();

            if ($result) {
                return $result;
            }else{
                return 0;
            }
        }

        public  function insertPayment($fk) {
            
            $stmt = $this->connection->prepare("INSERT INTO `payment`(`nameoncard`, `cardnumber`, `shippingID`) VALUES(?,?,?)");
            $stmt->bind_param("sii" , $this->nameoncard, $this->cardnumber, $fk);
            $result = $stmt->execute();
        
            if ($result) {
                return $result;
            }
        }

        public  function updatePayment($fk) {
            
            $stmt = $this->connection->prepare("UPDATE `payment` SET `nameoncard`= ?,`cardnumber`=? WHERE shippingID = ? ");
            $stmt->bind_param("sii" , $this->nameoncard, $this->cardnumber, $fk);
            $result = $stmt->execute();
        
            if ($result) {
                return $result;
            }
        }

    }
    
        


?>




