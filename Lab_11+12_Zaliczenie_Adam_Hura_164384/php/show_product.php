<?php
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
        echo ListaProdukt(mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) 
    ?>
</div>

</body>
</html>