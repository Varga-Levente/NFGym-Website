<?php
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
    require 'sqlconn.php';

    $sql = 'TRUNCATE TABLE gym_aktivitas;';
    $sql .= 'ALTER TABLE gym_aktivitas AUTO_INCREMENT = 1;';
    $sql .= 'UPDATE gym_users SET activity="0óra 0perc" WHERE 1';

    // Execute multi query
    if ($conn -> multi_query($sql)) {
        do {
            // Store first result set
        if ($result = $conn -> store_result()) {
            while ($row = $result -> fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result -> free_result();
        }
        // if there are more result-sets, the print a divider
        if ($conn -> more_results()) {
            printf("-------------\n");
        }
        //Prepare next result set
    } while ($conn -> next_result());
  }else{
    header("Location: ../admin/workers.php?err=Adatbázis hiba!");
  }
  
  $conn -> close();
  header("Location: ../admin/workers.php?success=Alkalmazottak aktivitása sikeresen nullázva!");
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>