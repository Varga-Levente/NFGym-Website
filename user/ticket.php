<?php
      session_start();
  if(isset($_SESSION['sess_IC_name']) && isset($_SESSION['sess_login_name'])){

      require '../actions/sqlconn.php';

      $timesql = 'SELECT * FROM gym_aktivitas WHERE IC_name="'.$_SESSION['sess_IC_name'].'"';
      $time_result = $conn->query($timesql);

      function AddPlayTime($times) {
        $minutes = 0;
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }
    
        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;
    
        // returns the time already formatted
        if(ltrim(sprintf('%02dóra %02dperc', $hours, $minutes), '0') == "óra 00perc"){
          return "0óra 0perc";
        }else{
          return ltrim(sprintf('%02dóra %02dperc', $hours, $minutes), '0');
        }
        
    }
    $sql_stats = 'SELECT sells, sellinusd, admin FROM gym_users WHERE IC_name="'.$_SESSION["sess_IC_name"].'"';
    $stats_result = $conn->query($sql_stats);
    $eladas=0;
    $eladottusd=0;
    $adminevagy=0;
    if ($stats_result->num_rows > 0) {
    // output data of each row
    while($row = $stats_result->fetch_assoc()) {
        $eladas=$row["sells"];
        $eladottusd=$row["sellinusd"];
        $adminevagy=$row["admin"];
    }
    }else{
        echo "Ooops.";
    }
    $sql_contracts = 'SELECT * FROM gym_contracts WHERE state="1"';
    $contracts_result = $conn->query($sql_contracts);

  ?>
<!DOCTYPE html>
<html lang="en" style="background-image: linear-gradient(180deg, #0e0e0e 50%, #474747 100%);">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GYM</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Bootstrap-DataTables.css">
    <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/Navigation-Dark-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search-1.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/TPC-Navigation-with-Phone-Left-Logo-Centered-Menu-Right.css">
    <link rel="stylesheet" href="assets/css/x-dropdown.css">
</head>

<body style="/*background-image: linear-gradient(180deg, #0e0e0e 50%, #474747 100%);*/">
<nav class="navbar navbar-light navbar-expand-md navigation-clean-search" style="background-image: linear-gradient( 100deg , #0e0e0e 25%, #474747 100%);color: white;border-bottom: 1px white solid;position: fixed;top: 0;left: 0;z-index: 999;width: 100%;">
    <div class="container"><a class="navbar-brand" href="#">GYM Paradise</a><button data-bs-toggle="collapse" data-bs-target="#navcol-1" class="navbar-toggler"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navcol-1">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Számlázás</a></li>
          <li class="nav-item"><a class="nav-link" href="jelenleti.php">Jelenléti</a></li>
          <li class="nav-item"><a class="nav-link active" href="ticket.php">Ticket</a></li>
        </ul>
        <form class="me-auto search-form" target="_self">
          
        </form>
        <?php if($adminevagy==1){ ?>
          <a class="btn btn-light action-button" role="button" href="/admin/index.php" style="margin-right: 5px;background: var(--bs-purple);"><i class="fas fa-user-shield"></i> Admin</a>
        <?php } ?>
        <button class="btn btn-light action-button" type="button" style="margin-right: 5px;background: var(--bs-blue);" data-bs-toggle="modal" data-bs-target="#kedvezmenyek"><i class="fas fa-percent"></i> Kedvezmények</button>
        <button class="btn btn-light action-button" type="button" style="margin-right: 5px;background-color: #2db191 !important;" data-bs-toggle="modal" data-bs-target="#stats"><i class="fas fa-chart-pie"></i> Statisztikáim</button>
        <a class="btn btn-danger action-button" role="button" href="/actions/logout.php" style="background: var(--bs-red);"><i class="fas fa-sign-out-alt"></i> Kijelentkezés</a>
      </div>
    </div>
  </nav>
    <section class="login-dark">
        <form style="background-color:rgba(79, 79, 79,0.5); !important;color: white !important;" data-bss-recipient="24a98b1d56a8c0e25b89fa65df7c340d" data-bss-loading-message="Küldés..." data-bss-success-title="Siker" data-bss-success-message="Az üzeneted sikeresen el lett küldve." data-bss-error-title="Oops..." data-bss-error-message="Valami nem jó." data-bss-close="Bezár" data-bss-redirect-url="ticket.php?succ=&quot;Ticket sikeresen elküldve.&quot;" data-bss-subject="GYM Site Ticket">
            <h2 class="visually-hidden">Login Form</h2>
            <div class="illustration">
                <h1 style="color: white !important;">Ticket</h1>
            </div>
            <div class="mb-3"><input class="form-control" type="text" name="Username" readonly required="" value="<?php echo $_SESSION['sess_login_name']; ?>"></div>
            <div class="mb-3"><input class="form-control" type="text" name="IC name" readonly required="" value="<?php echo $_SESSION['sess_IC_name']; ?>"></div>
            <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email" required=""></div>
            <div class="mb-3"><input class="form-control" type="text" placeholder="Tárgy" name="Subject" required=""></div>
            <div class="mb-3"><textarea class="form-control" placeholder="Probléma / Javaslat kifejtése..." rows="10" name="Message" required=""></textarea></div>
            <div class="mb-3"><button style="color: white !important;background-color:rgb(50, 50, 50) !important;" class="btn btn-primary d-block w-100" type="submit">Küldés</button></div>
        </form>
    </section>
    <div class="modal top fade" id="kedvezmenyek" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered">
            <div style="background-color:#222222;color:white;" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kedvezmények</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row" style="margin-bottom: 9px;border-bottom: 1px white solid;">
                            <div class="col-md-4">
                                <p style="margin-bottom: 0px;font-weight: bold;text-align: center;">Cég</p>
                            </div>
                            <div class="col-md-4">
                                <p style="margin-bottom: 0px;text-align: center;font-weight: bold;">Edzés kedvezmény</p>
                            </div>
                            <div class="col-md-4">
                                <p style="margin-bottom: 0px;text-align: center;font-weight: bold;">Termék kedvezmény</p>
                            </div>
                        </div>

                        <?php
                        if ($contracts_result->num_rows > 0) {
                            while($row = $contracts_result->fetch_assoc()) {
                                echo '<div class="row" style="margin-bottom: 9px;border-bottom: 1px white dotted;"> <div class="col-md-4"> <p style="margin-bottom: 0px;font-weight: bold;text-align: center;">'.$row['company'].'</p></div><div class="col-md-4"> <p style="margin-bottom: 0px;text-align: center;">'.$row['discount_edzes'].'</p></div><div class="col-md-4"> <p style="margin-bottom: 0px;text-align: center;">'.$row['discount_termek'].'</p></div></div>';
                            }
                        }
                        ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" style="border: none;background: rgb(194,194,194);color: rgb(255,255,255);" type="button" data-bs-dismiss="modal">Bezár</button>
                </div>
            </div>
        </div>
    </div>
  <div class="modal top fade" id="stats" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
        <div class="modal-dialog modal-sm  modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Statisztikám</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <p style="text-align:center;"><b>Eladásaim:</b> <?php echo $eladas; ?></p>
                    <p style="text-align:center;"><b>Eladott érték:</b> <?php echo "$".$eladottusd; ?></p>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Bezár
                </button>
            </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/smart-forms.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/Bootstrap-DataTables.js"></script>
</body>

</html>
<?php 
  $conn->close();
  }else{
      header("Location: ../index.php?err=Az oldal használatához be kell jelentkezned!");
  }
  ?>