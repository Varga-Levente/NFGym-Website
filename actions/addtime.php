<?php
session_start();
if(isset($_SESSION['sess_IC_name']) && isset($_SESSION['sess_login_name'])){
    if(isset($_POST['nap']) && isset($_POST['starttime'])){
        require 'sqlconn.php';
        $starttime = $_POST['starttime'].":00";
        if(isset($_POST['inwork'])){
            $endtime = "null";
            $inworksql = 'INSERT INTO gym_aktivitas (IC_name, kezdes, vegzes, day, inwork, lastedit) VALUES ("'.$_SESSION['sess_IC_name'].'", "'.$starttime.'", "'.$endtime.'", "'.$_POST['nap'].'", "1", "'.date("Y-m-d H:i:s").'");';
            if ($conn->query($inworksql) === TRUE) {
                echo "New record created successfully";
                header("Location: /user/jelenleti.php?succ=Sikeres hozzáadás.");
            }else{
                echo "Error: " . $sql . "<br>" . $conn->error;
                header("Location: /user/jelenleti.php?err=Adatbázis hiba.");
                $conn->close();
            }
        }else{
            if(isset($_POST['endtime'])){
                $endtime = $_POST['endtime'].":00";
                $endwork = 'INSERT INTO gym_aktivitas (IC_name, kezdes, vegzes, day, inwork, lastedit) VALUES ("'.$_SESSION['sess_IC_name'].'", "'.$starttime.'", "'.$endtime.'", "'.$_POST['nap'].'", "0", "'.date("Y-m-d H:i:s").'");';
                if ($conn->query($endwork) === TRUE) {
                    echo "New record created successfully";
                    header("Location: /user/jelenleti.php?succ=Sikeres hozzáadás.");
                }else{
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    header("Location: /user/jelenleti.php?err=Adatbázis hiba.");
                    $conn->close();
                }
            }else{
                header("Location: /user/jelenleti.php?err=Hiányos adatok.");
                echo "Nincs megadva: endtime";
                $conn->close();
            }
        }
    }else{
        header("Location: /user/jelenleti.php?err=Hiányos adatok.");
        echo "Nincs megadva: nap vagy starttime";
        $conn->close();
    }
}else{
    header("Location: /index.php?err=Jelentkezz be, hogy használhasd a jelenlétit.");
    echo "Nincs belépve";
    $conn->close();
}
$conn->close();
?>