<?php
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
function FormularzLogowania()
{
    $wynik = '
    <div class="logowanie">
    <h1 class="heading">Panel CMS:</h1>
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

    return $wynik;
}

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

// Edycja podstrony nie działa, potem poprawić
function edytujPodstrone($id)
{
    $wynik = '';

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


        $wynik .= '
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
    return $wynik;
}


function stworzPodstrone()
{
    $wynik = '';

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

    $wynik .= '
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

    return $wynik;
}

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

function wyloguj()
{
    $_SESSION['logged_in'] = false;
}
