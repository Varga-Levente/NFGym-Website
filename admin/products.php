<?php

session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
require '../actions/sqlconn.php';
$sql_items = "SELECT * FROM gym_arlista WHERE 1";
$item_result = $conn->query($sql_items);
$itemmodal_result = $conn->query($sql_items);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gym Paradise - Szerződések</title>
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
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Profilom</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="sells.php"><i class="fa fa-line-chart"></i><span>Eladások</span></a><a class="nav-link active" href="products.php"><i class="fas fa-shopping-basket"></i><span>Termékek</span></a><a class="nav-link" href="workers.php"><i class="fas fa-address-book"></i><span>Alkalmazottak</span></a><a class="nav-link" href="contracts.php"><i class="fas fa-pen-nib"></i><span>Szerződések</span></a><a class="nav-link" href="discounts.php"><i class="fas fa-percent"></i><span>Kedvezmények</span></a></li>
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
                    <h3 class="text-dark mb-4" style="color: white !important;text-shadow: 2px 1px #000000;">Termékek</h3>
                    <div class="card shadow">
                        <div class="card-header py-3" style="background: rgb(39,40,41);">
                            <p class="text-primary m-0 fw-bold" style="color: white !important;">Termékek</p>
                        </div>
                        <div class="card-body" style="background: #484848;color: white !important;">
                        <?php if(isset($_GET['success'])){ ?>
                            <div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span><strong>Siker!</strong> <?php echo $_GET['success']; ?></span></div>
                        <?php }elseif(isset($_GET['err'])){ ?>
                            <div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><span><strong>Hiba!</strong> <?php echo $_GET['err']; ?></span></div>
                        <?php } ?>
                            <div class="row" style="padding-bottom: 15px;padding-top: 15px;">
                                <div class="col-md-6 text-nowrap"><button class="btn btn-primary" type="button" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#addproduct">Új termék hozzáadása</button></div>
                                <div class="col-md-6">
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label" style="width: 100%;"><input type="search" id="myInput" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Termék keresése..." style="width: 100%;height: 38px;"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr style="width: 1148px;color: white !important;">
                                            <th style="width: 10%;color: white !important;">Termékfotó</th>
                                            <th style="width: 22%;color: white !important;">Termék megnevezése</th>
                                            <th style="width: 16%;color: white !important;">Termék ára</th>
                                            <th style="width: 16%;">Kedvezmény adható rá?</th>
                                            <th style="width: 16%;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        <?php
                                        if ($item_result->num_rows > 0) {
                                            // output data of each row
                                            while($row = $item_result->fetch_assoc()) {
                                                //$row["id"]
                                                $icon="check";
                                                $color="greenyellow";
                                                if($row['nodiscount']==1){
                                                    $icon="times";
                                                    $color="red";
                                                }
                                                echo '<tr style="color: white !important;"> <td style="line-height: 55px;"><img src="'.$row['itemimage'].'" style="max-width: 50px;"><br></td><td style="line-height: 55px;">'.$row['itemname'].'<br></td><td style="line-height: 55px;">$'.$row['itemprice'].'<br></td><td style="line-height: 55px;"><i class="fa fa-'.$icon.'" style="width: 100%;font-size: 25px;color: '.$color.';"></i></td><td style="line-height: 55px;"> <div style="text-align: center;"><button class="btn btn-primary" type="button" style="display: inline-block;" data-bs-toggle="modal" data-bs-target="#editproduct-'.$row['ID'].'">Szerkesztés</button><button class="btn btn-danger" type="button" style="display: inline-block;margin-left: 10px;" data-bs-toggle="modal" data-bs-target="#deleteproduct-'.$row['ID'].'"><i class="fas fa-trash-alt"></i></button></div></td></tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="color: white !important;">
                                            <td><strong>Termékfotó<br></strong></td>
                                            <td><strong>Termék megnevezése</strong><br></td>
                                            <td><strong>Termék ára<br></strong></td>
                                            <td><strong>Kedvezmény adható rá?<br></strong></td>
                                            <td style="text-align: center;"><strong>Actions</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
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
<div class="modal fade" id="addproduct" data-backdrop="true" data-keyboard="true">
   <div class="modal-dialog modal-lg modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
              <h4 class="modal-title">Új termék hozzáadása</h4>
               <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
           </div>
          <div class="modal-body" style="color:black;width:100%;">
          <form class="form-horizontal" style="width:100%;" method="post" action="../actions/add_product.php">
                <div class="form-group" style="padding-bottom:10px;">
                    <label class="control-label col-sm-3" style="color:black;padding-bottom:5px;" for="email">Termék megnevezése:</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="productname" id="email" required placeholder="Termék megnevezése...">
                    </div>
                </div>
                <div class="form-group" style="padding-bottom:10px;">
                    <label class="control-label col-sm-3" style="color:black;padding-bottom:5px;" for="email">Termék ára:</label>
                    <div class="col-sm-2">
                    <div class="input-group"> <input type="number" class="form-control" required="" placeholder="0" style="text-align: center;" name="productprice"> <div class="input-group-append"><span class="input-group-text">$&nbsp;</span></div></div>
                    </div>
                </div>
                <div class="form-group" style="padding-bottom:10px;">
                    <label class="control-label col-sm-10" style="color:black;padding-bottom:5px;" for="email">Termékfotó URL-je:</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" name="productphotourl" id="email" required value="https://i.ibb.co/LJ3vMVC/image-missing.png">
                    </div>
                </div>
                <div class="form-group" style="padding-bottom:10px;">
                    <div class="col-sm-offset-2 col-sm-10">
                         <div class="checkbox">
                               <label style="color:black;"><input name="activediscount" type="checkbox" checked> Kedvezmény adható rá?</label>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <button style="width:100%;" type="submit" class="btn btn-primary">Hozzáadás</button>
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
<?php

    if ($itemmodal_result->num_rows > 0) {
        // output data of each row
        while($row = $itemmodal_result->fetch_assoc()) {
            //$row["id"]
            $checkbox="";
            if($row['nodiscount']==0){
                $checkbox="checked";
            }
            echo '<div class="modal fade" id="editproduct-'.$row['ID'].'" data-backdrop="true" data-keyboard="true"> <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content"> <div class="modal-header"> <h4 class="modal-title">Termék módosítása</h4> <button type="button" class="close" data-bs-dismiss="modal">&times;</button> </div><div class="modal-body" style="color:black;width:100%;"> <form class="form-horizontal" style="width:100%;" method="post" action="../actions/edit_product.php"> <div class="form-group" style="padding-bottom:10px;"> <label class="control-label col-sm-3" style="color:black;padding-bottom:5px;" for="email">Termék azonosítója:</label> <div class="col-sm-10"> <input type="text" class="form-control" name="id" id="email" readonly value="'.$row['ID'].'"> </div></div><div class="form-group" style="padding-bottom:10px;"> <label class="control-label col-sm-3" style="color:black;padding-bottom:5px;" for="email">Termék megnevezése:</label> <div class="col-sm-10"> <input type="text" class="form-control" name="productname" id="email" required value="'.$row['itemname'].'"> </div></div><div class="form-group" style="padding-bottom:10px;"> <label class="control-label col-sm-3" style="color:black;padding-bottom:5px;" for="email">Termék ára:</label> <div class="col-sm-2"> <div class="input-group"> <input type="number" class="form-control" required="" value="'.$row['itemprice'].'" style="text-align: center;" name="productprice"> <div class="input-group-append"><span class="input-group-text">$&nbsp;</span></div></div></div></div><div class="form-group" style="padding-bottom:10px;"> <label class="control-label col-sm-10" style="color:black;padding-bottom:5px;" for="email">Termékfotó URL-je:</label> <div class="col-sm-10"> <input type="text" class="form-control" name="productphotourl" id="email" required value="'.$row['itemimage'].'"> </div></div><div class="form-group" style="padding-bottom:10px;"> <div class="col-sm-offset-2 col-sm-10"> <div class="checkbox"> <label style="color:black;"><input name="active" type="checkbox" '.$checkbox.'> Kedvezmény adható rá?</label> </div></div></div><div class="form-group"> <div class="col-sm-offset-2 col-sm-10"> <button style="width:100%;" type="submit" class="btn btn-primary">Módosítás</button> </div></div></form> </div><div class="modal-footer"> <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Mégse</button> </div></div></div></div><div class="modal fade" id="deleteproduct-'.$row['ID'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> <div class="modal-dialog" role="document"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Termék törlése</h5> <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div><div class="modal-body"> <p style="font-size:110%;text-align:center;">Biztosan ki szeretnéd törölni ezt a terméket?</p><p style="text-align:center;color:red;">'.$row['itemname'].'</p></div><div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégse</button> <a class="btn btn-danger" role="button" href="../actions/delete_product.php?id='.$row['ID'].'&a='.$row['itemname'].'">Törlés</a> </div></div></div></div>';
        }
    }

?>
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