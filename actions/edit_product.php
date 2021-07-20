<?php
//edit_product.php?productname=Update+FánkK&productprice=90&productphotourl=https%3A%2F%2Fi.ibb.co%2F2SsHNf5%2Fakt-fank.png&active=on
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['productname']) && isset($_POST['productprice']) && isset($_POST['productphotourl']) && isset($_POST['id']) ){
    $nodiscont="1";
    if(isset($_POST['active']) && $_POST['active']=="on"){
        $nodiscont="0";
    }
    $updaterow = 'UPDATE gym_arlista SET itemname="'.$_POST['productname'].'", itemprice="'.$_POST['productprice'].'", itemimage="'.$_POST['productphotourl'].'", nodiscount="'.$nodiscont.'" WHERE ID="'.$_POST['id'].'"';
    $successmessage = "A termék sikeresen módosítva lett!";
    

    require 'sqlconn.php';
    
    if ($conn->query($updaterow) === TRUE) {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Termék módisítás", "'.$icandloginname.'", "Az alábbi termék módosítva lett: '.$_POST['productname'].'", "'.date("Y-m-d H:i:s").'")';
        $conn->query($sqllog);
        echo "Record updated successfully";
        $conn->close();
        header("Location: ../admin/products.php?success=".$successmessage);
    } else {
        echo "Error updating record: " . $conn->error;
        $conn->close();
        header("Location: ../admin/products.php?err=Adatbázis hiba.");
    }
}

$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>