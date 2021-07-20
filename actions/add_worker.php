<?php
//add_worker.php?loginname=John.Doe&icname=John+Doe&pwd=NFGym&admin=on
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['loginname']) && isset($_POST['icname']) && isset($_POST['pwd']) ){
    $admin=0;
    if(isset($_POST['admin']) && $_POST['admin']=="on"){
        $admin=1;
    }
    require 'sqlconn.php';

    $checkusersql = 'SELECT * FROM gym_users WHERE login_name="'.$_POST["loginname"].'"';
    $result = $conn->query($checkusersql);
    if ($result->num_rows > 0) {
        echo "Már van felhasználó ezzel a névvel."; 
        header("Location: ../admin/workers.php?err=Már létezik ilyen felhasználó!");   
    } else {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Új alkalmazott", "'.$icandloginname.'", "Új alkalmazott lett felvéve: '.$_POST['icname'].'", "'.date("Y-m-d H:i:s").'")';
        $addusersql = 'INSERT INTO gym_users (IC_name, login_name, login_password, sells, sellinusd, cpwd, `admin`) VALUES ("'.$_POST["icname"].'", "'.$_POST["loginname"].'", "'.hash("sha512", $_POST["pwd"]).'", "0", "0", "1", "'.$admin.'")';
        if ($conn->query($addusersql) === TRUE) {
            echo "New record created successfully";
            $conn->query($sqllog);
            $conn->close();
            header("Location: ../admin/workers.php?success=Felhasználó sikeresen létrehozva. Jelszó változtatásához szükséges token: <b>".md5($_POST['loginname'])."</b>");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
            header("Location: ../admin/workers.php?err=Adatbátis hiba.");
        }
    }    
}
$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>