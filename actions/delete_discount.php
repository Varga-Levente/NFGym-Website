<?php
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
require 'sqlconn.php';
if(isset($_GET['id']) && $_GET['id']!=null){
    $deletesql='DELETE FROM gym_discounts WHERE ID="'.$_GET['id'].'"';
    if ($conn->query($deletesql) === TRUE) {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Kedvezmény törölve", "'.$icandloginname.'", "Az alábbi kedvezmény törölve lett: '.$_GET['a'].'", "'.date("Y-m-d H:i:s").'")';
        $conn->query($sqllog);
        echo "Record deleted successfully";
        header("Location: ../admin/discounts.php?success=Kedvezmény sikeresen törölve.");
    } else {
        echo "Error deleting record: " . $conn->error;
        header("Location: ../admin/discounts.php?err=Adatbázis hiba!");
    }
}else{
    header("Location: ../admin/discounts.php?err=Adat átadási hiba!");
}
$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>