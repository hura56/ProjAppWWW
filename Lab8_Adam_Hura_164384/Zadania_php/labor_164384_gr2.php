<?php
    $nr_indeksu = '164384';
    $nr_grupy='2';

    echo 'Adam Hura '.$nr_indeksu.' grupa '.$nr_grupy.'<br><br>';

    echo 'Zastosowanie metody include() <br>';
    echo 'Funkcja include() służy do dołączania i wykonania zawartości innego pliku PHP w bieżącym skrypcie.<br>';
    include('include.php');
    echo 'przyklad: '.$plik_include.'<br><br>';

    echo 'Zastosowanie metody require_once() <br>';
    echo 'Funkcja require_once() działa podobnie do include(), ale jeśli plik został już dołączony wcześniej, nie zostanie dołączony ponownie.<br>';
    require_once('require_once.php');
    echo 'przyklad: '.$plik_require_once.'<br><br>';

echo 'Warunek if, else, elseif:<br>';
echo 'Warunek if służy do wykonania bloku kodu, jeśli określone wyrażenie jest prawdziwe. Jeśli nie jest, to wykonuje się blok kodu w sekcji else lub elseif (jeśli są obecne).<br>';

$ocena = 5;
    echo 'przyklad: ';
if ($ocena == 5) {
    echo 'Ocena Bardzo Dobra';
} elseif ($ocena == 4) {
    echo 'Ocena Dobra';
} else {
    echo 'Inna ocena.';
}

echo '<br><br>Warunek switch:<br>';
echo 'Switch służy do wyboru jednej z wielu możliwych ścieżek wykonania, w zależności od wartości wyrażenia.<br>';

$kolor = 'niebieski';
    echo 'przyklad: ';
switch ($kolor) {
    case 'czerwony':
        echo 'Twój ulubiony kolor to czerwony!';
        break;
    case 'zielony':
        echo 'Twój ulubiony kolor to zielony!';
        break;
    case 'niebieski':
        echo 'Twój ulubiony kolor to niebieski!';
        break;
    default:
        echo 'Twój ulubiony kolor to inny.';
}

echo '<br><br>Pętla while:<br>';
echo 'Pętla while wykonuje blok kodu tak długo, jak długo określone wyrażenie jest prawdziwe.<br>';

$i = 1;
while ($i <= 5) {
    echo "Iteracja $i<br>";
    $i++;
}

echo '<br>Pętla for:<br>';
echo 'Pętla for wykonuje blok kodu przez określoną liczbę iteracji.<br>';

for ($j = 1; $j <= 5; $j++) {
    echo "Iteracja $j<br>";
}

echo '<br><br>$_GET - Przykład:<br>';
echo 'Wartość parametru id z URL: ' . $_GET['id'] . '<br><br>';

$_POST['username'] = 'uzytkownik';
echo '$_POST - Przykład: ';
echo 'Wartość pola username z formularza: ' . $_POST['username'] . '<br>';


session_start();
$_SESSION['user_id'] = 123;
echo '<br>$_SESSION - Przykład:<br>';
echo 'ID użytkownika w sesji: ' . $_SESSION['user_id'] . '<br>';

?>