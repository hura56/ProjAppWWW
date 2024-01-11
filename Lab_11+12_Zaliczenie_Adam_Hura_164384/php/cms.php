<?php 
    session_start(); 
    if (!isset($_SESSION['admin_logged_in'])){   # jeśli sesja nie jest ustawiona na zalogowanego użytkownika, użytkownik jest przekierowywany na stronę logowania
        header('Location: admin_page.php'); 
        exit();
    }
    require_once('../admin/admin.php'); 
    require_once('../cfg.php'); 

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cms.css" />
    <title>CMS</title>
</head>
<body>
<table> <!-- tabela z przyciskami, które pozwalają na tworzenie, wyświetlanie, edycję i usuwanie podstron oraz wylogowanie się z panelu administracyjnego -->
        <tr>
            <td><button><a href="create_page.php">Dodaj Podstronę</a></button></td> 
            <td><button><a href="show_page.php">Pokaż Podstrony</a></button></td>
            <td><button><a href="edit_page.php">Edytuj Podstronę</a></button></td> 
            <td><button><a href="delete_page.php">Usuń Podstronę</a></button></td>
            <td><button><a href="logout.php"> Wyloguj się</a> 
        </tr>
        <tr class="osobna">
            <td><button><a href="categories.php">Zarządzaj Kategoriami</a></button></td> 
        </tr>
        <tr>
            <td><button><a href="create_product.php">Dodaj Produkt</button></td> 
            <td><button><a href="show_product.php">Pokaż Produkty</button></td> 
            <td><button><a href="edit_product.php">Edytuj Produkty</button></td> 
            <td><button><a href="delete_product.php">Usuń Produkt</button></td> 
        </tr>
</table>
</body>
</html>