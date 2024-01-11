<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Adam Hura" />
    <title>MMA moją pasją</title>
    <link rel="stylesheet" href="css/styles.css" />
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="js/kontrast.js" type="text/javascript"></script>
</head>

<body onload="startclock()">
    <h1>MMA</h1>
    <div class="container">
        <button onclick="kontrast()">Kontrast</button>
    </div>
    <div id="zegarek"></div>
    <div id="data"></div>
    <table>
        <tr>
            <td></td>
            <td class="ref">
                <a href="?idp=1"><b>Strona Główna</b></a>
                <a href="?idp=5"><b>Największe organizacje|</b></a>
                <a href="?idp=6"><b>Polacy w Swiatowym MMA|</b></a>
                <a href="?idp=3"><b>Historia|</b></a>
                <a href="?idp=2"><b>Ciekawostki|</b></a>
                <a href="?idp=4"><b>Kontakt|</b></a>
                <a href="?idp=7"><b>test_lab3|</b></a>
                <a href="?idp=8"><b>Filmy</b></a>
                <a href="./php/admin_page.php"><b>Logowanie</b></a>
                <a href="./php/shop.php"><b>Sklep</b></a>

            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="main">
                <?php
                include('cfg.php');
                include('showpage.php');
                error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

                // Pobierz zawartość strony z bazy danych na podstawie parametru idp
                if (!empty($_GET['idp'])) {
                    $idp = htmlspecialchars($_GET['idp']);
                    $strona_content = PokazPodstrone($idp, $conn);
                    echo $strona_content;
                } else {
                    // Jeśli brak parametru idp, załaduj domyślną stronę
                    if (file_exists('html/strona.html')) {
                        $strona_content = file_get_contents('html/strona.html');
                        echo $strona_content;
                    } else {
                        echo 'Nie znaleziono domyślnej strony.';
                    }
                }
                ?>
            </td>
        </tr>
        <td></td>
    </table>

    <?php
    $nr_indeksu = '164384';
    $nrGrupy = '2';
    echo '<b><span style="color: rgb(184, 18, 18);">Autor: Adam Hura ' . $nr_indeksu . ' grupa ' . $nrGrupy . ' <br /><br /></b>';
    ?>

</body>

</html>