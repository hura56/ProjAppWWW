<link rel="stylesheet" href="../css/cart.css">

<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="css/StylesCart.css">
    <h2>KOSZYK</h2>
</head>
<body>
    <?php
    session_start(); 

    if (isset($_POST["emptyCart"])) { 
        unset($_SESSION['cart']);
        exit();
    }

    function pokazKoszyk() 
    {
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { # Sprawdzenie czy istnieje sesja koszyka i czy jest ona pusta
            require('../cfg.php'); 
            $products = []; # pusta tablica products
            $ids = implode(',', array_keys($_SESSION['cart']));  # pobieranie danych produktów z tabeli "products" (produkty) na podstawie identyfikatorów produktów znajdujących się w koszyku
            $query = "SELECT * FROM products WHERE id IN ($ids)"; 
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) { # utworzenie tablicy produktów, i dodawanie do niej produktów przez iterację
                $products[] = $row;
            }

            echo "<ul>";
            $totalBrutto = 0; 
            $totalNetto = 0;	
            foreach ($products as $product) { 
                echo "<li>";
                echo '<img class="image" src="../zdj/' . $product['image'] . '" width="100" height="100"/>';
                echo "<p>Tytuł: " . $product["title"] . "</p>";
                echo "<p>Cena netto: " . $product["netto_value"] . "zł</p>";
                echo "<p>Ilość: " . $_SESSION['cart'][$product['id']]['value'] . "</p>";
                echo "<form action='cart.php' method='post'>
                    <input type='hidden' name='id' value='" . $product['id'] . "'>
                    <input type='submit' value='Usuń' name='usunProdukt'>
                </form>";
                echo "</li>";

                $nettoProductVal = $product['netto_value']; 
                $vat = $product['vat']; 
                $totalValue = $nettoProductVal * (1 + $vat / 100); 
                $value = $_SESSION['cart'][$product['id']]['value'];
                $totalBrutto += ($totalValue * $value); 
                $totalNetto += ($nettoProductVal * $value); 
            }

            echo "<b>Łączna kwota Netto:</b> $totalNetto zł";
            echo "<br/>";
            echo "<b>Łączna kwota Brutto:</b> $totalBrutto zł";
            echo "</ul>";
        } else {
            echo "W koszyku nie ma zawartości";
        }
    }

    function usunProdukt() 
    {
        $id = $_POST['id']; # pobranie identyfikatora produktu z tablicy $_POST
        if (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id]['value'] - 1 > 0) { # sprawdzene czy istnieje produkt o danym identyfikatorze w koszyku i czy ilość jest większa niż 1. Jeśli tak, to funkcja zmniejsza ilość produktu o 1, a jeśli nie, to usuwa produkt z koszyka.
            $_SESSION['cart'][$id]['value']--;
        } else {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: cart.php');
    }
    
    if (isset($_POST['usunProdukt'])) {
        usunProdukt();
    }
    ?>
    
    <div id="cart">
        <?php
        pokazKoszyk();
        ?>
    </div>
</body>
</html> 