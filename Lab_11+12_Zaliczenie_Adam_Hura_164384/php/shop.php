<!DOCTYPE html>
<html lang="pl">
<html>
  <head>
    <link rel="stylesheet" href="../css/shop.css">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <title>MMA moją pasją</title>
    <meta name="Author" content="Adam Hura" />
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/kolorujtlo.js" type="text/javascipt"></script>
    <script src="../js/timedate.js" type="text/javascipt"></script>
    <link rel="shortcut icon" href="#">
  </head>
  <body onload="startclock()">
  <div id="zegarek"></div>
    <div id="data"></div>
    <header>
        <a class="logo" ><img src="../zdj/sklep.png" width="200" height="100" alt="logo"></a>
        <table>
        <tr>
            <td></td>
            <td class="ref">
                <a href="../index.php?idp=1"><b>Strona Główna</b></a>
                <a href="../index.php?idp=5"><b>Największe organizacje|</b></a>
                <a href="../index.php?idp=6"><b>Polacy w Swiatowym MMA|</b></a>
                <a href="../index.php?idp=3"><b>Historia|</b></a>
                <a href="../index.php?idp=2"><b>Ciekawostki|</b></a>
                <a href="../index.php?idp=4"><b>Kontakt|</b></a>
                <a href="../index.php?idp=7"><b>test_lab3|</b></a>
                <a href="../index.php?idp=8"><b>Filmy</b></a>
                <a href="../php/admin_page.php"><b>Logowanie</b></a>
                

            </td>
            <td></td>
        </tr>
        </table>
    </header>
    <h1>SKLEP</h1>
</body>
</html>

<?php 
    require_once('../admin/admin.php'); 
?>

<?php
session_start(); 
function PokazProdukty(){
    require('../cfg.php');
    $query = "SELECT * from products"; # zapytanie SQL wybierające wszystkie dane z tabeli products
    $result = mysqli_query($conn, $query); 
    echo '<table>'; 
        echo '<tr>';
            echo "<th>Zdjęcie</th>";
            echo "<th>Nazwa</th>";
            echo "<th>Opis</th>";
            echo "<th>Rozmiar</th>";
            echo "<th>Cena</th>";
            echo "<th>Ilość</th>";
            echo "<th>Koszyk</th>";
        echo '</tr>'; 
        while($row = mysqli_fetch_array($result)){ 
            echo '<tr>';
            echo '<td><img class="image" src="../zdj/' . $row['image'] . '" width="100" height="100" /></td>';	
                #echo '<td><img class="image" src="data:image/jpeg;base64,'.base64_encode($row['image']).'"/></td>';
                echo "<td>" . $row["title"]. "</td>";
                echo "<td>" . $row["description"]. "</td>";
                echo "<td>" . $row["size"]. "</td>";
                echo "<td>" . $row["netto_value"]. "</td>";
                echo "<td>" . $row["amount"]. "</td>";
                echo "<td> <form action='shop.php' method='post'>
                <input type='hidden' name='id' value='".$row['id']."'>
                <input type='submit' class='button' id='button' value='Dodaj', name='addCart'>
                </form>
                </td>";
            echo '</tr>';
        }

        echo '</table>';
}
?>
            <button onclick="location.href='cart.php'">Koszyk</button> <!--Przycisk przekierowujący do koszyka -->

            <?php
            function DodajDoKoszyka(){
            require("../cfg.php"); 
            $product_id = $_POST['id'];
            $query = "SELECT amount FROM products WHERE id = $product_id"; # zapytanie pobierające ilość produktu z tabeli products gdzie id produktu jest równe temu pobranemu z tablicy wyżej
            $result = mysqli_query($conn, $query); 
            $product = mysqli_fetch_assoc($result);
            if($product['amount'] <= 0){ # sprawdzenie dostępności produktu
                echo "Brak produktu na stanie";
            }
            else # jeśli produkt jest na stanie zwiększa jego ilość w koszyku sesji
            {
                if(!isset($_SESSION['cart'][$product_id])){
                    $_SESSION['cart'][$product_id] = [
                        'id' => $product_id,
                        'value' => 1
                    ];
                }
                else
                {
                    $_SESSION['cart'][$product_id]['value']++;
                }
                header('Location: shop.php');
            }
        }
?>
<?php
  if(isset($_POST['addCart'])){ 
    DodajDoKoszyka(); 
}
?>


<?php
PokazProdukty(); 
?>
    </section>
    <footer class="main-footer">
		<div class="container main-footer-container">
			<h3 class="site-name">Sklep MMA</h3>
			<ul class="nav footer-nav">
				<li>
					<a href="https://facebook.com" target="_blank">
						<img src="../zdj/fb.png" width="50" height="50">
					</a>
				</li>
				<li>
					<a href="https://instagram.com" target="_blank">
						<img src="../zdj/insta.png" width="50" height="40">
					</a>
				</li>
			</ul>
		</div>
	</footer>
</body>
</html>

<?php
$nr_indeksu = '164384';
$nr_grupy = '2';

echo 'Autor: Adam Hura ' . $nr_indeksu . ' grupa: ' . $nr_grupy . '<br /><br />';
?>