<?php
include('../cfg.php');
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


//----------------------------------------------//
//          Metoda PokazKontakt()               //
//----------------------------------------------//
// Metoda wyświetla formularz kontaktowy 
// w miejscu w którym zostaje wywołana

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

//----------------------------------------------//
//          Metoda WyslijMailKontakt()          //
//----------------------------------------------//
// Metoda obsługuje wysyłanie wiadomości e-mail
// za pomocą formularza kontaktowego

function WyslijMailKontakt($odbiorca)
{
    // sprawdza czy pola formularza nie są puste
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]';
        echo PokazKontakt();
    } else {
        // zbieranie danych z formularza
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['recipient'] = $odbiorca;

        // tworzenie nagłówka maila
        $header = "From: Formularz kontaktowy<" . $mail['sender'] . ">\n";
        $header .= "MIME-Version: 1.0\n Content-Type: text/plain; charset=utf-8\n Content-Transfer-Encoding: base64\n";
        $header .= "X-Sender: <" . $mail['sender'] . ">\n";
        $header .= "X-Mailer: PRapWWW mail 1.2\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: <" . $mail['sender'] . ">\n";

        // symulacja próby wysłania maila (nie będzie działać lokalnie bez prawidłowego serwera pocztowego)
        try {
            $result = mail($mail['recipient'], $mail['subject'], $mail['body'], $header);

            if ($result) {
                echo '[wiadomosc_wyslana]';
            } else {
                echo '[blad_wysylania]';
            }
        } catch (Exception $e) {
            echo '[blad_wysylania]: ' . $e->getMessage();
        }
    }
}

function PrzypomnijHaslo($pass){ # funkcja generuje formularz, który przesyła hasło do podanego adresu email
    echo'
        <form accept-charset="UTF-8" action="https://www.formbackend.com/f/6ba66b3cc9536956" method="POST">
            <input type="hidden" name="password" value="'.$pass.'"/>
            <input type="submit" name="x1_submit" value="Zapomniałeś hasła?" />
        </form>
    ';
}
?>
