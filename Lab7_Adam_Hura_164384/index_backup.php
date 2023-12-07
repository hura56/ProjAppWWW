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
                    $strona_content = PokazPodstrone($idp);
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
    <?php
include('admin/admin.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-logout'])) {
    wyloguj();
}
if ($_SESSION['logged_in'] == true){
    echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            <input type="submit" value="Wyloguj" name="btn-logout">
          </form>';
    ListaPodstron();
        echo edytujPodstrone();
        echo stworzPodstrone();
        echo usunPodstrone();
        if (isset($_POST['btn-logout'])) {
            wyloguj();
        }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['x1_submit'])) {
    $userLogin = $_POST['login_email'];
    $userPass = $_POST['login_pass'];

    if ($userLogin == $login && $userPass == $pass) {
        $_SESSION['logged_in'] = true;
        echo 'Zalogowano pomyślnie.';
        echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            <input type="submit" value="Wyloguj" name="btn-logout">
          </form>';
        ListaPodstron();
        echo edytujPodstrone();
        echo stworzPodstrone();
        echo usunPodstrone();
        if (isset($_POST['btn-logout'])) {
            wyloguj();
        }
    } else {
        echo 'Błąd logowania. Spróbuj ponownie.';
        echo FormularzLogowania();
    }
} else{
    if($_SESSION['logged_in'] == false){
    echo FormularzLogowania();
    }
}
?>
</body>

</html>
