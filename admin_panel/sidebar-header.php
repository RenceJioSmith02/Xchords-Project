<?php
if (isset($_GET['logout'])) {
  session_destroy();
  header( "location: ../index.php" );
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- Include SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>

  <!-- Include SweetAlert2 library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      
    <div class="sidebar close">
        <div class="logo-details">
          <div class="img">
            <img src="../relativeFiles/images/logo&bg/logo_WO_text.png" width="30px" alt="">
          </div>
          <span class="logo_name">Xchords</span>
        </div>
          <ul class="nav-links">

            <li>
              <a href="admin.php">
                <i class='bx bxs-dashboard'></i>
                <span class="link_name">Dashboard</span>
              </a>
              <ul class="sub-menu blank">
                <li><a class="link_name" href="admin.php">Dashboard</a></li>
              </ul>
            </li>

            <li>
              <div class="iocn-link">
                <a href="table.php?table=Products">
                  <i class='bx bx-store'></i>
                  <span class="link_name">Products</span>
                </a>
                <i class='bx bxs-chevron-down arrow' ></i>
              </div>
              <ul class="sub-menu">
                <li><a class="link_name" href="table.php?table=Products">Products</a></li>
                <li><a href="table.php?category=Acoustic">Acoustic</a></li>
                <li><a href="table.php?category=Electric">Electric</a></li>
                <li><a href="table.php?category=Bass">Bass</a></li>
                <li><a href="table.php?category=Ukalele">Ukalele</a></li>
              </ul>
            </li>

            <li>
              <a href="table.php?table=Orders">
                <i class='bx bx-receipt'></i>
                <span class="link_name">Orders</span>
              </a>
              <ul class="sub-menu blank">
                <li><a class="link_name" href="table.php?table=Orders">Orders</a></li>
              </ul>
            </li>

            <li>
              <a href="table.php?table=Users">
                <i class='bx bxs-user-detail'></i>
                <span class="link_name">User</span>
              </a>
              <ul class="sub-menu blank">
                <li><a class="link_name" href="table.php?table=Users">Users</a></li>
              </ul>
            </li>

          <li>
              <div class="profile-details">
                  <div class="profile-content">
                      <!--<img src="image/profile.jpg" alt="profileImg">-->
                  </div>
                  <div class="name-job">
                      <div class="profile_name">ADMINISTRATOR</div>
                      <div class="job">Xchords</div>
                  </div>
                  <button onclick="logout()">
                    <i class='bx bx-log-out'></i>
                  </button>
              </div>
          </li>
        </ul>
      </div>
      
      <div class="admin-header">
        <i class='bx bx-menu' ></i>
        <span class="text">Dashboard</span>
    </div>


  <script>

    function logout() {
      Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!'

          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href='<?php echo "../index.php?logout=true"?>';
              //alert("Logout successful!"); // For demonstration, you can replace this with actual logout action
            }
      })
    }
  </script>

</body>
</html>
  