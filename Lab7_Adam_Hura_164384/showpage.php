<?php
function PokazPodstrone($id)
{
    //czyszczenie $id, aby przez GET nikt nie próbował ataku SQL INJECTION
    $id_clear = htmlspecialchars($id);
    
    global $conn;

    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Wywoływanie strony z bazy
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $web = $row['page_content'];
    } else {
        $web = '[nie_znaleziono_strony]';
    }

    return $web;
}
?>
