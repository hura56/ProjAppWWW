<?php 
    ob_start();
    require_once('../admin/admin.php'); 
    require_once('../cfg.php'); 
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
</head>
<body>
    <?php 
        echo StworzProdukt(); 
        echo ListaProdukt(mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)); 

        if(isset($_POST['btn-create-p'])){ 
            $title = $_POST['title']; 
            $description = $_POST['description']; 
            $creation_date = date("Y-m-d H:i:s"); 
            $modify_date = date("Y-m-d H:i:s"); 
            $netto_value = $_POST['netto_value'];
            $vat = $_POST['vat']; 
            $amount = $_POST['amount']; 
            $availability_status = $_POST['availability_status']; 
            $category = $_POST['category']; 
            $image = $_POST['image'];
            $size = $_POST['size'];

            $query = "INSERT INTO products (title, description, creation_date, modify_date, netto_value, vat, amount, availability_status, category, image, size) 
            VALUES ('".$title."', '".$description."', '".$creation_date."', '".$modify_date."', 
            '".$netto_value."', '".$vat."', '".$amount."', '".$availability_status."', '".$category."', '".$image."', '".$size."')"; # zapytanie SQL dodające nowy wpis w bazie danych
            mysqli_query($conn, $query); 
            header("Location: create_product.php"); 
            echo ListaProdukt(mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)); 
        }
?>

<?php ob_end_flush(); ?>