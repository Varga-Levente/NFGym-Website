<?php
    session_start();
if(isset($_SESSION['sess_IC_name']) && isset($_SESSION['sess_login_name'])){

    require '../actions/sqlconn.php';
    
    $sql_items = "SELECT * FROM gym_arlista WHERE 1";
    $sql_calc1 = "SELECT * FROM gym_arlista WHERE nodiscount=0";
    $sql_calc2 = "SELECT * FROM gym_arlista WHERE nodiscount=1";
    $sql_discounts = 'SELECT * FROM gym_discounts WHERE state="1"';
    $sql_stats = 'SELECT sells, sellinusd, admin FROM gym_users WHERE IC_name="'.$_SESSION["sess_IC_name"].'"';
    $sql_contracts = 'SELECT * FROM gym_contracts WHERE state="1"';

    $item_result = $conn->query($sql_items);
    $calc1_result = $conn->query($sql_calc1);
    $calc2_result = $conn->query($sql_calc2);
    $discounts_result = $conn->query($sql_discounts);
    $contracts_result = $conn->query($sql_contracts);

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
    
?>
<!DOCTYPE html>
<html lang="en" style="background-image: linear-gradient(145deg, #0e0e0e 25%, #474747 100%);">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gym Paradise - Számlázás</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/img/site.webmanifest">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    </script>
    <script>
        $(document).ready(function() {
            $('#payed').modal('show');
        });
    </script>
    <script>
        $(document).ready(function(){
        $("#searchinput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable a").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        });
    </script>
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

<body style="background-image: linear-gradient(145deg, #0e0e0e 25%, #474747 100%);overflow-y: scroll;">
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-search" style="background-image: linear-gradient( 100deg , #0e0e0e 25%, #474747 100%);color: white;border-bottom: 1px white solid;position: fixed;top: 0;left: 0;z-index: 999;width: 100%;">
        <div class="container"><a class="navbar-brand" href="#">GYM Paradise</a><button data-bs-toggle="collapse" data-bs-target="#navcol-1" class="navbar-toggler"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Számlázás</a></li>
                    <li class="nav-item"><a class="nav-link" href="jelenleti.php">Jelenléti</a></li>
                    <li class="nav-item"><a class="nav-link" href="ticket.php">Ticket</a></li>
                </ul>
                <form class="me-auto search-form" target="_self">
                    <div class="d-flex align-items-center"><label class="form-label d-flex mb-0" for="search-field"><i class="fa fa-search" style="margin-right: 10px;"></i></label><input type="search" class="form-control search-field" id="searchinput" name="search" style="background: rgba(164,164,164,0.23);border-radius: 50px;color: white !important;" placeholder="Termék keresése..." /></div>
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

    <form style="color: white;" action="/actions/sum.php" method="post">
        <div class="container" id="myTable" style="margin-top: 90px;margin-bottom: 70px;width: 100%;">
            
            <?php
            if ($item_result->num_rows > 0) {
                // output data of each row
                while($row = $item_result->fetch_assoc()) {
                    //$row["id"]
                    echo '<a><div class="row" style="/*height: 100px;*//*line-height: 100px;*/justify-content: center;align-items: center;margin-bottom: 20px;"> <div class="col col-md-2" style="text-align: center;"><center><img src="'.$row["itemimage"].'" style="max-width: 50px;"></center></div><div class="col col-md-8"> <p style="margin-bottom: 0px;justify-content: center;align-items: center;font-size: 25px;display: inline-block;font-weight: bold;">'.$row["itemname"].'</p><p id="'.$row["ID"].'-price" style="margin-bottom: 0px;justify-content: center;align-items: center;font-size: 25px;display: inline-block;float: right;">$'.$row["itemprice"].'</p></div><div class="col col-md-2"> <div class="input-group"><input onkeyup="sum()" class="form-control" type="number" id="'.$row["ID"].'-qty" required value="0" min="0" style="text-align: center;" name="item-'.$row["ID"].'"> <div class="input-group-append"><span class="input-group-text">db</span></div></div></div></div></a>';
                }
            }
            ?>

            <div id="footer" class="container">
    <div class="row">
        <div class="col-md-3">
            <select class="form-select" id="discount" name="discount">
                <optgroup label="Kedvezmények">
                    <option value="0" selected>Nincs kedvezmény</option>
                    <?php
                    if ($discounts_result->num_rows > 0) {
                        // output data of each row
                        while($row = $discounts_result->fetch_assoc()) {
                            //$row["id"]
                            echo '<option value="'.$row["szazalek"].'">'.$row["label"].'</option>';
                        }
                    }
                    ?>
                </optgroup>
            </select>
        </div>
        <div class="col-md-9">
            <button class="btn btn-success" id="sumbtn" disabled type="submit" style="width: 100%;"><b>Összegzés</b> $<span id="rtcalc">0</span></button>
        </div>
    </div>
</div>
        </div>
    </form>
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
        if(isset($_GET["items"])){ 
            $items = explode(";", $_GET['items']);
    ?>
    <div class="modal top fade" id="payed" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
        <div class="modal-dialog modal-sm  modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Összegzés</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <p style="text-align:left;margin:0px;padding:0px;font-size:110%;padding-bottom:10px;"><b>Tételek:<br></b></p>
                    <p style="text-align:center;">
                        <?php
                            foreach($items as $value){
                                echo '<span style="text-align:center;font-size:105%;">'.$value . "</span><br>";
                            }
                        ?>
                    </p>
                    <p style="text-align:center;border-bottom:1px black dotted;border-top:1px black dotted;font-size:110%;"><b>Fizetendő:</b><i> <?php echo "$".$_GET['sum']; ?></i></p>
                </div>
            <div class="modal-footer">
                <button style="width:100%;" type="button" class="btn btn-success" data-bs-dismiss="modal">
                    Kész
                </button>
            </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
<script>
    document.getElementById("discount").onchange = sum;
    function sum() {
        var sum = 0;
        var nodiscount = 0;

        <?php
        if ($calc1_result->num_rows > 0) {
            // output data of each row
            while($row = $calc1_result->fetch_assoc()) {
                //$row["id"]
                echo 'sum=sum+(document.getElementById("'.$row["ID"].'-price").textContent.substring(1)*document.getElementById("'.$row["ID"].'-qty").value);'.PHP_EOL;
            }
        }
        ?>

        <?php
        if ($calc2_result->num_rows > 0) {
            // output data of each row
            while($row = $calc2_result->fetch_assoc()) {
                //$row["id"]
                echo 'nodiscount=nodiscount+(document.getElementById("'.$row["ID"].'-price").textContent.substring(1)*document.getElementById("'.$row["ID"].'-qty").value);'.PHP_EOL;
            }
        }
        ?>
        var sumsum = sum+nodiscount;
        if(sumsum==0){
            document.getElementById("sumbtn").disabled = true;
        }else{
            document.getElementById("sumbtn").disabled = false;
        }

        if(document.getElementById("discount").value/100 == 0){
            sum=sum+nodiscount;
            document.getElementById("rtcalc").textContent = sum;
        }else if(document.getElementById("discount").value/100 == 1){
            sum=0;
            document.getElementById("rtcalc").textContent = sum;
        }else{
            sum=sum-(sum*document.getElementById("discount").value/100);
            sum=sum+nodiscount;
            document.getElementById("rtcalc").textContent = sum;
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