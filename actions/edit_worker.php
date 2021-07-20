<?php
//?id=7&loginname=Varga.Levente.Istvan&icname=George+Adams+2&resetpw=on&admin=on
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['id']) && isset($_POST['loginname']) && isset($_POST['icname']) ){

    if(isset($_POST['resetpw']) && !isset($_POST['admin'])){
        echo "Only resetpw";
        $updaterow = 'UPDATE gym_users SET login_name="'.$_POST['loginname'].'", IC_name="'.$_POST['icname'].'", login_password="'.hash("sha512", "NFGym").'", admin="0", cpwd="1" WHERE ID="'.$_POST['id'].'"';
        $successmessage = "A felhasználó módosítva, jelszava visszaállítva erre: <b>NFGym</b><br>A változtatáshoz szükséges token: <b>".md5($_POST['loginname']).'</b>';
    }
    elseif(isset($_POST['admin']) && !isset($_POST['resetpw'])){
        echo "Only admin";
        $updaterow = 'UPDATE gym_users SET login_name="'.$_POST['loginname'].'", IC_name="'.$_POST['icname'].'", admin="1", cpwd="0" WHERE ID="'.$_POST['id'].'"';
        $successmessage = "A felhasználó módosítva. Adminisztrátor jogot kapott.";
    }
    elseif(isset($_POST['admin']) && isset($_POST['resetpw'])){
        echo "Both";
        $updaterow = 'UPDATE gym_users SET login_name="'.$_POST['loginname'].'", IC_name="'.$_POST['icname'].'", login_password="'.hash("sha512", "NFGym").'", cpwd="1", admin="1" WHERE ID="'.$_POST['id'].'"';
        $successmessage = "A felhasználó módosítva.<br>A felhasználó adminisztrátor jogot kapott.<br>Jelszó visszaállítva erre: <b>NFGym</b><br>A változtatáshoz szükséges token: <b>".md5($_POST['loginname']).'</b>';
    }elseif(!isset($_POST['resetpw']) && !isset($_POST['admin'])){
        echo "Nothing";
        $updaterow = 'UPDATE gym_users SET login_name="'.$_POST['loginname'].'", IC_name="'.$_POST['icname'].'", cpwd="0", admin="0" WHERE ID="'.$_POST['id'].'"';
        $successmessage = "A felhasználó adatok módosítva.";
    }

    require 'sqlconn.php';
    
    if ($conn->query($updaterow) === TRUE) {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Alkalmazott módosítás", "'.$icandloginname.'", "Az alábbi alkalmazott módosítva lett: '.$_POST['icname'].'", "'.date("Y-m-d H:i:s").'")';
        $conn->query($sqllog);
        echo "Record updated successfully";
        $conn->close();
        header("Location: ../admin/workers.php?success=".$successmessage);
    } else {
        echo "Error updating record: " . $conn->error;
        $conn->close();
        header("Location: ../admin/workers.php?err=Adatbázis hiba.");
    }
}

$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>