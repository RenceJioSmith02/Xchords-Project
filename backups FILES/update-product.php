<?php
    require("backend.php");

    $connect = new Connect_db();

    
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

    if (isset($_GET['id'])) {
        $id =  $_GET['id'];
    
        $query = new Queries($connect);
        $print = $query->printUpdateproducts($id);
    }
    
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../relativeFiles/css/pop-ups.css">
    <link rel="stylesheet" href="../relativeFiles/css/checkout.css">
    <link rel="stylesheet" href="../relativeFiles/css/style.css">

</head>
<body>
    
    <div class="shipping-container">
        <form id="add-product-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            
            <div class="row">

                <div class="col" style="margin-bottom: 20px;">
                    <h3 class="title">Add product</h3>

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
                            <option value="3" <?php if ($row['CID'] == '3') echo 'selected'; ?>>BASE</option>
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
                        <textarea name="about-product" id="about-product" cols="43" rows="10" value="<?php echo $row['Pdescription']; ?>" required><?php echo $row['Pdescription']; ?></textarea>
                    </div>
                </div>
                        
                <div class="col" style="margin-bottom: 20px;">
                    <h3 class="title">Add product</h3>

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

                    <input type="submit" name="update" value="update">

                    <?php endwhile; ?>

                </div>

            </div>

            <a href="table.php?table=Products">go back</a>
        </form>

    </div>

</body>
</html>