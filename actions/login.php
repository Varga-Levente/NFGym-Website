<?php

date_default_timezone_set("Europe/Budapest");
if(isset($_POST["uname"]) && isset($_POST["pwd"]) && $_POST["uname"] != null && $_POST["pwd"] != null){

    $formusername = $_POST["uname"];
    $formpassword = hash("sha512", $_POST["pwd"]);

    //echo $formusername;
    //echo $formpassword;

    require 'sqlconn.php';

    $sql = 'SELECT IC_name, login_name, login_password, cpwd, admin FROM gym_users where login_name="'.$formusername.'"';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["login_name"] == $formusername && $row["login_password"] == $formpassword){
            if($row["cpwd"] == 1){
                //Átirányítás jelszó változtatásra
                header("Location: /cpwd.php");
            }else{
                //Nem kell jelszót változtatnia

                //Sessionok létrehozása
                session_start();
                $_SESSION["sess_IC_name"] = $row["IC_name"];
                $_SESSION["sess_login_name"] = $row["login_name"];
                $_SESSION["ADMIN"] = $row["admin"];

                //Aktualisido
                $timenow = date("Y-m-d H:i:s");
                $icandloginname = $row["IC_name"]."(".$row["login_name"].")";

                //Login idejének beírása
                $sqluser = 'UPDATE gym_users SET login_lastdate="'.$timenow.'" WHERE login_name="'.$row["login_name"].'"';
                $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Belépés", "'.$icandloginname.'", "Alkalmazott belépett a rendszerbe.", "'.date("Y-m-d H:i:s").'")';

                if ($conn->query($sqluser) === TRUE) {
                echo "Record updated successfully";
                } else {
                echo "Error updating record: " . $conn->error;
                }

                if ($conn->query($sqllog) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                //Átirányítás
                header("Location: /user/index.php");
            }
        }else{
            header("Location: /index.php?err=Felhasználónév+és+jelszó+páros+nem+található");
        }
    }
    } else {
        header("Location: /index.php?err=Ismeretlen+hiba");
    }
    $conn->close();
}else{
    header("Location: /index.php");
}

$conn->close();

?>