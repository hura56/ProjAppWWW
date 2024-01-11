<?php

require_once('../cfg.php');
require_once('../class/category.php');

//----------------------------------------------//
//          Metoda FormularzLogowania()         //
//----------------------------------------------//
// Ta metoda wyświetla formularz logowania kiedy
// zostanie wywołana po zalogowaniu uzytkownik
// ma dostep do panela administracyjnego (CMS)

function FormularzLogowania()
{
	$result = '
	<div>
	<h1>Panel CMS:</h1>
	<div class="logowanie">
		<form method="POST" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
			<table>
				<tr><td class="log4_t"></td><td><input type="text" name="login_email" class="logowanie" placeholder="email"/></td></tr>
				<tr><td class="log4_t"></td><td><input type="password" name="login_pass" class="logowanie" placeholder="password"/></td></tr>
				<tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="button" value="Zaloguj" /></td></tr>
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

function ListaPodstron($conn)
{ # wyświetlanie listy wszystkich podstron z bazy danych (READ)
	$query = "SELECT * FROM page_list";
	$result = mysqli_query($conn, $query);

	echo '<table>';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Tytuł podstrony</th>';
	echo '<th>Opcje</th>';
	echo '</tr>';
	while ($row = mysqli_fetch_array($result)) {
		echo '<tr>';
		echo '<td>' . $row['id'] . '</td>';
		echo '<td>' . $row['page_title'] . '</td>';
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

function EdytujPodstrone()
{ 
	$result = '
        <div class="editForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Edytuj stronę: </h1>
                <input type="number" name="p_id" placeholder="ID strony">
                <input type="text" name="page_title" placeholder="Tytuł strony">
                <textarea name="page_content" rows="20" cols="70 "placeholder="Treść strony"></textarea>
                <label><input type="checkbox" name="p_status" class="checkbox">Aktywna?</label>
                <div>
                    <div><input type="submit" value="edytuj" class="edit" name="btn-edit"></div>
                </div>
            </form>
        </div>
        ';
	return $result;
}
//----------------------------------------------//
//          Metoda stworzPodstrone()            //
//----------------------------------------------//
// Ta metoda wyświetla formularz tworzenia nowej
// podstrony po wywolaniu id jest automatycznie ustalane
// dla nowych podstron. Metoda daje mozliwosc ustawienia
// tytulu nowej podstrony oraz wpisania zawartości

function StworzPodstrone()
{ 
	$result = '
        <div class="createForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Dodaj stronę: </h1>
                <input type="number" name="p_id" placeholder="ID strony">
                <input type="text" name="page_title" placeholder="Tytuł strony">
                <textarea name="page_content" rows="20" cols="70 "placeholder="Treść strony"></textarea>
                <label><input type="checkbox" name="p_status" class="checkbox">Aktywna?</label>
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

function UsunPodstrone()
{ 
	$result = '
        <div class="deleteForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Usuń stronę: </h1>
                <input type="number" name="p_id" placeholder="ID strony">
                <div>
                    <div><input type="submit" value="usun" class="delete" name="btn-delete"></div>
                </div>
            </form>
        </div>
        ';
	return $result;
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

function Kategorie($conn)
{ 
	if ($_SERVER['REQUEST_METHOD'] === 'POST') { # jeśli żądanie jest typu POST to funkcja sprawdza jaki przycisk został naciśnięty i wykonuje operację
		if (isset($_POST['btnAdd'])) # dodawania rekordu
		{
			$category = new Category();
			$category->setCategoryName($_POST['new_nazwa']);
			$category->setMatka((int)$_POST['new_matka']);
			mysqli_query($conn, $category->add());
		} elseif (isset($_POST['btnEdit'])) # edycji rekordu
		{
			$category = (getCategories($conn, $_POST['id']))[$_POST['id']]['main'];
			$category->setCategoryName($_POST['nazwa']);
			$category->setMatka($_POST['matka']);
			$category->setId($_POST['id']);
			if ($category->changed()) {
				echo 'Edytowano pomyślnie';
				mysqli_query($conn, $category->edit());
			} else {
				echo 'Nie edytowano';
			}
		} elseif (isset($_POST['btnDel'])) # usuwania rekordu
		{
			$category = (getCategories($conn, $_POST['id']))[$_POST['id']]['main'];
			mysqli_query($conn, $category->delete());
		}
	}
	$categories = getCategories($conn); # wyświetlenia rekordów w tabeli
	echo '<table >';
	echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>Nazwa kategorii</th>';
	echo '<th>Matka</th>';
	echo '</tr>';
	foreach ($categories as $id => $category) {
		if ($category['main']->getMatka() == 0)
			renderTree($categories, $id);
	}
	echo '</table>';
	echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="POST" id="new_category">'
		. '<br/><div class="nowy">Nowy rekord<br/>'
		. 'Nazwa Kategorii: <input type="text" name="new_nazwa"/>'
		. '&nbsp;Matka<input type="text" name="new_matka"/>'
		. '</div></form> <input type="submit" name="btnAdd" value="Nowy" form="new_category"/>';
}

function getCategories($conn, $id = null)
{ # pobiera wszystkie kategorie z bazy danych
	$categories = [];
	$query = 'SELECT c.* FROM categories AS c'; 
	if ($id) $query .= ' WHERE c.id = ' . $id; 
	$result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_object($result, "Category")) {
		if ($row->getMatka() != 0) {
			if (isset($categories[$row->getMatka()]))
				$categories[$row->getMatka()]["children"][] = $row->getId();
			else
				$categories[$row->getMatka()] = ["children" => [$row->getId()]];
		}
		$categories[$row->getId()]['main'] = $row;
	}
	return $categories; 
}

function renderTree($categories, $id)
{ # Ta funkcja jest używana przez funkcję Kategorie() do wyświetlania kategorii w formie drzewa
	$row = $categories[$id]['main']; # Funkcja przyjmuje tablicę z kategoriami oraz id kategorii, którą chcemy wyświetlić
	echo '<tr>';
	echo '<form action="' . $_SERVER['REQUEST_URI'] . '" id="category_' . $row->getId() . '" method="POST"></form>';
	echo '<td>' . $row->getId() . '</td>';
	echo '<td><input type="text" name="nazwa" value="' . $row->getCategoryName() . '" form="category_' . $row->getId() . '"/></td>';
	echo '<td><input type="text" name="matka" value="' . $row->getMatka() . '" form="category_' . $row->getId() . '"/></td>';
	echo '<td class="buttons">'                             
		. '<input type="hidden" name="id" value="' . $row->getId() . '" form="category_' . $row->getId() . '"/>'
		. '<input type="submit" name="btnEdit" value="Edytuj" form="category_' . $row->getId() . '"/>'
		. '<input type="submit" name="btnDel" value="Usuń" form="category_' . $row->getId() . '"/>'
		. '</td>';
	echo '</tr>';
	if (isset($categories[$id]['children'])) { # jeśli kategoria ma rodzica, funkcja rekurencyjnie wywołuje się dla rodzica, wyświetlając całe drzewo kategorii
		foreach ($categories[$id]['children'] as $matkaId) {
			renderTree($categories, $matkaId);
		}
	}
}

function ListaProdukt($conn){ 
    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    
    echo '<table>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nazwa</th>';
    echo '<th>Opis</th>';
	echo '<th>Data utworzenia</th>';
	echo '<th>Data modyfikacji</th>';
	echo '<th>Cena netto</th>';
	echo '<th>Vat</th>';
	echo '<th>Ilość</th>';
	echo '<th>Status dostępności</th>';
	echo '<th>Kategoria</th>';
	echo '<th>Rozmiar</th>';
	echo '<th>Zdjęcie</th>';	
    echo '</tr>';
    while($row = mysqli_fetch_array($result)){
        echo '<tr>';
        echo '<td>'.$row['id'].'</td>';
        echo '<td>'.$row['title'].'</td>';
		echo '<td>'.$row['description'].'</td>';
		echo '<td>'.$row['creation_date'].'</td>';
		echo '<td>'.$row['modify_date'].'</td>';
		echo '<td>'.$row['netto_value'].'</td>';
		echo '<td>'.$row['vat'].'</td>';
		echo '<td>'.$row['amount'].'</td>';
		echo '<td>'.$row['availability_status'].'</td>';
		echo '<td>'.$row['category'].'</td>';
		echo '<td>'.$row['size'].'</td>';
		echo '<td><img class="image" src="../zdj/' . $row['image'] . '" width="100" height="100" /></td>';	

        echo '</tr>';
    }
    echo '</table>';
}

function StworzProdukt(){ 
    $result = '
        <div class="createForm">
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            <h1>Dodaj Produkt: </h1>
                <input type="text" name="title" placeholder="Nazwa">
                <input type="textarea" name="description" placeholder="Opis">
				<input type="number" name="netto_value" placeholder="Cena netto">
				<input type="number" name="vat" placeholder="Vat">
				<input type="number" name="amount" placeholder="Ilość">
				<label for="totalAmt"><input type="checkbox" step=0.01 id="totalAmt" name="availability_status" class="checkbox">Dostępne?</label>
				<input type="text" name="category" placeholder="Kategoria">
				<input type="text" name="size" placeholder="Rozmiar">
				<input type="text" name="image" placeholder="Zdjęcie">
                <div>
                    <div><input type="submit" value="stworz" class="create" name="btn-create-p"></div>
                </div>
            </form>
        </div>
        ';
    return $result;
}

function UsunProdukt(){ 
    $result = '
        <div class="deleteForm">
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            <h1>Usuń produkt: </h1>
                <input type="number" name="id" placeholder="ID produktu">
                <div>
                    <div><input type="submit" value="usun" class="delete" name="btn-delete-p"></div>
                </div>
            </form>
        </div>
        ';
    return $result;
}

function EdytujProdukt(){ 
    $result = '
        <div class="editForm">
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            <h1>Edytuj produkt: </h1>
				<input type="number" name="id" placeholder="ID">
				<input type="text" name="title" placeholder="Nazwa">
				<input type="textarea" name="description" placeholder="Opis">
				<input type="number" step=0.01 id="totalAmt" name="netto_value" placeholder="Cena netto">
				<input type="number" name="vat" placeholder="Vat">
				<input type="number" name="amount" placeholder="Ilość">
				<label><input type="checkbox" name="availability_status" class="checkbox">Dostępne?</label>
				<input type="text" name="category" placeholder="Kategoria">
				<input type="text" name="size" placeholder="Rozmiar">
				<input type="text" name="image" placeholder="Zdjęcie">
                <div>
                    <div><input type="submit" value="edytuj" class="edit" name="btn-edit-p"></div>
                </div>
            </form>
        </div>
        ';
    return $result;
}
