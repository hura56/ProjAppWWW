<?php
// Jesli sesja nie jest jeszcze uruchomiona, rozpoczyna sesje
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_page'])) {
        // Obsługa formularza edycji
        $podstronaId = $_POST['podstrona_id'];
        if (!empty($podstronaId)) {
            echo edytujPodstrone($podstronaId);
        } else {
            echo "Błąd: Brak ID podstrony.";
        }
    } elseif (isset($_POST['delete_page'])) {
        // Obsługa formularza usuwania
        $podstronaId = $_POST['podstrona_id'];
        if (!empty($podstronaId)) {
            usunPodstrone($podstronaId);
        } else {
            echo "Błąd: Brak ID podstrony.";
        }
    }
}

require_once('cfg.php');
//----------------------------------------------//
//          Metoda FormularzLogowania()         //
//----------------------------------------------//
// Ta metoda wyświetla formularz logowania kiedy
// zostanie wywołana po zalogowaniu uzytkownik
// ma dostep do panela administracyjnego (CMS)

function FormularzLogowania()
{
    $result = '
    <div class="logowanie">
    <h1 class="heading">Logowanie:</h1>
    <div class="logowanie">
    <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
    <table class="logowanie">
    <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class="logowanie" placeholder="email"/></td></tr>
    <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" placeholder="password"/></td></tr>
    <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="zaloguj" /></td></tr>
    </table>
    </form>
    </div>
    </div>
    ';

    return $result;
}
//----------------------------------------------//
//          Metoda ListaPodstron()              //
//----------------------------------------------//
// Ta metoda wyświetla liste podstron znajdujazych
// sie w bazie danych a obok informacji o id 
// podstrony i tytule wyswietla przyciski edytuj 
// i usun ktore wywoluja metody odpowiadajace za
// edytowanie i usuwanie podstron

function ListaPodstron()
{

    global $conn;


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Zapytanie SQL do pobrania danych
    $query = "SELECT * FROM page_list LIMIT 100";
    $result = $conn->query($query);

    echo '<h2>Lista Podstron</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['page_title'] . '</td>';
        echo '<td>';
        echo '<form method="POST" action="' . $_SERVER['REQUEST_URI'] . '">';
        echo '<input type="hidden" name="podstrona_id" value="' . $row['id'] . '">';
        echo '<input type="submit" name="edit_page" value="Edytuj">';
        echo '<input type="submit" name="delete_page" value="Usuń">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
//----------------------------------------------//
//          Metoda edytujPodstrone()            //
//----------------------------------------------//
// Ta metoda edytuje podstrony. Pobiera id podstrony
// po wcisnieciu przyciskiu edytuj na liscie podstron
// i zezwala na zmiane tresci podstrony, tytulu oraz
// czy strona jest aktywna czy nieaktywna (1, 0)
// po wywolaniu np. edytujPodstrone(5) wyswietli sie
// formularz z trescia i tytulem podstrony 5 i bedzie
// mozliwosc edytowania go

// Edycja podstrony nie działa, potem poprawić
function edytujPodstrone($id)
{
    $result = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-edit'])) {
        if (isset($_POST['page_title'], $_POST['page_content'], $_POST['status'], $_POST['id'])) {
            global $conn;

            $page_title = $_POST['page_title'];
            $page_content = $_POST['page_content'];
            $status = isset($_POST['status']) ? 1 : 0;

            $query = "UPDATE page_list SET page_title='$page_title', page_content='$page_content', status='$status' WHERE id = '$id' LIMIT 1";

            if ($conn->query($query) === TRUE) {
                echo "Strona zaktualizowana pomyślnie!";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Błąd podczas aktualizacji strony: " . $conn->error;
            }
        } else {
            echo "Błąd: brak wymaganych danych w formularzu.";
        }
    } else {


        $result .= '
        <div class="editForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Edytuj stronę: </h1>
                <input type="hidden" name="id" value="' . $id . '">
                <span>ID: ' . $id . '</span>
                <input type="text" name="page_title" placeholder="Tytuł strony">
                <textarea name="page_content" rows="20" cols="70" placeholder="Treść strony"></textarea>
                <label><input type="checkbox" name="status" class="checkbox">Aktywna?</label>
                <div>
                    <div><input type="submit" value="zatwierdź" class="edit" name="btn-edit"></div>
                </div>
            </form>
        </div>
        ';
    }
    return $result;
}

//----------------------------------------------//
//          Metoda stworzPodstrone()            //
//----------------------------------------------//
// Ta metoda wyświetla formularz tworzenia nowej
// podstrony po wywolaniu id jest automatycznie ustalane
// dla nowych podstron. Metoda daje mozliwosc ustawienia
// tytulu nowej podstrony oraz wpisania zawartości

function stworzPodstrone()
{
    $result = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-create'])) {

        global $conn;


        $page_title = $_POST['page_title'];
        $page_content = $_POST['page_content'];
        $status = isset($_POST['status']) ? 1 : 0;

        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$page_title', '$page_content', '$status')";
        if ($conn->query($query) === TRUE) {
            echo "Strona dodana pomyślnie!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Błąd podczas dodawania strony: " . $conn->error;
        }
    }

    $result .= '
        <div class="createForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Dodaj stronę: </h1>
                <input type="text" name="page_title" placeholder="Tytuł strony" required>
                <textarea name="page_content" rows="20" cols="70" placeholder="Treść strony" required></textarea>
                <label><input type="checkbox" name="status" class="checkbox">Aktywna?</label>
                <div>
                    <div><input type="submit" value="stworz" class="create" name="btn-create"></div>
                </div>
            </form>
        </div>
        ';

    return $result;
}
//----------------------------------------------//
//          Metoda usunPodstrone()              //
//----------------------------------------------//
// Ta metoda kiedy wywolana pobiera id podstrony
// obok ktorej byl wcisniety przycisk na liscie podstron
// i usuwa podstrone z bazy danych. Nalozony LIMIT 1
// zeby nie usunac przypadkowo calej bazy danych

function usunPodstrone($id)
{
    global $conn;

    $query = "DELETE FROM page_list WHERE id = '$id' LIMIT 1";

    if ($conn->query($query) === TRUE) {
        echo "Strona usunięta pomyślnie!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Błąd podczas usuwania strony: " . $conn->error;
    }
}
//----------------------------------------------//
//          Metoda wyloguj()                    //
//----------------------------------------------//
// Metoda która wywołana zmienia status zmiennej
// 'logged_in' i wylogowuje uzytkownika

function wyloguj()
{
    $_SESSION['logged_in'] = false;
}

function PokazKategorie() {
        global $conn;
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Zapytanie SQL do pobrania danych
        $query = "SELECT * FROM categories LIMIT 100";
        $result = $conn->query($query);
    
        echo '<h2>Lista Kategorii</h2>';
        echo '<table border="1">';
        echo '<tr><th>ID</th><th>Nazwa Kategorii</th><th>Rodzic</th></tr>';
    
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['nazwa'] . '</td>';
            echo '<td>' . $row['matka'] . '</td>';
            echo '</tr>';
        }
    
        echo '</table>';
    }

function StworzKategorie(){
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-create-k'])) {

        $nazwa_kategorii = $_POST['category_name'];
        $rodzic = isset($_POST['parent']) ? $_POST['parent'] : 0;

        if (!empty($nazwa_kategorii)) {

            $query = "INSERT INTO categories (id, matka, nazwa) VALUES (NULL, '$rodzic', '$nazwa_kategorii')";

            if ($conn->query($query) === TRUE) {
                echo "Kategoria dodana pomyślnie!";
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();

            } else {
                echo "Błąd podczas dodawania kategorii: " . $conn->error;
            }
        } else {
            echo "Błąd: Brak wymaganych danych w formularzu dodawania kategorii.";
        }
    }

    $result = '
        <div class="createForm">
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            <h1>Dodaj kategorię: </h1>
                <input type="text" name="category_name" placeholder="Nazwa kategorii">
                <input type="number" name="parent" placeholder="Rodzic">
                <div>
                    <div><input type="submit" value="Stwórz" class="create" name="btn-create-k"></div>
                </div>
            </form>
        </div>
    ';

    return $result;
}


function UsunKategorie(){
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-delete-k'])) {

        $id_kategorii_do_usuniecia = $_POST['k_id'];

        if (!empty($id_kategorii_do_usuniecia)) {
            $query = "DELETE FROM categories WHERE id='$id_kategorii_do_usuniecia' LIMIT 1";

            if ($conn->query($query) === TRUE) {
                echo "Kategoria usunięta pomyślnie!";
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();

            } else {
                echo "Błąd podczas usuwania kategorii: " . $conn->error;
            }
        } else {
            echo "Błąd: Brak ID kategorii do usunięcia.";
        }
    }

    $result = '
        <div class="deleteForm">
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            <h1>Usuń kategorie: </h1>
                <input type="number" name="k_id" placeholder="ID kategorii">
                <div>
                    <div><input type="submit" value="Usuń" class="delete" name="btn-delete-k"></div>
                </div>
            </form>
        </div>
    ';

    return $result;
}

function EdytujKategorie(){
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-edit-k'])) {

        $id_kategorii_do_edytowania = $_POST['k_id'];
        $nowa_nazwa_kategorii = $_POST['category_name'];
        $nowa_matka = $_POST['parent'];

        if (!empty($id_kategorii_do_edytowania) && !empty($nowa_nazwa_kategorii) && isset($nowa_matka)) {

            $query = "UPDATE categories SET nazwa='$nowa_nazwa_kategorii', matka='$nowa_matka' WHERE id='$id_kategorii_do_edytowania' LIMIT 1";

            if ($conn->query($query) === TRUE) {
                echo "Kategoria zaktualizowana pomyślnie!";
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();

            } else {
                echo "Błąd podczas aktualizacji kategorii: " . $conn->error;
            }
        } else {
            echo "Błąd: Brak wymaganych danych w formularzu edycji kategorii.";
        }
    }

    $result = '
        <div class="editForm">
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            <h1>Edytuj kategorię: </h1>
                <input type="number" name="k_id" placeholder="ID kategorii">
                <input type="text" name="category_name" placeholder="Nowa nazwa kategorii">
                <input type="text" name="parent" placeholder="Nowa matka">
                <div>
                    <div><input type="submit" value="Edytuj" class="edit" name="btn-edit-k"></div>
                </div>
            </form>
        </div>
    ';

    return $result;
}

function GenerujDrzewoKategorii()
{
    global $conn;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Pobierz kategorie główne (matki)
    $queryGlowne = "SELECT * FROM categories WHERE matka = 0";
    $resultGlowne = $conn->query($queryGlowne);

    echo '<h2>Drzewo Kategorii</h2>';

    while ($rowGlowne = $resultGlowne->fetch_assoc()) {
        echo '<ul>';
        echo '<li>' . $rowGlowne['nazwa'] . '</li>';

        // Pobierz podkategorie (dzieci) dla danej kategorii głównej
        $idMatki = $rowGlowne['id'];
        $queryPodkategorie = "SELECT * FROM categories WHERE matka = '$idMatki'";
        $resultPodkategorie = $conn->query($queryPodkategorie);

        while ($rowPodkategorie = $resultPodkategorie->fetch_assoc()) {
            echo '<ul>';
            echo '<li>' . $rowPodkategorie['nazwa'] . '</li>';
            echo '</ul>';
        }

        echo '</ul>';
    }
}