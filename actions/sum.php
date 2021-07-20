<?php
session_start();
if(isset($_SESSION['sess_IC_name']) && isset($_SESSION['sess_login_name'])){

    require '../actions/sqlconn.php';

    $query = "SELECT * FROM gym_arlista WHERE 1";

    $item_result = $conn->query($query);
    $rows = $item_result->num_rows;

    $sum = 0;
    $teljesaras = 0;
    $items = "";

    $discount = (float)$_POST['discount']/100;
    echo "Tételek:<br>";
    if ($item_result->num_rows > 0) {
        // output data of each row
        while($row = $item_result->fetch_assoc()) {
            if($_POST['item-'.$row['ID']] == null || $_POST['item-'.$row['ID']] == ""){
                $_POST['item-'.$row['ID']]=0;
            }else{
                if($_POST['item-'.$row['ID']] != 0){
                    if($row['nodiscount']=="1"){
                        $teljesaras+=$row['itemprice']*$_POST['item-'.$row['ID']];
                    }else{
                        $sum+=$row['itemprice']*$_POST['item-'.$row['ID']];
                    }
                    $items=$items.$_POST['item-'.$row['ID']]."x ".$row['itemname']." - $".$row['itemprice'].";";
                    echo $_POST['item-'.$row['ID']]."x ".$row['itemname']." - ".$row['itemprice']."<br>";
                }
            }
        }
    }
    //echo $items;
    echo "<br><br><br>";
    echo $teljesaras;
    echo "<br><br><br>";
    $timenow = date("Y-m-d H:i:s");
    $icandloginname = $_SESSION["sess_IC_name"]."(".$_SESSION["sess_login_name"].")";

    if($discount != 0){
        $sum=$sum-($sum*$discount)+$teljesaras;
        echo "Kedvezményes ár: ".$sum;
        $userstat = 'UPDATE gym_users SET sells=sells+1, sellinusd=sellinusd+'.$sum.' WHERE IC_name="'.$_SESSION['sess_IC_name'].'"';
        if ($conn->query($userstat) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $addlog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Eladás", "'.(String)$icandloginname.'", "Új eladás '.$sum.'$ értékben.", "'.date("Y-m-d H:i:s").'")';
        if ($conn->query($addlog) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $addlog . "<br>" . $conn->error;
        }
        echo '<br>'.(String)$sum.' - '.(String)$items;
        header("Location: /user/index.php?items=".$items."&sum=".$sum);
    }else{
        $sum=$sum+$teljesaras;
        echo "Kedvezmény nélküli ár: ".$sum;
        $userstat = 'UPDATE gym_users SET sells=sells+1, sellinusd=sellinusd+'.$sum.' WHERE IC_name="'.$_SESSION['sess_IC_name'].'"';
        if ($conn->query($userstat) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        $addlog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Eladás", "'.(String)$icandloginname.'", "Új eladás '.$sum.'$ értékben.", "'.date("Y-m-d H:i:s").'")';
        if ($conn->query($addlog) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $addlog . "<br>" . $conn->error;
        }

        echo '<br>'.(String)$sum.' - '.(String)$items;
        header("Location: /user/index.php?items=".$items."&sum=".$sum);
    }
    $conn->close();
}else{
    header("Location: /index.php?err=Jelentkezz be, hogy használhasd a számlázást.");
}
?>