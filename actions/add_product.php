<?php
//?productname=Teszt+Termék&productprice=100&productphotourl=https%3A%2F%2Fi.ibb.co%2FLJ3vMVC%2Fimage-missing.png&activediscount=on
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['productname']) && isset($_POST['productprice']) && isset($_POST['productphotourl']) ){
    $discount=1;
    if(isset($_POST['activediscount']) && $_POST['activediscount']=="on"){
        $discount=0;
    }
    require 'sqlconn.php';

    $checkusersql = 'SELECT * FROM gym_arlista WHERE itemname="'.$_POST["productname"].'"';
    $result = $conn->query($checkusersql);
    if ($result->num_rows > 0) {
        echo "Már van ilyen néven termék a kínálatban."; 
        header("Location: ../admin/products.php?err=Már létezik ilyen néven termék!");   
    } else {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Új termék", "'.$icandloginname.'", "Új termék lett létrehozva: '.$_POST['productname'].'", "'.date("Y-m-d H:i:s").'")';
        $addusersql = 'INSERT INTO gym_arlista (itemname, itemprice, itemimage, nodiscount) VALUES ("'.$_POST['productname'].'", "'.$_POST['productprice'].'", "'.$_POST['productphotourl'].'", "'.$discount.'")';
        if ($conn->query($addusersql) === TRUE) {
            echo "Új termék sikeresen létrehozva.";
            $conn->query($sqllog);
            $conn->close();
            header("Location: ../admin/products.php?success=Új termék sikeresen létrehozva.");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
            header("Location: ../admin/products.php?err=Adatbátis hiba.");
        }
    }    
}
$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>