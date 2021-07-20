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
  <html lang="en">

  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
      <title>GYM</title>
      <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
      <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
      <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
      <link rel="stylesheet" href="assets/css/Bootstrap-DataTables.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">
      <link rel="stylesheet" href="assets/css/Navigation-with-Search-1.css">
      <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
      <link rel="stylesheet" href="assets/css/styles.css">
      <style>
        ::-webkit-scrollbar {
            width: 0;  /* Remove scrollbar space */
            background: transparent;  /* Optional: just make scrollbar invisible */
        }
        /* Optional: show position indicator in red */
        ::-webkit-scrollbar-thumb {
            background: #FF0000;
        }
      </style>
  </head>

  <body style="background-image: linear-gradient(180deg, #0e0e0e 50%, #474747 100%);">
  <nav class="navbar navbar-light navbar-expand-md navigation-clean-search" style="background-image: linear-gradient( 100deg , #0e0e0e 25%, #474747 100%);color: white;border-bottom: 1px white solid;position: fixed;top: 0;left: 0;z-index: 999;width: 100%;">
    <div class="container"><a class="navbar-brand" href="#">GYM Paradise</a><button data-bs-toggle="collapse" data-bs-target="#navcol-1" class="navbar-toggler"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navcol-1">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Számlázás</a></li>
          <li class="nav-item"><a class="nav-link active" href="jelenleti.php">Jelenléti</a></li>
          <li class="nav-item"><a class="nav-link" href="ticket.php">Ticket</a></li>
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
  <div class="bootstrap_datatables" style="min-height: 91.4vh;margin-top: 80px;">
  <div class="container py-5">
    <header class="text-center text-black">
      <h1 class="display-4" style="color:white;">Aktivitás</h1>
      <h4 class="display-10" style="color:white;">
        <?php

        $times = array();

        $donetime = 'SELECT * FROM gym_aktivitas WHERE inwork=0 AND IC_name="'.$_SESSION['sess_IC_name'].'"';
        $result = $conn->query($donetime);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {

            $date1 = strtotime($row['kezdes']); 
            $date2 = strtotime($row['vegzes']); 
              
            // Formulate the Difference between two dates
            $diff = abs($date2 - $date1); 
              
            $years = floor($diff / (365*60*60*24)); 
              
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 

            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
              
            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60)); 
              
            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
              
            $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24- $hours*60*60 - $minutes*60)); 
              
            $times[] = sprintf("%d:%d", $hours, $minutes);
          }
        }
        echo "Heti szolgálati idő: ".AddPlayTime($times);

        $activityupdatesql = 'UPDATE gym_users SET activity="'.AddPlayTime($times).'" WHERE login_name="'.$_SESSION['sess_login_name'].'"';
        $conn->query($activityupdatesql);
        ?>
      </h4>
    </header>
    <div class="row py-5">
      <div class="col-lg-10 mx-auto">
        <div class="card rounded shadow border-0" style="background-color: transparent;-webkit-box-shadow: 5px 5px 13px 5px rgba(101,101,101,0.67) !important;box-shadow: 5px 5px 13px 5px rgba(101,101,101,0.67) !important;">
          <div class="card-body p-5 bg-white rounded" style="background-color:transparent !important;">
            <div class="table-responsive">
                <?php
                if(isset($_GET['succ'])){
                  echo '<div role="alert" class="alert alert-success alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span><strong>Siker! </strong>'.$_GET['succ'].'</span></div>';
                }elseif(isset($_GET['err'])){
                  echo '<div role="alert" class="alert alert-danger alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span><strong>HIBA! </strong>'.$_GET['err'].'</span></div>';
                }
                ?>
                <button style="width:100%;margin-bottom:20px;" class="btn btn-primary" type="button" data-bs-target="#addtime" data-bs-toggle="modal">Új aktivitás hozzáadása</button>
              <table id="example" style="width:100%;" class="table table-striped table-dark table-bordered">
                <thead>
                  <tr>
                    <th>Munkanap</th>
                    <th>Kezdés ideje</th>
                    <th>Végzés ideje</th>
                    <th>Eszközök</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  
                  if ($time_result->num_rows > 0) {
                    while($row = $time_result->fetch_assoc()) {
                      if($row['inwork']==1){
                        echo '<tr style="background-color:rgba(240, 56, 73, 0.5);">';
                        $endtime = "<b>??:??</b>";
                      }else{
                        echo "<tr>";
                        $endtime = date('H', strtotime($row["vegzes"])).':'.date('i', strtotime($row["vegzes"]));
                      }
                      echo '<td>'.date('Y-m-d', strtotime($row["kezdes"])).'</td><td>'.date('H', strtotime($row["kezdes"])).':'.date('i', strtotime($row["kezdes"])).'</td><td>'.$endtime.'</td><td> <center> <button class="btn btn-warning" type="button" style="padding-top: 7px;padding-bottom: 7px;padding-right: 10px;padding-left: 10px;border-radius: 50px;margin-right:5px;" data-bs-toggle="modal" data-bs-target="#edittime-'.$row["ID"].'"><i class="fas fa-edit"></i></button> <button class="btn btn-danger" type="button" style="padding-top: 7px;padding-bottom: 7px;padding-right: 12px;padding-left: 12px;border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#deltime-'.$row["ID"].'"><i class="fas fa-trash-alt"></i></button> </center> </td></tr>';
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
  </div>

  <div class="modal fade" id="addtime" data-backdrop="true" data-keyboard="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Szolgálati idő hozzáadás</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="color:black;width:100%;">
            <form class="form-horizontal" style="width:100%;" method="post" action="/actions/addtime.php">
                  <div class="form-group" style="padding-bottom:10px;display:none;">
                      <label class="control-label col-sm-2" style="color:black;padding-bottom:5px;" for="email">Kezdés napja:</label>
                      <div class="col-sm-10">
                      <input type="text" class="form-control" readonly name="nap" id="email" value="<?php echo date("Y-m-d"); ?>">
                      </div>
                  </div>
                  <div class="form-group" style="padding-bottom:10px;">
                      <label class="control-label col-sm-10" style="color:black;padding-bottom:5px;" for="email">Kezdés ideje:</label>
                      <div class="col-sm-10">
                      <input type="text" class="form-control" name="starttime" id="email" required pattern="[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]" value="<?php echo date("Y-m-d H:i"); ?>">
                      </div>
                  </div>
                  <div class="form-group" id="hideme" style="padding-bottom:10px;">
                      <label class="control-label col-sm-2" style="color:black;padding-bottom:5px;" for="pwd">Végzés ideje:</label>
                      <div class="col-sm-10">
                      <input type="text" class="form-control" name="endtime" id="endtime" required pattern="[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]" value="<?php echo date("Y-m-d H:i", strtotime('+2 hours')); ?>">
                      </div>
                  </div>
                  <div class="form-group" style="padding-bottom:10px;">
                      <div class="col-sm-offset-2 col-sm-10">
                          <div class="checkbox">
                                <label style="color:black;"><input onclick="myFunction()" name="inwork" id="myCheck" type="checkbox"> Később adom meg a végzés időpontját.</label>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                      <button style="width:100%;" type="submit" class="btn btn-primary">Hozzáad</button>
                      </div>
                  </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Mégse</button>
            </div>
        </div>
    </div>
  </div>
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
  <?php

  $result = $conn->query($timesql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if($row["vegzes"] == "null"){
        $endofwork = date("Y-m-d H:i");
      }else{
        $endofwork =  substr($row["vegzes"], 0, -3);
      }
      echo '<div class="modal fade" id="edittime-'.$row["ID"].'" data-backdrop="true" data-keyboard="true"> <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content"> <div class="modal-header"> <h4 class="modal-title">Szolgálati idő módosítása</h4> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </div><div class="modal-body" style="color:black;width:100%;"> <form class="form-horizontal" style="width:100%;" method="post" action="/actions/edittime.php"> <div class="form-group" style="padding-bottom:10px;display:none;"> <label class="control-label col-sm-2" style="color:black;padding-bottom:5px;" for="email">ID:</label> <div class="col-sm-10"> <input type="text" class="form-control" readonly pattern="[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]" name="id" id="email" value="'.$row["ID"].'"> </div></div><div class="form-group" style="padding-bottom:10px;"> <label class="control-label col-sm-10" style="color:black;padding-bottom:5px;" for="email">Kezdés ideje:</label> <div class="col-sm-10"> <input type="text" class="form-control" name="starttime" id="email" required pattern="[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (2[0-3]|[01][0-9]):[0-5][0-9]" value="'.substr($row["kezdes"], 0, -3).'"> </div></div><div class="form-group" style="padding-bottom:10px;"> <label class="control-label col-sm-2" style="color:black;padding-bottom:5px;" for="pwd">Végzés ideje:</label> <div class="col-sm-10"> <input type="text" class="form-control" name="endtime" id="pwd" required value="'.$endofwork.'"> </div></div><div class="form-group"> <div class="col-sm-offset-2 col-sm-10"> <button style="width:100%;" type="submit" class="btn btn-primary">Módosít</button> </div></div></form> </div><div class="modal-footer"> <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Mégse</button> </div></div></div></div>';
      echo '<div class="modal top fade" id="deltime-'.$row["ID"].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true"> <div class="modal-dialog modal-dialog-centered"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Szolgálati idő törtlése</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </div><div class="modal-body"><center>Biztosan ki szeretné törölni ezt a szolgálati iőt?</center></div><div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> NEM </button> <a class="btn btn-danger" role="button" href="/actions/deltime.php?id='.$row["ID"].'">IGEN</a> </div></div></div></div>';
    }
  }

  ?>

      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
      <script src="assets/js/Bootstrap-DataTables.js"></script>
  </body>
  <script>
  function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("text");
    if (checkBox.checked == true){
      document.getElementById("hideme").disabled = true;
      document.getElementById("hideme").style.display = "none";
      document.getElementById("endtime").removeAttribute("required");
    } else {
      document.getElementById("hideme").disabled = false;
      document.getElementById("hideme").style.display = "block";
      document.getElementById("endtime").setAttribute("required", "required");
    }
  }
  </script>
  </html>
  <?php 
  $conn->close();
  }else{
      header("Location: ../index.php?err=Az oldal használatához be kell jelentkezned!");
  }
  ?>