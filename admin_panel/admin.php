    <?php
        session_start();

        require("backend.php");
        $connect = new Connect_db();
        $query = new Queries($connect);

        $limit = 5;

        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        $start = ($page - 1) * $limit;

        $tablename = "sales";
        $primarykey = "salesID";

        $result = $query->Print($start, $limit, $tablename, $primarykey);
        $rows = $result;
        
        $totalRows = $query->getTotalRows($tablename);
        $totalPages = ceil($totalRows / $limit);

        $prev = $page - 1;
        $next = $page + 1;

        $count = 0;
        $count += ($page - 1) * 5;
    ?>

<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../relativeFiles/css/admin.css">

    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>

  <!-- sidebar-header -->
  <?php 
    include 'sidebar-header.php'; 
    
    $earnings = $query->totalEarning();
    $users = $query->totalUsers();

    $acoustic = $query->updateSalesChart (1);
    $electric = $query->updateSalesChart (2);
    $bass = $query->updateSalesChart (3);
    $ukalele = $query->updateSalesChart (4);

    $total_catergory = $acoustic + $electric + $bass + $ukalele;

    $acoustic = ($acoustic / $total_catergory) * 100;
    $electric = ($electric / $total_catergory) * 100;
    $bass = ($bass / $total_catergory) * 100;
    $ukalele = ($ukalele / $total_catergory) * 100;
  
  ?>

  
  
  <section class="section-panel">
    <div class="section-content">
      
      <div class="box-container">

        <div class="box">
          <div class="box-label">
          </div>
          
          <div class="box-content">
            <div class="colors">
              <ul>
                <li class="color-label">
                  <div style="width: 10px; height: 10px; background: yellow;"></div>
                  <span>Acoustic</span>
                </li>
                <li class="color-label">
                  <div style="width: 10px; height: 10px; background: blue;"></div>
                  <span>Electric</span>
                </li>
                <li class="color-label">
                  <div style="width: 10px; height: 10px; background: green;"></div>
                  <span>Bass</span>
                </li>
                <li class="color-label">
                  <div style="width: 10px; height: 10px; background: red;"></div>
                  <span>Ukalele</span>
                </li>
              </ul>
            </div>

            <div class="chart" 
            style="--acoustic: <?php echo $acoustic."%"; ?>; 
                    --electric: <?php echo $electric."%"; ?>; 
                    --bass: <?php echo $bass."%"; ?>; 
                    --ukalele: <?php echo $ukalele ."%";?>;"
            >
             <div class="center-circle"></div> 
            </div>

          </div>

          <div class="box-label">
            <h3>Orders</h3>
          </div>
        </div>

        <div class="box">

          <div class="icon-box">
            <div class="box1">
              <span><?php echo $users['total']; ?></span>
              <h3>Users</h3>
            </div>
  
            <div class="box2">
              <ion-icon name="people-outline"></ion-icon>
            </div>
          </div>

        </div>

        <div class="box">

          <div class="icon-box">
            <div class="box1">
              <span>&#8369;<?php echo $earnings['total']; ?></span>
              <h3>Earnings</h3>
            </div>
  
            <div class="box2">
              <ion-icon name="cash-outline"></ion-icon>
            </div>
          </div>

        </div>

      </div>

      <div class="box-container">
        <main class="table">
          <center><h3>Sales</h3></center>
  
          <div class="table-body">
              <table>
                  <thead>
                      <tr>
                          <th>no.</th>
                          <th>Customer Name</th>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Date Delivered</th>
                      </tr>
                  </thead>
                  <tbody id="results">
                    
                  <?php
                                                  // $row = mysqli_fetch_assoc($rows);
                                                  // if($row != null) {
                                                  //     echo "may laman naman";
                                                  // }else {
                                                  //     echo"wala";
                                                  // }

                  while ($row = mysqli_fetch_assoc($rows)){  ?>
                        <tr>
                            <td><?php echo ++$count ?></td>
                            <td><?php echo $row['Cname'] ?></td>
                            <td><?php echo $row['Pname'] ?></td>
                            <td><?php echo $row['quantity'] ?></td>
                            <td><?php echo $row['Pprice'] ?></td>
                            <td><?php echo $row['delivered'] ?></td>
                        </tr>
                    <?php } ?>
      
                  </tbody>
              </table>
              
            </div>
  
      </main>
      </div>

    </div>
  </section>

  <!-- <section class="section-panel">
    <div class="section-content">
      content2
    </div>
  </section> -->


    
  <!-- side bar and pop-ups script -->
  <script src="../relativeFiles/js/admin-pop.js"></script>

    <!-- ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  
</body>
</html>