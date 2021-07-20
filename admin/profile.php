<?php

session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gym Paradise - Profilom</title>
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

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background-color: #0e0e0e;background-image: linear-gradient(180deg, #0e0e0e 10%, #474747 100%);">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-dumbbell"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Gym Paradise</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Irányítópult</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="profile.php"><i class="fas fa-user"></i><span>Profilom</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="sells.php"><i class="fa fa-line-chart"></i><span>Eladások</span></a><a class="nav-link" href="products.php"><i class="fas fa-shopping-basket"></i><span>Termékek</span></a><a class="nav-link" href="workers.php"><i class="fas fa-address-book"></i><span>Alkalmazottak</span></a><a class="nav-link" href="contracts.php"><i class="fas fa-pen-nib"></i><span>Szerződések</span></a><a class="nav-link" href="discounts.php"><i class="fas fa-percent"></i><span>Kedvezmények</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
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
                    <h3 class="text-dark mb-4" style="color: white !important;text-shadow: 2px 1px #000000;">Profil beállítások</h3>
                    <div class="row mb-3">
                        <div class="col col-md-12">
                            <div class="card shadow mb-3" style="background: rgb(0,0,0);border: 1px black solid;">
                                <div class="card-header py-3" style="background: rgb(39,40,41);">
                                    <p class="text-primary m-0 fw-bold" style="color: white !important;">Profil beállítások</p>
                                </div>
                                <div class="card-body" style="background: #484848;">
                                    <?php if(isset($_GET['success'])){ ?>
                                    <div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span><strong>Siker!</strong> A profilod sikeresen módosítva lett.</span></div>
                                    <?php }elseif(isset($_GET['err'])){ ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span><strong>Hiba!</strong> <?php echo $_GET['err']; ?></span></div>
                                    <?php } ?>
                                    <form action="../actions/edit_profile.php" method="post">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="username"><strong>Belépési név</strong></label><input class="form-control" type="text" id="username" value="<?php echo $_SESSION['sess_login_name']; ?>" name="username" readonly></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="username"><strong>IC név</strong></label><input class="form-control" type="text" id="username-1" value="<?php echo $_SESSION['sess_IC_name']; ?>" name="icname" readonly></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="first_name"><strong>Régi jelszó</strong></label><input class="form-control" type="password" required name="oldpw" placeholder="Régi jelszó"></div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3"><label class="form-label" for="last_name"><strong>Új Jelszó</strong><br></label><input class="form-control" type="password" required name="newpw" placeholder="Új jelszó"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" style="width: 100%;">Mentés</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>