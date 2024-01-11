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
        echo UsunProdukt(); 
        echo ListaProdukt(mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)); 

        if(isset($_POST['btn-delete-p'])){ 
            $category_id = $_POST['id']; 
            $query = "DELETE FROM products WHERE id = '".$category_id."'"; # zapytanie MYSQL usuwa produkt o danym id z bazy
            mysqli_query($conn, $query); 
            header("Location: delete_product.php"); 
            echo ListaProdukt(mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)); 
        }
?>

<?php ob_end_flush(); ?>