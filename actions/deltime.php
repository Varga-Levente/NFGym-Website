<?php
session_start();
if(isset($_SESSION['sess_IC_name']) && isset($_SESSION['sess_login_name']) && isset($_GET['id'])){
    require 'sqlconn.php';
    $delsql = 'DELETE FROM gym_aktivitas WHERE ID = "'.$_GET['id'].'"';
    if ($conn->query($delsql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: /user/jelenleti.php?succ=Sikeres törlés.");
    } else {
        echo "Error deleting record: " . $conn->error;
        header("Location: /user/jelenleti.php?err=Adatbázis hiba.");
    }
}else{
    header("Location: /index.php?err=Jelentkezz be, hogy használhasd a jelenlétit.");
    echo "Nincs belépve";
}
$conn->close();
?>