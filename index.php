<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GYM_Login</title>
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

<body>
    <div class="container-fluid">
        <div class="row mh-100vh">
            <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0" id="login-block" style="background-image: linear-gradient(130deg, #365178 10%, #213451 100%);">
                <div class="m-auto w-lg-75 w-xl-50">
                    <h2 class="text-info fw-light mb-5" style="color: #ffffff !important;text-align: center;margin-bottom: 0px !important;"><i class="fas fa-dumbbell"></i>&nbsp;Gym Paradise</h2>
                    <h5 class="text-info fw-light mb-5" style="color: #ffffff !important;text-align: center;">Bejelentkezés</h5>
                    <?php
                    
                    if(isset($_GET['err'])){
                        echo '<div class="alert alert-danger alert-dismissible" role="danger"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span><strong>Hiba!</strong> '.$_GET['err'].'</span></div>';
                    }elseif(isset($_GET['success'])){
                        echo '<div class="alert alert-success alert-dismissible" role="danger"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span><strong>Siker!</strong> '.$_GET['success'].'</span></div>';
                    }
                    
                    ?>
                    <form action="/actions/login.php" method="post">
                        <div class="form-group mb-3"><label class="form-label text-secondary" style="color: white !important;">Felhasználónév</label><input class="form-control" type="text" required="" inputmode="email" name="uname"></div>
                        <div class="form-group mb-3"><label class="form-label text-secondary" style="color: white !important;">Jelszó</label><input class="form-control" type="password" required="" name="pwd"></div><button class="btn btn-info mt-2" type="submit" style="background-color: var(--bs-blue) !important;color: white;width: 100%;box-shadow: 0 0 0 .25rem rgba(78,115,223,0.24);border: none;">Belépés</button>
                    </form>
                    <p class="mt-3 mb-0"><a class="text-info small" href="cpwd.php">Elfelejtetted a jelszavad?</a></p>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-end" id="bg-block" style="background: url(&quot;assets/img/gym.png&quot;) center / cover no-repeat;">
                <p class="ms-auto small text-dark mb-2"><br></p>
            </div>
        </div>
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