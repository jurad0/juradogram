<?php 
    require_once "CRUD/connection.php";
    session_start();
    
    //Comprueba si el mail está seteado, y a continuación le quita los espacios a los lados y guarda el email y la contraseña en los arrays
    if (isset($_POST["email"]) && isset($_POST["email"])) {
        $email = trim($_POST["email"]);
        $pass = $_POST["pass"];
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($connect, $sql);

    
    if ($res && mysqli_num_rows($res) == 1) {
        $usuario = mysqli_fetch_assoc($res);

        //Verifica la contraseña con el metodo "password_verify" y si es valido, te redirije hasta la pagina de welcome
        if (password_verify($pass, $usuario["password"])) {
            $_SESSION["usuario"] = $usuario;
            header("Location: index.php");
        } else {
            $_SESSION["error_login"] = "Login incorrecto";
            header("Location: index.php");
        }
    } else {
        $_SESSION["error_login"] = "Login iiincorrecto";
        header("Location: index.php");
    }
    

?>