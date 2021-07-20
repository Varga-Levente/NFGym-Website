<?php
//id=28&starttime=2021-07-15+03%3A02&endtime=2021-07-15+05%3A02
session_start();
if(isset($_SESSION['sess_IC_name']) && isset($_SESSION['sess_login_name'])){
    if(isset($_POST['id']) && isset($_POST['starttime']) && isset($_POST['endtime'])){
        require 'sqlconn.php';
        $modsql = 'UPDATE gym_aktivitas SET kezdes="'.$_POST['starttime'].':00", vegzes="'.$_POST['endtime'].':00", inwork="0", lastedit="'.date("Y-m-d H:i:s").'" WHERE ID="'.$_POST['id'].'"';
        if ($conn->query($modsql) === TRUE) {
            echo "Record deleted successfully";
            header("Location: /user/jelenleti.php?succ=Sikeres módosítás.");
        } else {
            echo "Error deleting record: " . $conn->error;
            header("Location: /user/jelenleti.php?err=Adatbázis hiba.");
        }
    }else{
        header("Location: /user/jelenleti.php?err=Hiányos adatok!");
        echo "Nincs belépve";
    }
}else{
    header("Location: /index.php?err=Jelentkezz be, hogy használhasd a jelenlétit.");
    echo "Nincs belépve";
}
$conn->close();
?>