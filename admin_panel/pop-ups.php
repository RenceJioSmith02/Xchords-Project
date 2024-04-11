<?php

    session_start();
    require("backend.php");

    $connect = new Connect_db();
    $query = new Queries($connect);


    // add product
    if (isset($_POST['submit'])) {
        $productName = $_POST['product-name'];
        $productType = $_POST['product-type'];
        $productPrice = $_POST['product-price'];
        $aboutProduct = $_POST['about-product'];
        $uploadedFiles = $_FILES["product-image"];
        $bodymaterial = $_POST['bodymaterial'];
        $bodyfinish = $_POST['bodyfinish'];
        $fretboardmaterial = $_POST['fretboardmaterial'];
        $numoffrets = $_POST['numoffrets'];
        $strings = $_POST['strings'];
    
        if ($uploadedFiles["error"] === 4) {
            echo "<script> alert('Image does not exist.'); </script>";
        } else {
            $fileName = $uploadedFiles["name"];
            $fileSize = $uploadedFiles["size"];
            $tempName = $uploadedFiles["tmp_name"];
    
            $validImgExtension = ['jpg', 'jpeg', 'png'];
            $imgExtension = explode(".", $fileName);
            $imgExtension = strtolower(end($imgExtension));
            
            // Check file extension
            if (!in_array($imgExtension, $validImgExtension)) {
                echo "<script> alert('$imgExtension Invalid image extension.'); </script>";
            } elseif ($fileSize > 4000000) {
                echo "<script> alert('Image is too large.'); </script>";
            } else {
                $newImgName = uniqid() . "." . $imgExtension;
                $filePath = "productpics/" . $newImgName;
                move_uploaded_file($tempName, $filePath);
    
                $query1 = new Products($connect, $productName, $productType, $productPrice, $aboutProduct, $filePath, $bodymaterial, $bodyfinish, $fretboardmaterial, $numoffrets, $strings);
                
                if ($query1->InsertProducts()) {
                    header("Location: table.php?table=Products&insert=success");
                }else {
                    die("Error inserting data into database.");
                }
            }
        }
    }

    // update
    if (isset($_POST['update'])) {
        $id =  $_POST['PID'];
        $productName = $_POST['product-name'];
        $productType = $_POST['product-type'];
        $productPrice = $_POST['product-price'];
        $aboutProduct = $_POST['about-product'];
        $filepath = $_FILES["product-image"];
        $oldimage = $_POST['old-image'];
        $bodymaterial = $_POST['bodymaterial'];
        $bodyfinish = $_POST['bodyfinish'];
        $fretboardmaterial = $_POST['fretboardmaterial'];
        $numoffrets = $_POST['numoffrets'];
        $strings = $_POST['strings'];

            $fileName = $filepath["name"];
            $fileSize = $filepath["size"];
            $tempName = $filepath["tmp_name"];

            $validImgExtension = ['jpg', 'jpeg', 'png'];
            $imgExtension = explode(".", $fileName);
            $imgExtension = strtolower(end($imgExtension));
        
            if ($fileSize > 4000000) {
                echo "<script> alert('Image is too large.'); </script>";
            } else {
                if ($fileName != '') {

                    $query = new Queries($connect);

                    $imagePath = $query->getProductImageById($id);

                    if ($imagePath && file_exists($imagePath)) {
                        unlink($imagePath);
                    }

                    $newImgName = uniqid() . "." . $imgExtension;
                    $updatedimage = "productpics/" . $newImgName;
                    move_uploaded_file($tempName, $updatedimage);

                } else {
                    $updatedimage = $oldimage;
                }
        
                $query = new Products($connect, $productName, $productType, $productPrice, $aboutProduct, $updatedimage, $bodymaterial, $bodyfinish, $fretboardmaterial, $numoffrets, $strings);
        
                if ($query->Update($id)) {
                    // header("Location: table.php?updated=spe". $oldimage);
                    header("Location: table.php?table=Products");
                } else {
                    echo "error";
                }
            }
        
    }

    if (isset($_GET['updateId'])) {
        $id =  $_GET['updateId'];
        $query = new Queries($connect);
    
        $print = $query->printUpdateproducts($id);
        
    }
              
    if (isset($_GET['id'])) {
        $id =  $_GET['id'];
    
        $tablename = "specs";
        $printspecs = $query->selectAll($tablename, $id);
        $row1 = $printspecs;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../relativeFiles/css/admin.css">
    <link rel="stylesheet" href="../relativeFiles/css/checkout.css">

    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

  <!-- sidebar-header -->
  <?php include 'sidebar-header.php'; ?>
    
  <section class="section-panel">
        <div class="section-content" style="padding-bottom: 0;">
            <div class="box-container" style="padding:0;">


    <?php if (isset($_GET['pop']) && $_GET['pop'] == 'addProduct') { ?>

        <?php            
            if (isset($_POST['submit'])) {
                $productName = $_POST['product-name'];
                $productType = $_POST['product-type'];
                $productPrice = $_POST['product-price'];
                $aboutProduct = $_POST['about-product'];
                $uploadedFiles = $_FILES["product-image"];
                $bodymaterial = $_POST['bodymaterial'];
                $bodyfinish = $_POST['bodyfinish'];
                $fretboardmaterial = $_POST['fretboardmaterial'];
                $numoffrets = $_POST['numoffrets'];
                $strings = $_POST['strings'];
            
                if ($uploadedFiles["error"] === 4) {
                    echo "<script> alert('Image does not exist.'); </script>";
                } else {
                    $fileName = $uploadedFiles["name"];
                    $fileSize = $uploadedFiles["size"];
                    $tempName = $uploadedFiles["tmp_name"];
            
                    $validImgExtension = ['jpg', 'jpeg', 'png'];
                    $imgExtension = explode(".", $fileName);
                    $imgExtension = strtolower(end($imgExtension));
                    
                    // Check file extension
                    if (!in_array($imgExtension, $validImgExtension)) {
                        echo "<script> alert('$imgExtension Invalid image extension.'); </script>";
                    } elseif ($fileSize > 4000000) {
                        echo "<script> alert('Image is too large.'); </script>";
                    } else {
                        $newImgName = uniqid() . "." . $imgExtension;
                        $filePath = "productpics/" . $newImgName;
                        move_uploaded_file($tempName, $filePath);
            
                        $query1 = new Products($connect, $productName, $productType, $productPrice, $aboutProduct, $filePath, $bodymaterial, $bodyfinish, $fretboardmaterial, $numoffrets, $strings);
                        
                        if ($query1->InsertProducts()) {
                            header("Location: table.php?table=Products&insert=success");
                        }else {
                            die("Error inserting data into database.");
                        }
                    }
                }
            }
        ?>
        
        <div class="shipping-container" style="padding: 0 25px">
            <form id="add-product-form" action="pop-ups.php" method="post" enctype="multipart/form-data" style="max-width: 950px;">
                <div class="row">

                    <div class="col" style="margin-bottom: 20px;">

                        <h3 class="title">Add product</h3>

                        <div class="inputBox">
                            <span>Product Name:</span>
                            <input type="text" id="product-name" name="product-name" required>
                        </div>

                        <div class="inputBox">
                            <select name="product-type" id="product-type">
                                <option value="0">Category</option>
                                <option value="1">ACOUSTIC</option>
                                <option value="2">ELECTRIC</option>
                                <option value="3">BASS</option>
                                <option value="4">UKALELE</option>
                            </select>
                        </div>

                        <div class="inputBox">
                            <span>Product Price:</span>
                            <input type="number" id="product-price" name="product-price" min="0" step="0.01" required>
                        </div>
                        
                        <div class="inputBox">
                            <span>Product Images:</span>
                            <input type="file" id="product-images" name="product-image" multiple required>
                        </div>

                        <div class="inputBox">
                            <span>Description:</span><br>
                            <textarea name="about-product" id="about-product" cols="20" rows="5" required></textarea>
                        </div>
                    </div>

                    <div class="col" style="margin-bottom: 20px;">
                        <h3 class="title">Specifications</h3>

                        <div class="inputBox">
                            <span>body Material:</span>
                            <input type="text" id="bodymaterial" name="bodymaterial" required>
                        </div>
                        
                        <div class="inputBox">
                            <span>body Finish:</span>
                            <input type="text" id="bodyfinish" name="bodyfinish" required>
                        </div>

                        <div class="inputBox">
                            <span>Fret Board Material:</span>
                            <input type="text" id="fretboardmaterial" name="fretboardmaterial" required>
                        </div>

                        <div class="inputBox">
                            <span for="numoffrets">Number of Frets:</span>
                            <input type="number" id="numoffrets" name="numoffrets" min="0" step="0.01" required>
                        </div>

                        <div class="inputBox">
                            <span>Strings:</span>
                            <input type="text" id="strings" name="strings" required>
                        </div>

                        <input type="submit" name="submit" value="ADD" class="order-btn" style="margin-top: 30px">

                    </div>

                </div>

                <a href="table.php?table=Products"><ion-icon name="return-down-back-sharp" class="back"></ion-icon></a>
            </form>
        </div>

    <?php } elseif (isset($_GET['pop']) && $_GET['pop'] == 'updateProduct') {  ?>
        
        <div class="shipping-container" style="padding: 0 25px">
            <form id="add-product-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" style="max-width: 950;">
                
                <div class="row">

                    <div class="col" style="margin-bottom: 20px;">
                        <h3 class="title">Update product</h3>

                        <?php while ($row = mysqli_fetch_assoc($print)) : ?>
                        <input type="hidden" name="PID" value="<?php echo $row['PID']; ?>">
                        <div class="inputBox">
                            <span>Product Name:</span>
                            <input type="text" id="product-name" name="product-name" value="<?php echo $row['Pname']; ?>" required>
                        </div>

                        <div class="inputBox">
                            <select name="product-type">
                                <option value="1" <?php if ($row['CID'] == '1') echo 'selected'; ?>>ACOUSTIC</option>
                                <option value="2" <?php if ($row['CID'] == '2') echo 'selected'; ?>>ELECTRIC</option>
                                <option value="3" <?php if ($row['CID'] == '3') echo 'selected'; ?>>BASS</option>
                                <option value="4" <?php if ($row['CID'] == '4') echo 'selected'; ?>>UKALELE</option>
                            </select>
                        </div>

                        <div class="inputBox">
                            <span>Product Price:</span>
                            <input type="number" id="product-price" name="product-price" min="0" step="0.01" value="<?php echo $row['Pprice']; ?>" required>
                        </div>
                        
                        <div class="inputBox">
                            <span>Product Images:</span>
                            <input type="file" id="product-images" name="product-image">
                            <input type="hidden" name="old-image" value="<?php echo $row['Pimage']; ?>">
                        </div>

                        <div class="inputBox">
                            <span>Description:</span><br>
                            <textarea name="about-product" id="about-product" cols="20" rows="5" value="<?php echo $row['Pdescription']; ?>" required><?php echo $row['Pdescription']; ?></textarea>
                        </div>
                    </div>
                            
                    <div class="col" style="margin-bottom: 20px;">
                        <h3 class="title">Specification</h3>

                        <div class="inputBox">
                            <span>body Material:</span>
                            <input type="text" id="bodymaterial" name="bodymaterial" value="<?php echo $row['bodymaterial']; ?>" required>
                        </div>
                        
                        <div class="inputBox">
                            <span>body Finish:</span>
                            <input type="text" id="bodyfinish" name="bodyfinish" value="<?php echo $row['bodyfinish']; ?>"  required>
                        </div>

                        <div class="inputBox">
                            <span>Fret Board Material:</span>
                            <input type="text" id="fretboardmaterial" name="fretboardmaterial" value="<?php echo $row['fretboardmaterial']; ?>" required>
                        </div>

                        <div class="inputBox">
                            <span>Number of Frets:</span>
                            <input type="number" id="numoffrets" name="numoffrets" min="0" step="0.01" value="<?php echo $row['numoffrets']; ?>" required>
                        </div>

                        <div class="inputBox">
                            <span>Strings:</span>
                            <input type="text" id="strings" name="strings" value="<?php echo $row['strings']; ?>" required>
                        </div>

                        <input type="submit" name="update" value="UPDATE" class="order-btn" style="margin-top: 30px">

                        <?php endwhile; ?>

                    </div>

                </div>

                <a href="table.php?table=Products"><ion-icon name="return-down-back-sharp" class="back"></ion-icon></a>
            </form>
            
        </div>

    <?php } elseif (isset($_GET['pop']) && $_GET['pop'] == 'viewSpecs') {  ?>

        <div class="shipping-container" style="padding: 0 25px">

            <form id="view-specsform" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" style="max-width: 950;">
                <div class="row">

                    <div class="col" style="width: 950px; margin-bottom: 20px;">
                        <h3 class="title">Specification</h3>

                        <?php while ($row = mysqli_fetch_assoc($row1)) : ?>
                            <div class="inputBox">
                                <span>Body Material:</span>
                                <input type="text" id="bodymaterial" name="bodymaterial" value="<?php echo $row['bodymaterial']; ?>" readonly required>
                            </div>

                            <div class="inputBox">
                                <span>Body Finish:</span>
                                <input type="text" id="bodyfinish" name="bodyfinish" value="<?php echo $row['bodyfinish']; ?>" readonly required>
                            </div>

                            <div class="inputBox">
                                <span>Fretboard Material:</span>
                                <input type="text" id="fretboardmaterial" name="fretboardmaterial" value="<?php echo $row['fretboardmaterial']; ?>" readonly required>
                            </div>

                            <div class="inputBox">
                                <span>Number of Frets:</span>
                                <input type="number" id="numoffrets" name="numoffrets" min="0" step="1" value="<?php echo $row['numoffrets']; ?>" readonly required>
                            </div>

                            <div class="inputBox">
                                <span>Strings:</span>
                                <input type="text" id="strings" name="strings" value="<?php echo $row['strings']; ?>" readonly required>
                            </div>
                            
                        <?php endwhile; ?>

                    </div>

                </div>
                
                <a href="table.php?table=Products"><ion-icon name="return-down-back-sharp" class="back"></ion-icon></a>
            </form>

        </div>

    <?php } ?>


        </div>
    </div>
</section>


  <!-- side bar and pop-ups script -->
    <script src="../relativeFiles/js/admin-pop.js"></script>

    


    <!-- ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
</body>
</html>