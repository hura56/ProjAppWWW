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
        echo EdytujProdukt(); 
        echo ListaProdukt(mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)); 

        if(isset($_POST['btn-edit-p'])){
            $product_id = $_POST['id'];
            $title = $_POST['title']; 
            $description = $_POST['description']; 
            $modify_date = date("Y-m-d H:i:s"); 
            $netto_value = $_POST['netto_value']; 
            $vat = $_POST['vat']; 
            $amount = $_POST['amount']; 
            $category = $_POST['category']; 
            $size = $_POST['size']; 
            $image = $_POST['image'];
            if(isset($_POST['availability_status'])) { 
                $status = 1; 
            } else {
                $status = 0; 
            }
        
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname); 
            $query = "UPDATE products SET title='$title', description='$description', modify_date='$modify_date', 
            netto_value='$netto_value', vat='$vat', amount='$amount', availability_status='$status',
            category='$category', size='$size', image='$image' WHERE id='$product_id'";
            $result = mysqli_query($conn, $query);
            header("Location: edit_product.php"); 
        }
    ?>
</body>
</html>
<?php ob_end_flush(); ?>
