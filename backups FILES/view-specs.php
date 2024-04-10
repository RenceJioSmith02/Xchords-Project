<?php
    require("backend.php");

        $connect = new Connect_db();
        
        if (isset($_GET['id'])) {
            $id =  $_GET['id'];
        
            $query = new Queries($connect);
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

    <link rel="stylesheet" href="../relativeFiles/css/pop-ups.css">
    <link rel="stylesheet" href="../relativeFiles/css/checkout.css">
    <link rel="stylesheet" href="../relativeFiles/css/style.css">

</head>
<body>
        
    <div class="shipping-container">

        <form id="view-specsform" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col">

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
            
            <a href="table.php?table=Products">go back</a>
        </form>

    </div>

</body>
</html>