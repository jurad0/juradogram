<?php 

if (isset($_POST["submit"])) {
    require_once("CRUD/connection.php");
    session_start();

    //Recoger los datos
    $username = isset($_POST["username"]) ? mysqli_real_escape_string($connect, $_POST["username"]) : false;
    $mail = isset($_POST["mail"]) ? mysqli_real_escape_string($connect, trim($_POST["mail"])) : false;
    $pass = isset($_POST["password"]) ? mysqli_real_escape_string($connect, $_POST["password"]) : false;
    $desc = isset($_POST["description"]) ? mysqli_real_escape_string($connect, $_POST["description"]) : false;
    
    //var_dump($_POST);

    $arrayErrores = array();
    //Hacemos validadores necesarios

    //Si el nombre de usuario no está vacío y no tiene valor numerico devuleve true
    if (!empty($username) && !is_numeric($username)) {
        $usernameValidado = true;
    } else {
        $usernameValidado = false;
        $arrayErrores["username"] = "El username no es valido";
    }

    //Si el email no está vacío y es valido,  devuelve true

    if (!empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $mailValidado = true;
    } else {
        $mailValidado = false;
        $arrayErrores["mail"] = "El mail no es valido";
    }

    //Si la contraseña no está vacía, devuelve true

    if (!empty($pass)) {
        $passValidado = true;
    } else {
        $passValidado = false;
        $arrayErrores["password"] = "El password no es valido";
    }

    //Cuenta numero de indices en la array de errores, si el valor es igual a 0 guarda el usuario
    $guardarUsuario = false;
    if(count($arrayErrores) == 0) {
        $guardarUsuario = true;
        
        //Utiliza el metodo para hashear la contraseña y el siguiente metodo "PASSWORD_BCRYPT" para encriptarlo 
        $passSegura = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 4]);
        //password_verify($pass, $passSegura);

     //   $sql = "INSERT INTO users VALUES('$username', '$mail', '$passSegura','$desc','$date')";
        $sql = "INSERT INTO users (username, email, password ,description,createDate)VALUES('$username', '$mail', '$passSegura','$desc',NOW())";
        
        
        $guardar = mysqli_query($connect, $sql);

        if ($guardar) {
            $_SESSION["completado"] = "Registro completado";
        } else {
            $_SESSION["errores"]["general"] = "Fallo en el registro";
        }
    } else {
        $_SESSION["errores"] = $arrayErrores;
    }
    header("Location: ../index.php");
}
?>