<?php
if( isset($_POST['token']) && isset($_POST["pwd1"]) && isset($_POST["pwd2"]) ){
    if(hash("sha512", $_POST["pwd1"]) == hash("sha512", $_POST["pwd2"])){
        require 'sqlconn.php';

        $getuserdata = 'SELECT ID, MD5(login_name) AS "userhash", cpwd FROM gym_users WHERE  MD5(login_name)="'.$_POST['token'].'"';
        $user_result = $conn->query($getuserdata);
        if ($user_result->num_rows > 0) {
        while($row = $user_result->fetch_assoc()) {
            if($row['cpwd'] == 1){
                $sql = 'UPDATE gym_users SET login_password="'.hash("sha512", $_POST["pwd2"]).'", cpwd="0" WHERE id='.$row['ID'];

                if ($conn->query($sql) === TRUE) {
                    echo "Jelszó sikeresen megváltoztatva!";
                    header("Location: /index.php?success=A jelszavad sikeresen megváltozott.");
                } else {
                    echo "Adatbázis hiba: " . $conn->error;
                    header("Location: /cpwd.php?err=Adatbázis hiba.");
                }
                $conn->close();
            }else{
                header("Location: /index.php?err=Nincs engedélyezve a jelszavad megváltoztatása.");
            }
        }
        } else {
        echo "Nincs user";
        header("Location: /cpwd.php?err=Érvénytelen token.");
        }
    }else{
        header("Location: /cpwd.php?err=A két jelszó nem egyezik meg.&token=".$_POST['token']);
    }
}else{
    echo "Hiányos adatok";
    header("Location: /cpwd.php?err=Hiányos vagy hibás információk.");
}
$conn->close();



?>