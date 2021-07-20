<?php

session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
require '../actions/sqlconn.php';
$getlogsql = 'SELECT * FROM gym_log ORDER BY ID DESC LIMIT 25';
$log_result = $conn->query($getlogsql);

$gettotalselldetails = 'SELECT SUM(sells) AS "sumsells", SUM(sellinusd) AS "sumsellinusd" FROM `gym_users` WHERE 1';
$totalsell_result = $conn->query($gettotalselldetails);

$getmaxsell = 'SELECT IC_name, sells AS "maxsell" FROM gym_users ORDER BY maxsell DESC LIMIT 1';
$maxsell_result = $conn->query($getmaxsell);
$getmaxsellusd = 'SELECT IC_name, sellinusd AS "maxprice" FROM gym_users ORDER BY maxprice DESC LIMIT 1';
$maxsellusd_result = $conn->query($getmaxsellusd);

$totalsellcount = 0;
$totalsellusd = 0;
$maxsell = "";
$maxsellusd = "";

if ($totalsell_result->num_rows > 0) {
    // output data of each row
    while($row = $totalsell_result->fetch_assoc()) {
        //$row["id"]
        $totalsellcount = $row['sumsells'];
        $totalsellusd = $row['sumsellinusd'];
    }
}

if ($maxsell_result->num_rows > 0) {
    // output data of each row
    while($row = $maxsell_result->fetch_assoc()) {
        //$row["id"]
        $maxsell = $row['IC_name']." (".$row['maxsell'].")";
    }
}

if ($maxsellusd_result->num_rows > 0) {
    // output data of each row
    while($row = $maxsellusd_result->fetch_assoc()) {
        //$row["id"]
        $maxsellusd = $row['IC_name']." ($".$row['maxprice'].")";
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gym Paradise - Irányítópult</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/img/site.webmanifest">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4-.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-DataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body id="page-top" style="background-color: black;">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background-color: #0e0e0e;background-image: linear-gradient(180deg, #0e0e0e 10%, #474747 100%);">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-dumbbell"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Gym Paradise</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Irányítópult</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Profilom</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="sells.php"><i class="fa fa-line-chart"></i><span>Eladások</span></a><a class="nav-link" href="products.php"><i class="fas fa-shopping-basket"></i><span>Termékek</span></a><a class="nav-link" href="workers.php"><i class="fas fa-address-book"></i><span>Alkalmazottak</span></a><a class="nav-link" href="contracts.php"><i class="fas fa-pen-nib"></i><span>Szerződések</span></a><a class="nav-link" href="discounts.php"><i class="fas fa-percent"></i><span>Kedvezmények</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content" style="background-color: #0e0e0e;background-image: linear-gradient(180deg, #b1b1b1 10%, #474747 100%);">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top" style="background-color: #0e0e0e;background-image: linear-gradient(100deg, #0e0e0e 50%, #474747 100%);">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small"><?php echo $_SESSION['sess_login_name']; ?></span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar_ferfi.png"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in" style="background-image: linear-gradient(180deg, #0e0e0e 10%, #474747 100%);color: white !important;"><a class="dropdown-item" href="/user/index.php"><i class="fas fa-backward fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Vissza a számlázóba</a><a class="dropdown-item" href="/actions/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Kijelentkezés</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0" style="color: white !important;text-shadow: 2px 1px #000000;">Irányítópult</h3>
                    </div><div class="row">
    <div class="col-md-6 col-xl-6 mb-4">
        <div class="card shadow border-start-primary py-2" style="background-image: linear-gradient(145deg, #2E2E2E 10%, #575757 100%);">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span style="color:#00A6FF">Eladott termékek értéke (DB)</span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span style="color: white"><?php echo $totalsellcount; ?></span></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-6 mb-4">
        <div class="card shadow border-start-success py-2" style="background-image: linear-gradient(145deg, #2E2E2E 10%, #575757 100%);">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Összes eladás (USD)</span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span style="color: white">$<?php echo $totalsellusd; ?></span></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div><div class="row">
    <div class="col-md-6 col-xl-6 mb-4">
        <div class="card shadow border-start-primary py-2" style="background-image: linear-gradient(145deg, #2E2E2E 10%, #575757 100%);">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span style="color:#00A6FF">Legtöbb eladás</span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span style="color: white"><?php  echo $maxsell; ?></span></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-6 mb-4">
        <div class="card shadow border-start-primary py-2" style="background-image: linear-gradient(145deg, #2E2E2E 10%, #575757 100%);">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Legtöbb bevétel</span></div>
                        <div class="text-dark fw-bold h5 mb-0"><span style="color: white"><?php  echo $maxsellusd; ?></span></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-money-bill fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
                    <div class="row">
                        <div class="col" style="height: 100%;"><div class="bootstrap_datatables" style="width:100%;">
<div class="container py-5" style="width:100%">
  <div class="row py-5" style="width:100%">
    <div class="col-lg-10 mx-auto" style="width:100%">
      <div class="card rounded shadow border-0" style="width:100%">
        <div class="card-body p-5 bg-white rounded" style="width:100%;background-image: linear-gradient(145deg, #2E2E2E 10%, #575757 100%);color:white;">
          <div class="table-responsive" style="width:100%">
            <table id="example" style="width:100%" class="table table-striped table-bordered" style="width:100%">
              <thead>
                  <h3 style="padding-bottom:15px;color:white;font-weight:bold;">Gym Eseménynapló</h3>
                <tr style="text-align:center;color:white;">
                  <th>Esemény ideje</th>
                  <th>Esemény típusa</th>
                  <th>Alkalmazott</th>
                  <th>Esemény összegzése</th>
                </tr>
              </thead>
              <tbody style="text-align:center;color:white;">
                <?php
                
                if ($log_result->num_rows > 0) {
                    // output data of each row
                    while($row = $log_result->fetch_assoc()) {
                        //$row["id"]
                        echo '<tr style="color:white;"> <td>'.$row["mikor"].'</td><td>'.$row["type"].'</td><td>'.$row["ki"].'</td><td>'.$row["kiir"].'</td></tr>';
                    }
                }
                
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div></div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer" style="background-color: #0e0e0e;background-image: linear-gradient(100deg, #474747 10%, #474747 100%);">
            <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © GymParadise 2021 [Website by: <a href="https://varga-levente.com/">Varga Levente]</a></span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/Bootstrap-DataTables.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/search.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
<?php
$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>