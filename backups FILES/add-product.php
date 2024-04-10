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
        <form id="add-product-form" action="table.php" method="post" enctype="multipart/form-data">
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
                        <textarea name="about-product" id="about-product" cols="43" rows="10" required></textarea>
                    </div>
                </div>

                <div class="col" style="margin-bottom: 20px;">
                    <h3 class="title">Specifications</h3>

                    <div class="inputBox">
                        <span>body Material:</span>
                        <input type="text" id="bodymaterial" name="bodymaterial" required>
                    </div>
                    
                    <div class="inputBox">
                        <span">body Finish:</span>
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

                    <input type="submit" name="submit" value="Add">

                </div>

            </div>

            <a href="table.php?table=Products">go back</a>
        </form>
    </div>


</body>
</html>