<?php
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if(isset($_POST["username"]) && isset($_POST["icname"]) && isset($_POST["oldpw"]) && isset($_POST["newpw"])){
    require 'sqlconn.php';

    $currentpwhashsql = 'SELECT login_password FROM gym_users WHERE IC_name ="'.$_POST["icname"].'"';
    $pw_result = $conn->query($currentpwhashsql);
    $currentpwhash="";
    if ($pw_result->num_rows > 0) {
        // output data of each row
        while($row = $pw_result->fetch_assoc()) {
            //$row["id"]
            $currentpwhash=$row['login_password'];
        }
    }

    if(hash("sha512", $_POST["oldpw"]) == $currentpwhash){
        if($_POST["oldpw"] != $_POST["newpw"]){
            $editprofilesql = 'UPDATE gym_users SET login_password = "'.hash("sha512", $_POST["newpw"]).'" WHERE IC_name ="'.$_POST["icname"].'"';
            if ($conn->query($editprofilesql) === TRUE) {
                echo "Record updated successfully";
                header("Location: ../admin/profile.php?success=");
            } else {
                echo "Error updating record: " . $conn->error;
                header("Location: ../admin/profile.php?err=Adatbázis hiba.");
            }
        }else{
            //Azonos régi és új PW
            header("Location: ../admin/profile.php?err=A régi és új jelszó nem lehet azonos.");
        }
    }else{
        //A beírt régi jelszó nem azonos a tárolt jelszóval.
        header("Location: ../admin/profile.php?err=Hibás régi jelszó!");
    }
    
}else{
    //Hiányzó adatok az átadásnál
    header("Location: ../admin/profile.php?err=Hiányzó adatok az átadásnál.");
}
$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>