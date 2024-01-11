<?php
//----------------------------------------------//
//          Metoda PokazPodstrone()             //
//----------------------------------------------//
// Metoda pobiera podstrone z bazy danych poprzez 
// SELECT. argumentem jest id podstrony 
// (np. PokazPodstrone(3) wyswietla zawartosc
// podstrony historia) 

function PokazPodstrone($id, $conn)
{
    //czyszczenie $id, aby przez GET nikt nie próbował ataku SQL INJECTION
    $id_clear = htmlspecialchars($id);


    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    $row = mysqli_fetch_array($result);

    if(empty($row['id'])) 
    {
        $web = '[nie znaleziono strony]';
    }
    else 
    {
        $web = $row['page_content'];
    }
    return $web;
}