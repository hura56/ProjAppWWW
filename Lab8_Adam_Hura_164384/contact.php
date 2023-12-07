<?php
include('cfg.php');
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

if (!empty($_GET['idp'])) {
    $idp = htmlspecialchars($_GET['idp']);
    if ($idp == 4) {
        header("Location: contact.php", true, 303);
        exit();
    } else {
        header("Location: index.php");
    }
}

function PokazKontakt()
{
    $formularz = '
        <form action="?action=WyslijMailKontakt" method="POST">
            <label>Temat:</label>
            <input type="text" name="temat">
            
            <label>Email:</label>
            <input type="email" name="email">
            
            <label> Tresc wiadomosci:</label>
            <textarea name="tresc"></textarea>
            
            <input type="submit" value="Wyslij">
            </form>
        ';
    return $formularz;
}

function WyslijMailKontakt($odbiorca)
{
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]';
        echo PokazKontakt(); // Ponowne wywolanie formularza
    } else {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['recipient'] = $odbiorca; // odbiorca jest tworzacy formularz kontaktowy

        $header = "From: Formularz kontaktowy<" . $mail['sender'] . ">\n";
        $header .= "MIME-Version: 1.0\n Content-Type: text/plain; charset=utf-8\n Content-Transfer-Encoding: base64\n";
        $header .= "X-Sender: <" . $mail['sender'] . ">\n";
        $header .= "X-Mailer: PRapWWW mail 1.2\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: <" . $mail['sender'] . ">\n";

        mail($mail['recipient'], $mail['subject'], $mail['body'], $header);

        echo '[wiadomosc_wyslana]';
    }
}

function PrzypomnijHaslo($odbiorca)
{
    // bardzo uproszczona wersja
    WyslijMailKontakt($odbiorca);
    echo 'Przypomnienie hasla wyslane';
}
?>

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
                <h1><b>Formularz Kontaktowy</b></h1>
                <?php
                echo PokazKontakt();
                ?>
                <br></br>
                <h3><b>Przypomnij Hasło</b></h3>
                <input type=text name = email>
                <button onclick="PrzypomnijHaslo(email)">Przypomnij</button>
            </td>
        </tr>
        <td></td>
    </table>