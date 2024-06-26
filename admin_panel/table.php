<?php
    session_start();
    if (isset($_SESSION['type']) && $_SESSION['type'] == 'user') {
        header("Location: ../index.php");
    }

    require_once("backend.php");
    
    $connect = new Connect_db();
    $query = new Queries($connect);
    

    if (isset($_GET['deleteid'])) {
        $productId = $_GET['deleteid'];
            
        if ($query->deleteProduct($productId)) {
            header("Location: table.php?table=Products&msg=deleteItem");
        }
    }

    if (isset($_GET['deleteAcc'])) {
        $query->deleteAccount($_GET['deleteAcc']);
    }

    if (isset($_GET['shipOut'])) {
        $query->updateStatus($_GET['shipOut']);
    }



    // query

    $limit = 5;

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

    $start = ($page - 1) * $limit;


    if (isset($_GET['table']) && $_GET['table'] == 'Products') {
        $table = "products";
        $tablename = "products";
        $primarykey = "PID";
    } elseif (isset($_GET['table']) && $_GET['table'] == 'Orders') {
        $table = "orders";
        $tablename = "orders";
        $primarykey = "orderID";
    } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {
        $table = "accounts";
        $tablename = "accounts";
        $primarykey = "accountID";
        
        //category 
    } elseif (isset($_GET['category']) && $_GET['category'] == 'Acoustic') {
        $table = "products";
        $tablename = "acoustic";
        $primarykey = "1";
    } elseif (isset($_GET['category']) && $_GET['category'] == 'Electric') {
        $table = "products";
        $tablename = "electric";
        $primarykey = "2";
    } elseif (isset($_GET['category']) && $_GET['category'] == 'Bass') {
        $table = "products";
        $tablename = "bass";
        $primarykey = "3";
    } elseif (isset($_GET['category']) && $_GET['category'] == 'Ukalele') {
        $table = "products";
        $tablename = "ukalele";
        $primarykey = "4";
    } 

    if (isset($_GET['table']) || isset($_GET['category']) || isset($_GET['page'])) {
        $result = $query->Print($start, $limit, $tablename, $primarykey);
        $rows = $result;
    }
    
    if (isset($_GET['category'])){
        $totalRows = $query->getTotalRows2($primarykey);
    }else {
        $totalRows = $query->getTotalRows1($table);
    }
    
    $totalPages = ceil($totalRows / $limit);
    
    $prev = $page > 1 ? $page - 1 : null;
    $next = $page < $totalPages ? $page + 1 : null;

    $count = 0;
    $count += ($page - 1) * 5;

    if (isset($_GET['msg']) && $_GET['msg'] == 'itemAdded') {
        echo "<script>alert('Item Added Successfully!')</script>";
    }
    if (isset($_GET['msg']) && $_GET['msg'] == 'itemUpdated') {
        echo "<script>alert('Item Updated Successfully!')</script>";
    }
    if (isset($_GET['msg']) && $_GET['msg'] == 'deleteItem') {
        echo "<script>alert('Item Deleted Successfully!')</script>";
    }
    if (isset($_GET['msg']) && $_GET['msg'] == 'deleteAcc') {
        echo "<script>alert('Account Deleted Successfully!')</script>";
    }
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../relativeFiles/css/admin.css">
    <!-- <link rel="stylesheet" href="pop-ups.css"> -->

    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- sidebar-header -->
  <?php include 'sidebar-header.php'; ?>


    <section class="section-panel">
        <div class="section-content">
        
            <div class="box-container">
                <main class="table">
                
                <?php 
                    if (isset($_GET['table']) && $_GET['table'] == 'Products') {
                        echo "<div class='title-btn'>
                                <h3>Products</h3>
                                <div class='add-btn'>
                                    <a href='pop-ups.php?pop=addProduct'>
                                        <ion-icon name='bag-add-outline'></ion-icon>
                                    </a>
                                </div>
                               </div>
                            ";
                    } elseif (isset($_GET['table']) && $_GET['table'] == 'Orders') {
                        echo "<center><h3>Orders</h3></center>";
                    } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {
                        echo "<center><h3>Users</h3></center>";
                        
                        //category 
                    } elseif (isset($_GET['category']) && $_GET['category'] == 'Acoustic') {
                        echo "<center><h3>Acoustic</h3></center>";
                    } elseif (isset($_GET['category']) && $_GET['category'] == 'Electric') {
                        echo "<center><h3>Electric</h3></center>";
                    } elseif (isset($_GET['category']) && $_GET['category'] == 'Bass') {
                        echo "<center><h3>Bass</h3></center>";
                    } elseif (isset($_GET['category']) && $_GET['category'] == 'Ukalele') {
                        echo "<center><h3>Ukalele</h3></center>";
                    } 
                ?>
        
                <div class="table-body">
                    <table>

                    <!-- 
                        TABLE HEAD 
                    -->
                        <?php if (isset($_GET['table']) && $_GET['table'] == 'Products' || isset($_GET['category'])) { ?>
                            <thead>
                                <tr>
                                    <th>no.</th>
                                    <th>Product Name</th>
                                    <th>Product Category</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Specs</th>
                                    <th>Product Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Orders') {?>
                            <thead>
                                <tr>
                                    <th>no.</th>
                                    <th>Customer</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {?>
                            <thead>
                                <tr>
                                    <th>no.</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        <?php } ?>
                        

                        <!-- 
                            TABLE BODY 
                        -->
                        <?php if (isset($_GET['table']) && $_GET['table'] == 'Products') { ?>
                            <tbody id="results">

                            <?php while ($row = mysqli_fetch_assoc($rows)){  ?>
                                <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?php echo $row['Pname'] ?></td>
                                    <td><?php echo $row['category'] ?></td>
                                    <td><?php echo $row['Pprice'] ?></td>
                                    <td><p  class="description"><?php echo $row['Pdescription'] ?></p></td>
                                    <td>
                                        
                                        <a href="pop-ups.php?pop=viewSpecs&id=<?php echo $row['PID'] ?>"><ion-icon name="eye-outline"></ion-icon></a>

                                    </td>
                                    <td><img src="<?php echo "." . $row['Pimage']; ?>" alt="Product Image" style="max-width: 100px;"></td>
                                    <td>
                                        <a href="pop-ups.php?pop=updateProduct&updateId=<?php echo $row['PID'] ?>"><ion-icon name="create-outline"></ion-icon></a>
                                        <a href="table.php?deleteid=<?php echo $row['PID'] ?>" onclick="return confirm('Are you sure you want to delete this product?')"><ion-icon name="trash"></ion-icon></a>
                                    </td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Orders') {?>
                        
                            <?php 
                                // $row = mysqli_fetch_assoc($rows);
                                //     if($row != null) {
                                //         echo "may laman naman";
                                //         echo $row['quantity'];
                                //     }else {
                                //         echo"wala";
                                //     }
                            ?>


                            <tbody id="results">
                                <?php while ($row = mysqli_fetch_assoc($rows)){  ?>
                                    <tr>
                                        <td><?php echo ++$count ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['Pname'] ?></td>
                                        <td><?php echo $row['quantity'] ?></td>
                                        <td><?php echo $row['Pprice'] ?></td>
                                        <td>
                                            <?php if (isset($row['status']) && $row['status'] == 'pending') {
                                                    echo "<a href='table.php?table=Orders&shipOut=".$row['orderID']."'><ion-icon name='checkmark-done-outline'></ion-icon></a>";
                                            } else {
                                                    echo "<span>Appoved</span>";
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        <?php } elseif (isset($_GET['table']) && $_GET['table'] == 'Users') {?>
                            <tbody id="results">
                                <?php while ($row = mysqli_fetch_assoc($rows)){
                                    if ($row['role'] === 0) {
                                        continue;
                                    }
                                ?>
                                    <tr>
                                        
                                        <td><?php echo ++$count ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td><?php echo $row['created_at'] ?></td>
                                        <td>
                                            <a href="table.php?table=Users&msg=deleteAcc&deleteAcc=<?php echo $row['accountID'] ?>" onclick="return confirm('Are you sure you want to delete this account?')"><ion-icon name="trash"></ion-icon></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        <?php } elseif (isset($_GET['category'])) {?>
                            <tbody id="results">

                            <?php while ($row = mysqli_fetch_assoc($rows)){  ?>
                                <tr>
                                    <td><?php echo ++$count ?></td>
                                    <td><?php echo $row['Pname'] ?></td>
                                    <td><?php echo $row['category'] ?></td>
                                    <td><?php echo $row['Pprice'] ?></td>
                                    <td><p class="description"><?php echo $row['Pdescription'] ?></p></td>
                                    <td>
                                        
                                        <a href="pop-ups.php?pop=viewSpecs&id=<?php echo $row['PID'] ?>"><ion-icon name="eye-outline"></a>

                                    </td>
                                    <td><img src="<?php echo "." . $row['Pimage'] ?>" alt="Product Image" style="max-width: 100px;"></td>
                                    <td>
                                        <a href="pop-ups.php?pop=updateProduct&updateId=<?php echo $row['PID'] ?>"><ion-icon name="create-outline"></a>
                                        <a href="table.php?deleteid=<?php echo $row['PID'] ?>" onclick="return confirm('Are you sure you want to delete this product?')"><ion-icon name="trash"></ion-icon></a>
                                    </td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        <?php } ?>
                            
                    </table>
                    
                    
                    </div>

                    <div class="pagination-container">
                        <div class="pagination">
                            <?php if ($prev !== null): ?>
                                <a href="?page=<?php echo $prev; ?><?php if(isset($_GET['table'])) {echo '&table='.$_GET['table'];} ?><?php if(isset($_GET['category'])) {echo '&category='.$_GET['category'];} ?>">Previous</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a <?php if ($i == $page) echo 'class="active"'; ?> href="?page=<?php echo $i; ?><?php if(isset($_GET['table'])) {echo '&table='.$_GET['table'];} ?><?php if(isset($_GET['category'])) {echo '&category='.$_GET['category'];} ?>"><?php echo $i; ?></a>
                            <?php endfor; ?>

                            <?php if ($next !== null): ?>
                                <a href="?page=<?php echo $next; ?><?php if(isset($_GET['table'])) {echo '&table='.$_GET['table'];} ?><?php if(isset($_GET['category'])) {echo '&category='.$_GET['category'];} ?>">Next</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </main>
            </div>
                
    </section>




  <!-- side bar and pop-ups script -->
    <script src="../relativeFiles/js/admin-pop.js"></script>

    <!-- ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>