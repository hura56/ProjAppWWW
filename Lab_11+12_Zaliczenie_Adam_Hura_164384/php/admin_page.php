<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Adam Hura" />
    <title>MMA moją pasją</title>
    <link rel="stylesheet" href="../css/login.css" />
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="js/kontrast.js" type="text/javascript"></script>
</head>

<body>
<?php
    session_start();
    require_once("../cfg.php"); 
    require_once("../admin/admin.php"); 
    echo FormularzLogowania(); 
    require_once("contact.php"); 
    PrzypomnijHaslo($pass); 

    if(isset($_POST['x1_submit'])) { # jeśli użytkownik wysła formularz logowania, przesyłane dane są filtrowane przy użyciu mysqli_real_escape_string, aby uniknąć ataków SQL injection
        $user = mysqli_real_escape_string($conn, $_POST['login_email']); 
        $password = mysqli_real_escape_string($conn, $_POST['login_pass']);
        
        if($user == $login && $password == $pass) { # sprawdzane są, czy przesłane dane logowania są zgodne z danymi zmiennych $login i $pass
            $_SESSION['user'] = $user;
            $_SESSION['admin_logged_in'] = true;
            header("Location: cms.php"); # jeśli warunek zwraca true, sesja jest ustawiana na zalogowanego użytkownika i przekierowuje na stronę cms.php
        } 
        else { # w przeciwnym razie wyświetlany jest komunikat o błędnych danych i ponownie wywoływany jest formularz logowania.
            echo "Błędne dane. Proszę spróbować ponownie.";
            echo FormularzLogowania();
        }
    } 
    if ((isset($_SESSION['admin_logged_in'])) && ($_SESSION['admin_logged_in']==true)){  # jeśli sesja jest już ustawiona na zalogowanego użytkownika, użytkownik jest przekierowywany 
        header('Location: cms.php'); # bezpośrednio na stronę cms.php.
        exit();
    }
?>

</body>
</html>